<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\BookingModel;
use App\Models\TransactionModel;
use App\Models\Rute;
use App\Models\UserModel;
use App\Models\PaymentMethodModel;

class OrderController extends BaseController
{
    public function index()
    {
        $bookingModel     = new BookingModel();
        $transactionModel = new TransactionModel();
        $routeModel       = new Rute();
        $userModel        = new UserModel();
        $paymentModel     = new PaymentMethodModel();

        // Ambil semua booking
        $bookings = $bookingModel->orderBy('created_at', 'DESC')->findAll();

        // Gabungkan dengan transaksi, user, rute
        $data = [];
        foreach ($bookings as $b) {
            $transaction = $transactionModel->where('booking_id', $b['id'])->first();
            $user        = $userModel->find($b['user_id']);
            $route       = $routeModel->find($b['route_id']); // route_id -> relasi ke tabel rute
            $payment     = $transaction ? $paymentModel->find($transaction['payment_method']) : null;

            $data[] = [
                'booking'     => $b,
                'transaction' => $transaction,
                'user'        => $user,
                'route'       => $route,
                'payment'     => $payment,
            ];
        }

        return view('admin/orders/index', ['orders' => $data]);
    }

    // Update status transaksi
    public function updateStatus($id)
    {
        $transactionModel = new TransactionModel();

        $transaction = $transactionModel->where('booking_id', $id)->first();
        if (!$transaction) {
            return redirect()->back()->with('error', 'Transaksi tidak ditemukan.');
        }

        $newStatus = $this->request->getPost('status');

        $transactionModel->update($transaction['id'], [
            'status' => $newStatus
        ]);

        return redirect()->back()->with('success', 'Status order berhasil diperbarui.');
    }

    // Hapus order + transaksi
    public function delete($id)
    {
        $bookingModel     = new BookingModel();
        $transactionModel = new TransactionModel();

        $transactionModel->where('booking_id', $id)->delete();
        $bookingModel->delete($id);

        return redirect()->back()->with('success', 'Order berhasil dihapus.');
    }
}
