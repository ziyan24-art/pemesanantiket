<?= $this->include('layouts/header') ?>
<?= $this->include('layouts/sidebar') ?>
<?= $this->include('layouts/topbar') ?>

<div class="container-fluid" style="margin-left: 250px; margin-top: 70px;"> <!-- supaya sejajar dengan layout -->
    <div class="card shadow">
        <div class="card-body">
            <h4 class="card-title mb-4">📊 Kelola Orderan</h4>

            <!-- ✅ Statistik Order & Search -->
            <div class="d-flex justify-content-between align-items-center mb-3">
                <div>
                    <span class="badge bg-primary p-2">Total Order: <?= count($orders) ?></span>
                </div>
                <div>
                    <form method="get" action="<?= base_url('admin/orders') ?>" class="d-flex">
                        <input type="text" name="search" value="<?= esc($_GET['search'] ?? '') ?>"
                            class="form-control form-control-sm me-2"
                            placeholder="Cari customer / rute...">
                        <button type="submit" class="btn btn-sm btn-secondary">🔍 Cari</button>
                    </form>
                </div>
            </div>

            <?php if (session()->getFlashdata('success')): ?>
                <div class="alert alert-success"><?= session()->getFlashdata('success') ?></div>
            <?php elseif (session()->getFlashdata('error')): ?>
                <div class="alert alert-danger"><?= session()->getFlashdata('error') ?></div>
            <?php endif ?>

            <div class="table-responsive">
                <table class="table table-bordered table-hover">
                    <thead class="table-dark">
                        <tr>
                            <th>Nama Customer</th>
                            <th>Rute</th>
                            <th>Speedboat</th>
                            <th>Jumlah Kursi</th>
                            <th>Total</th>
                            <th>Metode Bayar</th>
                            <th>Bukti Pembayaran</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($orders)): ?>
                            <?php foreach ($orders as $o): ?>
                                <tr>
                                    <td><?= $o['user']['username'] ?? 'Unknown' ?></td>
                                    <td><?= $o['route']['rute'] ?? '-' ?></td>
                                    <td><?= $o['route']['nama_speedboat'] ?? '-' ?></td>
                                    <td><?= $o['booking']['quantity'] ?></td>
                                    <td>Rp <?= number_format($o['booking']['total_price'], 0, ",", ".") ?></td>
                                    <td><?= $o['payment']['nama_bank'] ?? '-' ?></td>
                                    <td>
                                        <?php if (!empty($o['transaction']['payment_proof'])): ?>
                                            <?php
                                            $proofPath = $o['transaction']['payment_proof'];
                                            if (!str_contains($proofPath, 'uploads/bukti')) {
                                                $proofPath = 'uploads/bukti/' . $proofPath;
                                            }
                                            ?>
                                            <a href="<?= base_url($proofPath) ?>" target="_blank">
                                                <img src="<?= base_url($proofPath) ?>"
                                                    alt="Bukti Pembayaran" width="80" class="img-thumbnail">
                                            </a>
                                        <?php else: ?>
                                            <span class="badge bg-secondary">Belum Upload</span>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <?php if (($o['transaction']['status'] ?? '') === 'paid'): ?>
                                            <span class="badge bg-success">Paid</span>
                                        <?php else: ?>
                                            <form method="post" action="<?= base_url('admin/orders/update-status/' . $o['booking']['id']) ?>">
                                                <?= csrf_field() ?>
                                                <select name="status" class="form-select form-select-sm" onchange="this.form.submit()">
                                                    <option value="pending" <?= ($o['transaction']['status'] ?? '') == 'pending' ? 'selected' : '' ?>>Pending</option>
                                                    <option value="paid" <?= ($o['transaction']['status'] ?? '') == 'paid' ? 'selected' : '' ?>>Paid</option>
                                                    <option value="canceled" <?= ($o['transaction']['status'] ?? '') == 'canceled' ? 'selected' : '' ?>>Canceled</option>
                                                </select>
                                            </form>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <a href="<?= base_url('admin/orders/delete/' . $o['booking']['id']) ?>"
                                            onclick="return confirm('Yakin hapus order ini?')"
                                            class="btn btn-danger btn-sm">🗑 Hapus</a>
                                    </td>
                                </tr>
                            <?php endforeach ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="9" class="text-center">Belum ada order.</td>
                            </tr>
                        <?php endif ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<?= $this->include('layouts/footer') ?>