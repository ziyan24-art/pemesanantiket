<?php

namespace App\Models;

use CodeIgniter\Model;

class PaymentMethodModel extends Model
{
    protected $table      = 'payment_methods';
    protected $primaryKey = 'id';

    protected $useTimestamps = true;

    protected $allowedFields = ['nama_bank', 'no_rek', 'status'];
}
