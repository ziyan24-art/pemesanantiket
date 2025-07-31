<?php

namespace App\Models;

use CodeIgniter\Model;

class BookingModel extends Model
{
    protected $table            = 'bookings';
    protected $primaryKey       = 'id';

    protected $allowedFields    = [
        'user_id',
        'route_id',
        'quantity',
        'departure_date',
        'total_price',
        'created_at'
    ];

    protected $useTimestamps = false; // Karena kita pakai default CURRENT_TIMESTAMP dari DB
}
