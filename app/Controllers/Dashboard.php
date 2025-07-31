<?php

namespace App\Controllers;

use App\Models\Rute;
use App\Models\PopularTicket;

class Dashboard extends BaseController
{
    public function index()
    {
        if (!session()->get('isLoggedIn')) {
            return redirect()->to('/login');
        }

        $role = session()->get('role');

        switch ($role) {
            case 'admin':
                return view('dashboard/admin', ['title' => 'Dashboard Admin']);

            case 'user':
                $ruteModel = new Rute();
                $popularTicketModel = new PopularTicket();

                $data = [
                    'title' => 'Dashboard User',
                    'rute' => $ruteModel->orderBy('jam_berangkat', 'ASC')->findAll(5),
                    'popularTickets' => $popularTicketModel->findAll(),
                ];

                return view('user/dashboard', $data);

            case 'pemilik':
                return view('dashboard/pemilik', ['title' => 'Dashboard Pemilik']);

            default:
                return redirect()->to('/login');
        }
    }
}
