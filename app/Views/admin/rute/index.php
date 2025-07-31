<?= $this->include('layouts/header') ?>
<?= $this->include('layouts/sidebar') ?>
<?= $this->include('layouts/topbar') ?>

<main class="main-content" style="margin-left: 250px; padding: 20px; padding-top: 80px;">
    <div class="container-fluid">
        <!-- Heading -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2>🗺️ Data Rute Speedboat</h2>
            <a href="<?= base_url('/admin/rute/create') ?>" class="btn btn-primary">+ Tambah Rute</a>
        </div>

        <!-- Flash Success -->
        <?php if (session()->getFlashdata('success')): ?>
            <div class="position-fixed bottom-0 end-0 p-3" style="z-index: 1055;">
                <div id="autoDismissToast" class="toast align-items-center text-white bg-success border-0 show" role="alert" aria-live="assertive" aria-atomic="true">
                    <div class="d-flex">
                        <div class="toast-body">
                            <?= esc(session()->getFlashdata('success')) ?>
                        </div>
                        <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
                    </div>
                </div>
            </div>
            <script>
                window.addEventListener('DOMContentLoaded', () => {
                    const toastEl = document.getElementById('autoDismissToast');
                    if (toastEl) {
                        const toast = new bootstrap.Toast(toastEl, {
                            delay: 3000
                        });
                        toast.show();
                    }
                });
            </script>
        <?php endif; ?>

        <!-- Tabel Rute -->
        <div class="table-responsive bg-white shadow-sm rounded p-3">
            <table class="table table-bordered table-hover align-middle mb-0">
                <thead class="table-dark">
                    <tr>
                        <th>No</th>
                        <th>Rute</th>
                        <th>Jam Berangkat</th>
                        <th>Perkiraan Tiba</th>
                        <th>Nama Speedboat</th>
                        <th>Harga / Tiket</th>
                        <th>Jumlah Kursi</th>
                        <th style="width: 140px;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($rute)): ?>
                        <?php foreach ($rute as $i => $r): ?>
                            <tr>
                                <td><?= $i + 1 ?></td>
                                <td><?= esc($r['rute']) ?></td>
                                <td><?= esc($r['jam_berangkat']) ?></td>
                                <td><?= esc($r['perkiraan_tiba']) ?></td>
                                <td><?= esc($r['nama_speedboat']) ?></td>
                                <td>Rp<?= number_format($r['price'], 0, ',', '.') ?></td>
                                <td><?= esc($r['seat_quota']) ?></td>
                                <td>
                                    <a href="<?= base_url('/admin/rute/edit/' . $r['id']) ?>" class="btn btn-sm btn-warning">Edit</a>
                                    <a href="<?= base_url('/admin/rute/delete/' . $r['id']) ?>" class="btn btn-sm btn-danger" onclick="return confirm('Yakin ingin menghapus data ini?')">Hapus</a>
                                </td>
                            </tr>
                        <?php endforeach ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="7" class="text-center text-muted">Belum ada data rute.</td>
                        </tr>
                    <?php endif ?>
                </tbody>
            </table>
        </div>
    </div>
</main>

<?= $this->include('layouts/footer') ?>