<?php

namespace App\Controllers\User;

use App\Controllers\BaseController;

use App\Models\Rute;

class RouteController extends BaseController
{
    public function index()
    {
        $model = new Rute();
        $routes = $model->findAll();

        return view('user/routes/index', [
            'title' => 'Daftar Rute',
            'routes' => $routes
        ]);
    }
}
