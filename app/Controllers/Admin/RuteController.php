<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\Rute;

class RuteController extends BaseController
{
    protected $ruteModel;

    public function __construct()
    {
        $this->ruteModel = new Rute();
    }

    public function index()
    {
        $data['rute'] = $this->ruteModel->findAll();
        return view('admin/rute/index', $data);
    }

    public function create()
    {
        return view('admin/rute/create');
    }

    public function store()
    {
        $data = $this->request->getPost([
            'rute',
            'jam_berangkat',
            'perkiraan_tiba',
            'nama_speedboat',
            'price',
            'seat_quota', // ✅ Tambahan jumlah kursi
        ]);

        $ruteModel = new \App\Models\Rute(); // Pastikan ini sesuai dengan nama model kamu
        $ruteModel->insert($data);

        return redirect()->to('/admin/rute')->with('success', 'Rute berhasil ditambahkan!');
    }



    public function edit($id)
    {
        $rute = $this->ruteModel->find($id);

        if (!$rute) {
            return redirect()->to('/admin/rute')->with('error', 'Rute tidak ditemukan.');
        }

        return view('admin/rute/edit', ['rute' => $rute]);
    }

    public function update($id)
    {
        $model = new Rute();
        $model->update($id, [
            'rute'            => $this->request->getPost('rute'),
            'jam_berangkat'   => $this->request->getPost('jam_berangkat'),
            'perkiraan_tiba'  => $this->request->getPost('perkiraan_tiba'),
            'nama_speedboat'  => $this->request->getPost('nama_speedboat'),
            'price'           => $this->request->getPost('price'),
            'seat_quota'      => $this->request->getPost('seat_quota'), // Ganti langsung
        ]);

        return redirect()->to('/admin/rute')->with('success', 'Rute berhasil diupdate');
    }



    public function delete($id)
    {
        $rute = $this->ruteModel->find($id);

        if (!$rute) {
            return redirect()->to('/admin/rute')->with('error', 'Rute tidak ditemukan.');
        }

        $this->ruteModel->delete($id);

        return redirect()->to('/admin/rute')->with('success', 'Rute berhasil dihapus.');
    }
}
