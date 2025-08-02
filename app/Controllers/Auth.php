<?php

namespace App\Controllers;

use App\Models\UserModel;

class Auth extends BaseController
{
    public function register()
    {
        return view('auth/register');
    }

    public function processRegister()
    {
        $users = new UserModel();

        $email = $this->request->getPost('email');

        // ✅ Cek apakah email sudah digunakan
        if ($users->where('email', $email)->first()) {
            return redirect()->back()->withInput()->with('error', 'Email sudah terdaftar, gunakan email lain.');
        }

        // ✅ Simpan user baru dengan role default = user
        $users->insert([
            'username'   => $this->request->getPost('username'),
            'email'      => $email,
            'password'   => password_hash($this->request->getPost('password'), PASSWORD_DEFAULT),
            'role'       => 'user', // default role
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ]);

        return redirect()->to('/login')->with('success', 'Pendaftaran berhasil, silakan login!');
    }

    public function login()
    {
        return view('auth/login');
    }

    public function processLogin()
    {
        $users = new UserModel();
        $email = $this->request->getPost('email');
        $password = $this->request->getPost('password');

        $user = $users->where('email', $email)->first();

        if ($user && password_verify($password, $user['password'])) {
            // ✅ Set session login
            session()->set([
                'id'        => $user['id'],
                'username'  => $user['username'],
                'role'      => $user['role'],
                'isLoggedIn' => true,
            ]);

            return redirect()->to('/dashboard');
        }

        return redirect()->back()->with('error', 'Login gagal! Email atau password salah.');
    }

    public function logout()
    {
        session()->destroy();
        return redirect()->to('/login')->with('success', 'Anda telah logout.');
    }
}
