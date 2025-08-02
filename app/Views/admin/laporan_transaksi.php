<?= $this->include('layouts/header') ?>
<?= $this->include('layouts/sidebar') ?>
<?= $this->include('layouts/topbar') ?>

<div class="container-fluid" style="margin-left: 250px; margin-top: 70px;">
    <div class="card shadow">
        <div class="card-body">
            <h4 class="card-title mb-4">📊 Laporan Transaksi (Paid Only)</h4>

            <!-- 🔹 Filter Tanggal -->
            <form method="get" action="<?= base_url('admin/laporan-transaksi') ?>" class="row g-3 mb-3">
                <div class="col-auto">
                    <label>Dari</label>
                    <input type="date" name="start_date" value="<?= esc($start_date) ?>" class="form-control">
                </div>
                <div class="col-auto">
                    <label>Sampai</label>
                    <input type="date" name="end_date" value="<?= esc($end_date) ?>" class="form-control">
                </div>
                <div class="col-auto align-self-end">
                    <button type="submit" class="btn btn-primary">Filter</button>
                </div>
                <div class="col-auto align-self-end">
                    <a href="<?= base_url('admin/laporan-transaksi/export?start_date=' . esc($start_date) . '&end_date=' . esc($end_date)) ?>" class="btn btn-success">⬇ Excel</a>
                    <a href="<?= base_url('admin/laporan-transaksi/pdf?start_date=' . esc($start_date) . '&end_date=' . esc($end_date)) ?>" class="btn btn-danger">⬇ PDF</a>
                </div>
            </form>

            <div class="table-responsive">
                <table class="table table-bordered table-hover">
                    <thead class="table-dark">
                        <tr>
                            <th>No</th>
                            <th>Kode Transaksi</th>
                            <th>Nama Customer</th>
                            <th>Rute</th>
                            <th>Speedboat</th>
                            <th>Tgl Berangkat</th>
                            <th>Jam Berangkat</th>
                            <th>Jumlah Kursi</th>
                            <th>Total</th>
                            <th>Metode</th>
                            <th>Tanggal Transaksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($laporan)): ?>
                            <?php foreach ($laporan as $i => $l): ?>
                                <tr>
                                    <td><?= $i + 1 ?></td>
                                    <td><?= $l['transaction']['transaction_code'] ?></td>
                                    <td><?= esc($l['user']['username'] ?? '-') ?></td>
                                    <td><?= esc($l['route']['rute'] ?? '-') ?></td>
                                    <td><?= esc($l['route']['nama_speedboat'] ?? '-') ?></td>
                                    <td><?= date('d-m-Y', strtotime($l['booking']['departure_date'])) ?></td>
                                    <td><?= esc($l['route']['jam_berangkat'] ?? '-') ?></td>
                                    <td><?= $l['booking']['quantity'] ?></td>
                                    <td>Rp <?= number_format($l['booking']['total_price'], 0, ',', '.') ?></td>
                                    <td><?= esc($l['payment']['nama_bank'] ?? '-') ?></td>
                                    <td><?= date('d-m-Y H:i', strtotime($l['transaction']['created_at'])) ?></td>
                                </tr>
                            <?php endforeach ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="11" class="text-center">Tidak ada transaksi dalam periode ini.</td>
                            </tr>
                        <?php endif ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>


<?= $this->include('layouts/footer') ?>