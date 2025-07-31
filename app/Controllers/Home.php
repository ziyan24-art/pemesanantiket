<?php

namespace App\Controllers;

use App\Models\Rute;
use App\Models\PopularTicket; // Tambahkan model tiket populer
use CodeIgniter\Controller;

class Home extends Controller
{
    public function index()
    {
        $ruteModel = new Rute();
        $popularTicketModel = new PopularTicket();

        $data['rute'] = $ruteModel->orderBy('jam_berangkat', 'ASC')->findAll(5);
        $data['popularTickets'] = $popularTicketModel->findAll(); // Ambil semua tiket populer

        return view('user/dashboard', $data);
    }
}
