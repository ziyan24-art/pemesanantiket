<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;
use App\Models\UserModel;

class AdminSeeder extends Seeder
{
    public function run()
    {
        $userModel = new UserModel();

        $users = [
            [
                'name' => 'Admin',
                'username' => 'admin',
                'email' => 'admin@example.com',
                'password' => password_hash('admin123', PASSWORD_DEFAULT),
                'role' => 'admin',
                'created_at' => date('Y-m-d H:i:s')
            ],
            [
                'name' => 'Pemilik',
                'username' => 'pemilik',
                'email' => 'pemilik@example.com',
                'password' => password_hash('pemilik123', PASSWORD_DEFAULT),
                'role' => 'pemilik',
                'created_at' => date('Y-m-d H:i:s')
            ]
        ];

        foreach ($users as $user) {
            if (!$userModel->where('email', $user['email'])->first()) {
                $userModel->insert($user);
            }
        }
    }
}
