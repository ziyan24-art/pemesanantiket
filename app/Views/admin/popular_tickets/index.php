<?= $this->include('layouts/header') ?>
<?= $this->include('layouts/sidebar') ?>
<?= $this->include('layouts/topbar') ?>

<main class="main-content" style="margin-left: 250px; padding: 20px; padding-top: 80px;">
    <div class="container-fluid">
        <!-- Heading -->
        <div class="d-flex justify-content-between align-items-center mb-5 w-100">
            <h2 class="mb-0">🔥 Tiket Populer</h2>
            <div class="text-end" style="min-width: 750px;"> <!-- memastikan tombol tetap di kanan -->
                <a href="<?= base_url('/admin/popular-ticket/create') ?>" class="btn btn-primary">+ Tambah Tiket</a>
            </div>
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

        <!-- Kartu Tiket -->
        <div class="row justify-content-start">
            <?php if (!empty($tickets)): ?>
                <?php foreach ($tickets as $ticket): ?>
                    <div class="col-lg-5 col-md-6 mb-4"> <!-- Lebih lebar dan responsif -->
                        <div class="card h-100 shadow-sm">
                            <img src="<?= base_url($ticket['image']) ?>" class="card-img-top" alt="<?= esc($ticket['route']) ?>" style="height: 250px; object-fit: cover;">
                            <div class="card-body">
                                <h5 class="card-title"><i class="fas fa-map-marker-alt"></i> <?= esc($ticket['route']) ?></h5>
                                <p class="card-text text-success fw-bold">Rp <?= number_format($ticket['price'], 0, ',', '.') ?></p>
                                <a href="<?= base_url('/admin/popular-ticket/edit/' . $ticket['id']) ?>" class="btn btn-warning btn-sm">Edit</a>
                                <a href="<?= base_url('/admin/popular-ticket/delete/' . $ticket['id']) ?>" class="btn btn-danger btn-sm" onclick="return confirm('Yakin ingin menghapus tiket ini?')">Hapus</a>
                            </div>
                        </div>
                    </div>
                <?php endforeach ?>
            <?php else: ?>
                <div class="col-12">
                    <div class="alert alert-info text-center">Belum ada tiket populer.</div>
                </div>
            <?php endif ?>
        </div>
    </div>
</main>

<?= $this->include('layouts/footer') ?>