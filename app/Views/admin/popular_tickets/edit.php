<?= $this->include('layouts/header') ?>
<?= $this->include('layouts/sidebar') ?>
<?= $this->include('layouts/topbar') ?>

<main class="main-content" style="margin-left: 250px; padding: 20px; padding-top: 80px;">
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-lg-10"> <!-- Ubah dari col-lg-8 -->
                <div class="card shadow-sm">
                    <div class="card-header bg-warning text-dark">
                        <h5 class="mb-0">Edit Tiket Populer</h5>
                    </div>
                    <div class="card-body">
                        <form action="<?= base_url('admin/popular-ticket/update/' . $ticket['id']) ?>" method="post" enctype="multipart/form-data">
                            <?= csrf_field() ?>

                            <div class="mb-3">
                                <label for="route" class="form-label">Nama Rute</label>
                                <input type="text" class="form-control" id="route" name="route" value="<?= esc($ticket['route']) ?>" required>
                            </div>

                            <div class="mb-3">
                                <label for="price" class="form-label">Harga</label>
                                <input type="number" class="form-control" id="price" name="price" value="<?= esc($ticket['price']) ?>" required>
                            </div>

                            <div class="mb-3">
                                <label for="image" class="form-label">Gambar Baru (opsional)</label>
                                <input type="file" class="form-control" id="image" name="image" accept="image/*">
                            </div>

                            <?php if (!empty($ticket['image'])): ?>
                                <div class="mb-3">
                                    <label class="form-label">Gambar Sekarang:</label><br>
                                    <img src="<?= base_url($ticket['image']) ?>" alt="Gambar Tiket" class="img-thumbnail" style="max-width: 200px;">
                                </div>
                            <?php endif; ?>

                            <div class="d-flex justify-content-between">
                                <a href="<?= base_url('admin/popular-ticket') ?>" class="btn btn-secondary">Kembali</a>
                                <button type="submit" class="btn btn-success">Update</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>

<?= $this->include('layouts/footer') ?>