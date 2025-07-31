<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\PaymentMethodModel;

class PaymentMethod extends BaseController
{
    protected $paymentModel;

    public function __construct()
    {
        $this->paymentModel = new PaymentMethodModel();
    }

    public function index()
    {
        $data['methods'] = $this->paymentModel->findAll();
        return view('admin/payment_method/index', $data);
    }

    public function create()
    {
        return view('admin/payment_method/create');
    }

    public function store()
    {
        $this->paymentModel->save([
            'nama_bank' => $this->request->getPost('nama_bank'),
            'no_rek'    => $this->request->getPost('no_rek'),
            'status'    => $this->request->getPost('status'),
        ]);

        return redirect()->to('/admin/paymentmethod');
    }

    public function edit($id)
    {
        $data['method'] = $this->paymentModel->find($id);
        return view('admin/payment_method/edit', $data);
    }

    public function update($id)
    {
        $this->paymentModel->update($id, [
            'nama_bank' => $this->request->getPost('nama_bank'),
            'no_rek'    => $this->request->getPost('no_rek'),
            'status'    => $this->request->getPost('status'),
        ]);

        return redirect()->to('/admin/paymentmethod');
    }

    public function delete($id)
    {
        $this->paymentModel->delete($id);
        return redirect()->to('/admin/paymentmethod');
    }
}
