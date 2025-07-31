<?php

namespace App\Filters;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Filters\FilterInterface;

class RoleFilter implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        $session = session();
        $userRole = $session->get('role');

        // Jika tidak login, redirect ke login
        if (!$userRole) {
            return redirect()->to('/login');
        }

        // Jika filter dipakai dan role tidak sesuai
        if ($arguments && !in_array($userRole, $arguments)) {
            return redirect()->to('/')->with('error', 'Akses ditolak!');
        }

        // Jika lolos, lanjutkan
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // Tidak perlu after logic
    }
}
