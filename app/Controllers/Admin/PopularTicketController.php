<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\PopularTicket;

class PopularTicketController extends BaseController
{
    protected $popularTicket;

    public function __construct()
    {
        $this->popularTicket = new PopularTicket();
    }

    public function index()
    {
        $data['tickets'] = $this->popularTicket->findAll();
        return view('admin/popular_tickets/index', $data);
    }

    public function create()
    {
        return view('admin/popular_tickets/create');
    }

    public function store()
    {
        $validation = \Config\Services::validation();
        $rules = [
            'route' => 'required',
            'price' => 'required|numeric',
            'image' => 'uploaded[image]|is_image[image]|max_size[image,2048]'
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $validation->getErrors());
        }

        $image = $this->request->getFile('image');
        $imageName = $image->getRandomName();
        $image->move('uploads/popular/', $imageName);

        $this->popularTicket->save([
            'route' => $this->request->getPost('route'),
            'price' => $this->request->getPost('price'),
            'image' => 'uploads/popular/' . $imageName
        ]);

        return redirect()->to('/admin/popular-ticket')->with('success', 'Tiket populer berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $ticket = $this->popularTicket->find($id);
        if (!$ticket) {
            return redirect()->to('/admin/popular-ticket')->with('error', 'Tiket tidak ditemukan.');
        }

        return view('admin/popular_tickets/edit', ['ticket' => $ticket]);
    }

    public function update($id)
    {
        $ticket = $this->popularTicket->find($id);
        if (!$ticket) {
            return redirect()->to('/admin/popular-ticket')->with('error', 'Tiket tidak ditemukan.');
        }

        $validation = \Config\Services::validation();
        $rules = [
            'route' => 'required',
            'price' => 'required|numeric',
            'image' => 'permit_empty|is_image[image]|max_size[image,2048]'
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $validation->getErrors());
        }

        $data = [
            'route' => $this->request->getPost('route'),
            'price' => $this->request->getPost('price'),
        ];

        $image = $this->request->getFile('image');
        if ($image && $image->isValid() && !$image->hasMoved()) {
            $imageName = $image->getRandomName();
            $image->move('uploads/popular/', $imageName);
            $data['image'] = 'uploads/popular/' . $imageName;

            // Hapus gambar lama jika ada
            if (is_file($ticket['image'])) {
                unlink($ticket['image']);
            }
        }

        $this->popularTicket->update($id, $data);
        return redirect()->to('/admin/popular-ticket')->with('success', 'Tiket populer berhasil diperbarui.');
    }

    public function delete($id)
    {
        $ticket = $this->popularTicket->find($id);
        if (!$ticket) {
            return redirect()->to('/admin/popular-ticket')->with('error', 'Tiket tidak ditemukan.');
        }

        // Hapus gambar dari penyimpanan
        if (is_file($ticket['image'])) {
            unlink($ticket['image']);
        }

        $this->popularTicket->delete($id);
        return redirect()->to('/admin/popular-ticket')->with('success', 'Tiket populer berhasil dihapus.');
    }
}
