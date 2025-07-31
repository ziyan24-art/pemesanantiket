<?php

namespace App\Controllers;

use App\Models\BookingModel;
use App\Models\TransactionModel;
use App\Models\PaymentMethodModel;
use App\Models\Rute;

class Booking extends BaseController
{
    // Menampilkan halaman form pilih rute
    public function index()
    {
        $ruteModel = new Rute();
        $rutes = $ruteModel->findAll();

        return view('booking/form', ['rutes' => $rutes]);
    }

    // Menampilkan form booking berdasarkan rute terpilih
    public function form($id)
    {
        if (!session()->get('isLoggedIn')) {
            return redirect()->to('/login')->with('error', 'Silakan login terlebih dahulu untuk memesan tiket.');
        }

        $ruteModel = new \App\Models\Rute();
        $rute = $ruteModel->find($id);
        if (!$rute) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound('Rute tidak ditemukan.');
        }

        // 🔹 ambil metode pembayaran aktif
        $paymentModel = new PaymentMethodModel();
        $methods = $paymentModel->where('status', 'aktif')->findAll();

        return view('booking/form', [
            'rute' => $rute,
            'max_kursi' => $rute['seat_quota'],
            'harga_per_kursi' => $rute['price'],
            'methods' => $methods
        ]);
    }

    // Menyimpan data booking dan transaksi
    public function submit()
    {
        $bookingModel     = new BookingModel();
        $transactionModel = new TransactionModel();
        $routeModel       = new Rute();
        $paymentModel     = new \App\Models\PaymentMethodModel();

        // Ambil user ID dari session
        $userId = session('id');
        if (!$userId) {
            return redirect()->to('/login')->with('error', 'Silakan login terlebih dahulu.');
        }

        // Ambil input dari form
        $routeId         = $this->request->getPost('route_id');
        $quantity        = (int) $this->request->getPost('seat_qty');
        $paymentMethodId = $this->request->getPost('payment_method'); // ID dari tabel payment_methods
        $formTotal       = (int) $this->request->getPost('total_price');
        $departureDate   = $this->request->getPost('departure_date'); // ✅ tambahkan tanggal

        // Validasi tanggal keberangkatan
        if (!$departureDate || !strtotime($departureDate)) {
            return redirect()->back()->withInput()->with('error', 'Tanggal keberangkatan tidak valid.');
        }

        // Validasi rute
        $route = $routeModel->find($routeId);
        if (!$route) {
            return redirect()->back()->with('error', 'Rute tidak ditemukan.');
        }

        // Validasi kuota kursi
        if (!isset($route['seat_quota']) || $quantity > $route['seat_quota']) {
            return redirect()->back()->withInput()->with('error', 'Jumlah kursi melebihi kuota tersedia.');
        }

        // Hitung total harga
        $expectedTotal = $route['price'] * $quantity;
        if ($formTotal !== $expectedTotal) {
            return redirect()->back()->withInput()->with('error', 'Total pembayaran tidak valid.');
        }

        // Cek apakah metode pembayaran valid
        $paymentMethod = $paymentModel->find($paymentMethodId);
        if (!$paymentMethod) {
            return redirect()->back()->withInput()->with('error', 'Metode pembayaran tidak valid.');
        }

        // Simpan booking
        $bookingData = [
            'user_id'        => $userId,
            'route_id'       => $routeId,
            'departure_date' => $departureDate, // ✅ simpan tanggal
            'quantity'       => $quantity,
            'total_price'    => $expectedTotal
        ];
        $bookingModel->insert($bookingData);
        $bookingId = $bookingModel->getInsertID();

        // Status transaksi: kalau bayar di loket = pending, kalau transfer = waiting_payment
        $status = (strtolower($paymentMethod['nama_bank']) === 'loket' || strtolower($paymentMethod['nama_bank']) === 'cash')
            ? 'pending'
            : 'waiting_payment';

        // Simpan transaksi
        $transactionData = [
            'booking_id'       => $bookingId,
            'payment_method'   => $paymentMethodId, // simpan ID metode
            'status'           => $status,
            'transaction_code' => strtoupper(uniqid('ETK'))
        ];
        $transactionModel->insert($transactionData);

        // Update kuota kursi
        $newQuota = $route['seat_quota'] - $quantity;
        $routeModel->update($routeId, ['seat_quota' => $newQuota]);

        // Redirect ke success
        return redirect()->to("/booking/success/{$bookingId}");
    }



    // Menampilkan halaman sukses setelah booking
    public function success($id)
    {
        $bookingModel     = new BookingModel();
        $transactionModel = new TransactionModel();
        $routeModel       = new \App\Models\Rute();
        $paymentModel     = new \App\Models\PaymentMethodModel();

        $booking     = $bookingModel->find($id);
        $transaction = $transactionModel->where('booking_id', $id)->first();

        if (!$booking || !$transaction) {
            return redirect()->to('/')->with('error', 'Data booking tidak ditemukan.');
        }

        // Ambil data rute terkait
        $route = $routeModel->find($booking['route_id']);

        // Ambil data metode pembayaran
        $paymentMethod = null;
        if (!empty($transaction['payment_method'])) {
            $paymentMethod = $paymentModel->find($transaction['payment_method']);
        }

        return view('booking/success', [
            'booking'       => $booking,
            'transaction'   => $transaction,
            'route'         => $route,
            'paymentMethod' => $paymentMethod
        ]);
    }



    // Menampilkan halaman cetak tiket
    public function print($code)
    {
        $transactionModel = new TransactionModel();
        $bookingModel     = new BookingModel();
        $routeModel       = new \App\Models\Rute();

        // Cari transaksi berdasarkan kode
        $transaction = $transactionModel->where('transaction_code', $code)->first();
        if (!$transaction) {
            return redirect()->to('/')->with('error', 'Tiket tidak ditemukan.');
        }

        // Ambil data booking
        $booking = $bookingModel->find($transaction['booking_id']);
        if (!$booking) {
            return redirect()->to('/')->with('error', 'Data booking tidak ditemukan.');
        }

        // Ambil data rute terkait
        $route = $routeModel->find($booking['route_id']);

        return view('booking/print', [
            'booking'     => $booking,
            'transaction' => $transaction,
            'route'       => $route
        ]);
    }
}
