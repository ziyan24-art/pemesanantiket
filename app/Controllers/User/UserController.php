<?php

namespace App\Controllers\User;

use App\Controllers\BaseController;

class UserController extends BaseController
{
    public function index()
    {
        return view('user/dashboard', [
            'title' => 'Dashboard User'
        ]);
    }
}
