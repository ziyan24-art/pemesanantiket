<?php

namespace App\Models;

use CodeIgniter\Model;

class TransactionModel extends Model
{
    protected $table            = 'transactions';
    protected $primaryKey       = 'id';

    protected $allowedFields    = [
        'booking_id',
        'payment_method',
        'status',
        'transaction_code',
        'created_at',
        'boarding_status'
    ];

    protected $useTimestamps = false; // Karena pakai default CURRENT_TIMESTAMP dari DB
}
