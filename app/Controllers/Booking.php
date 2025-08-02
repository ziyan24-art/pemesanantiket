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

        $ruteModel = new Rute();
        $rute = $ruteModel->find($id);
        if (!$rute) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound('Rute tidak ditemukan.');
        }

        // 🔹 Ambil metode pembayaran aktif
        $paymentModel = new PaymentMethodModel();
        $methods = $paymentModel->where('status', 'aktif')->findAll();

        return view('booking/form', [
            'rute'            => $rute,
            'max_kursi'       => $rute['seat_quota'],
            'harga_per_kursi' => $rute['price'],
            'methods'         => $methods
        ]);
    }

    // Menyimpan data booking dan transaksi
    public function submit()
    {
        $bookingModel     = new BookingModel();
        $transactionModel = new TransactionModel();
        $routeModel       = new Rute();
        $paymentModel     = new PaymentMethodModel();

        // Ambil user ID dari session
        $userId = session('id');
        if (!$userId) {
            return redirect()->to('/login')->with('error', 'Silakan login terlebih dahulu.');
        }

        // Ambil input dari form
        $routeId         = $this->request->getPost('route_id');
        $quantity        = (int) $this->request->getPost('seat_qty');
        $paymentMethodId = $this->request->getPost('payment_method');
        $formTotal       = (int) $this->request->getPost('total_price');
        $departureDate   = $this->request->getPost('departure_date');

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

        // Validasi metode pembayaran
        $paymentMethod = $paymentModel->find($paymentMethodId);
        if (!$paymentMethod) {
            return redirect()->back()->withInput()->with('error', 'Metode pembayaran tidak valid.');
        }

        // Simpan booking
        $bookingData = [
            'user_id'        => $userId,
            'route_id'       => $routeId,
            'departure_date' => $departureDate,
            'quantity'       => $quantity,
            'total_price'    => $expectedTotal
        ];
        $bookingModel->insert($bookingData);
        $bookingId = $bookingModel->getInsertID();

        // Tentukan status transaksi
        $bankName = strtolower($paymentMethod['nama_bank']);
        $isCash   = in_array($bankName, ['loket', 'cash']);
        $status   = $isCash ? 'paid' : 'pending';

        // 🔹 Upload bukti pembayaran jika bukan cash/loket
        $proofFile = $this->request->getFile('payment_proof');
        $proofPath = null;

        if (!$isCash) {
            if (!$proofFile || !$proofFile->isValid()) {
                return redirect()->back()->withInput()->with('error', 'Harap upload bukti pembayaran.');
            }

            if (!in_array($proofFile->getExtension(), ['jpg', 'jpeg', 'png', 'pdf'])) {
                return redirect()->back()->withInput()->with('error', 'Format bukti pembayaran harus JPG, PNG, atau PDF.');
            }

            // Simpan file bukti
            $newName   = $proofFile->getRandomName();
            $proofFile->move('uploads/bukti', $newName);
            $proofPath = 'uploads/bukti/' . $newName;
        }

        // Simpan transaksi
        $transactionData = [
            'booking_id'       => $bookingId,
            'payment_method'   => $paymentMethodId,
            'status'           => $status,
            'transaction_code' => strtoupper(uniqid('ETK')),
            'payment_proof'    => $proofPath
        ];
        $transactionModel->insert($transactionData);

        // Update kuota kursi
        $newQuota = $route['seat_quota'] - $quantity;
        $routeModel->update($routeId, ['seat_quota' => $newQuota]);

        return redirect()->to("/booking/success/{$bookingId}");
    }



    // Menampilkan halaman sukses setelah booking
    public function success($id)
    {
        $bookingModel     = new BookingModel();
        $transactionModel = new TransactionModel();
        $routeModel       = new Rute();
        $paymentModel     = new PaymentMethodModel();

        // Ambil booking dan transaksi
        $booking     = $bookingModel->find($id);
        $transaction = $transactionModel->where('booking_id', $id)->first();

        if (!$booking || !$transaction) {
            return redirect()->to('/')->with('error', 'Data booking tidak ditemukan.');
        }

        // Ambil data rute
        $route = $routeModel->find($booking['route_id']);

        // Ambil data metode pembayaran (jika ada)
        $paymentMethod = null;
        if (!empty($transaction['payment_method'])) {
            $paymentMethod = $paymentModel->find($transaction['payment_method']);
        }

        // Mapping status agar lebih user-friendly
        $statusLabel = [
            'pending' => '⚠️ Menunggu pembayaran',
            'paid'    => '✅ Pembayaran diterima',
        ];

        $transaction['status_label'] = $statusLabel[$transaction['status']] ?? ucfirst($transaction['status']);

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
        $routeModel       = new Rute();

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

        // Ambil data rute
        $route = $routeModel->find($booking['route_id']);

        return view('booking/print', [
            'booking'     => $booking,
            'transaction' => $transaction,
            'route'       => $route
        ]);
    }

    public function riwayat()
    {
        $userId = session()->get('id'); // ✅ ambil user login

        if (!$userId) {
            return redirect()->to('/login')->with('error', 'Silakan login terlebih dahulu.');
        }

        $bookingModel     = new BookingModel();
        $transactionModel = new TransactionModel();
        $routeModel       = new Rute();
        $paymentModel     = new PaymentMethodModel();

        // Ambil semua booking user
        $bookings = $bookingModel->where('user_id', $userId)->orderBy('created_at', 'DESC')->findAll();

        $riwayat = [];
        foreach ($bookings as $b) {
            $transaction = $transactionModel->where('booking_id', $b['id'])->first();
            $route       = $routeModel->find($b['route_id']);
            $payment     = $transaction ? $paymentModel->find($transaction['payment_method']) : null;

            $riwayat[] = [
                'booking'     => $b,
                'transaction' => $transaction,
                'route'       => $route,
                'payment'     => $payment
            ];
        }

        return view('user/riwayat', [
            'riwayat' => $riwayat
        ]);
    }
}
