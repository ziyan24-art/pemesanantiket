<?php

namespace App\Models;

use CodeIgniter\Model;

class PopularTicket extends Model
{
    protected $table = 'popular_tickets';
    protected $primaryKey = 'id';
    protected $allowedFields = ['route', 'price', 'image'];
    protected $useTimestamps = true;
}
