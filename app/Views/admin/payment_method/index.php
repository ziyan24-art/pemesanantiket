<?= $this->include('layouts/header') ?>
<?= $this->include('layouts/sidebar') ?>
<?= $this->include('layouts/topbar') ?>

<div class="container-fluid" style="margin-left: 250px; margin-top: 70px;"> <!-- supaya sejajar dengan layout -->
    <div class="card shadow">
        <div class="card-body">
            <h4 class="card-title mb-4">💳 Kelola Metode Pembayaran</h4>

            <a href="/admin/paymentmethod/create" class="btn btn-primary mb-3">+ Tambah Metode</a>

            <?php if (session()->getFlashdata('success')): ?>
                <div class="alert alert-success"><?= session()->getFlashdata('success') ?></div>
            <?php endif ?>

            <div class="table-responsive">
                <table class="table table-bordered table-hover">
                    <thead class="table-dark">
                        <tr>
                            <th>No</th>
                            <th>Nama Bank</th>
                            <th>No Rekening</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($methods)): ?>
                            <?php foreach ($methods as $i => $m): ?>
                                <tr>
                                    <td><?= $i + 1 ?></td>
                                    <td><?= esc($m['nama_bank']) ?></td>
                                    <td><?= esc($m['no_rek']) ?></td>
                                    <td>
                                        <?php if ($m['status'] === 'aktif'): ?>
                                            <span class="badge bg-success">Aktif</span>
                                        <?php else: ?>
                                            <span class="badge bg-secondary">Nonaktif</span>
                                        <?php endif ?>
                                    </td>
                                    <td>
                                        <a href="/admin/paymentmethod/edit/<?= $m['id'] ?>" class="btn btn-warning btn-sm">Edit</a>
                                        <a href="/admin/paymentmethod/delete/<?= $m['id'] ?>" onclick="return confirm('Yakin hapus metode ini?')" class="btn btn-danger btn-sm">Hapus</a>
                                    </td>
                                </tr>
                            <?php endforeach ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="5" class="text-center">Belum ada metode pembayaran.</td>
                            </tr>
                        <?php endif ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<?= $this->include('layouts/footer') ?>