<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\TransactionModel;

class EticketController extends BaseController
{
    protected $transactionModel;

    public function __construct()
    {
        $this->transactionModel = new TransactionModel();
    }

    // Halaman input pencarian e-tiket
    public function index()
    {
        return view('admin/messages/index');
    }

    // Proses pencarian berdasarkan kode e-tiket
    public function search()
    {
        $kode = $this->request->getPost('kode');

        if (!$kode) {
            return redirect()->back()->with('error', 'Silakan masukkan kode e-tiket.');
        }

        // Join ke bookings dan users (jika ingin nama penumpang)
        $transaction = $this->transactionModel
            ->select('transactions.*, bookings.quantity, bookings.total_price, users.username')
            ->join('bookings', 'bookings.id = transactions.booking_id')
            ->join('users', 'users.id = bookings.user_id')
            ->where('transactions.transaction_code', $kode)
            ->first();


        if (!$transaction) {
            return redirect()->back()->with('error', 'Kode E-Tiket tidak ditemukan.');
        }

        return view('admin/messages/result', ['transaction' => $transaction]);
    }


    // Konfirmasi bahwa penumpang sudah naik
    public function confirm()
    {
        $id = $this->request->getPost('id');

        if (!$id) {
            return redirect()->back()->with('error', 'ID transaksi tidak valid.');
        }

        $updated = $this->transactionModel->update($id, [
            'boarding_status' => 'naik',
        ]);

        if (!$updated) {
            return redirect()->back()->with('error', 'Gagal memperbarui status.');
        }

        return redirect()->back()->with('success', 'Penumpang berhasil dikonfirmasi naik.');
    }
}
