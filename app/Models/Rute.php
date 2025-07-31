<?php

namespace App\Models;

use CodeIgniter\Model;

class Rute extends Model
{
    protected $table = 'rute';
    protected $primaryKey = 'id';

    protected $allowedFields = [
        'rute',
        'jam_berangkat',
        'perkiraan_tiba',
        'nama_speedboat',
        'price',
        'seat_quota' // ✅ tambahkan ini
    ];
}
