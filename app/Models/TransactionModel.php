<?php

namespace App\Models;

use CodeIgniter\Model;

class TransactionModel extends Model
{
    protected $table      = 'transactions';
    protected $primaryKey = 'id';

    protected $allowedFields = [
        'booking_id',
        'payment_method',
        'status',
        'transaction_code',
        'payment_proof',     // bukti transfer
        'boarding_status',
        'created_at',
        'updated_at'
    ];

    // ✅ Aktifkan otomatis timestamp
    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = '';
}
