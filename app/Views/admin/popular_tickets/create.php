<?= $this->include('layouts/header') ?>
<?= $this->include('layouts/sidebar') ?>
<?= $this->include('layouts/topbar') ?>

<main class="main-content" style="margin-left: 250px; padding: 20px; padding-top: 80px;">
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-lg-20"> <!-- Diperbesar dari col-lg-8 -->
                <div class="card shadow-sm">
                    <div class="card-header bg-primary text-white">
                        <h5 class="mb-0">Tambah Tiket Populer</h5>
                    </div>
                    <div class="card-body">
                        <form action="<?= base_url('admin/popular-ticket/store') ?>" method="post" enctype="multipart/form-data">
                            <?= csrf_field() ?>

                            <div class="mb-3">
                                <label for="route" class="form-label">Nama Rute</label>
                                <input type="text" class="form-control" id="route" name="route" required>
                            </div>

                            <div class="mb-3">
                                <label for="price" class="form-label">Harga</label>
                                <input type="number" class="form-control" id="price" name="price" required>
                            </div>

                            <div class="mb-3">
                                <label for="image" class="form-label">Gambar</label>
                                <input type="file" class="form-control" id="image" name="image" accept="image/*" required>
                            </div>

                            <div class="d-flex justify-content-between">
                                <a href="<?= base_url('admin/popular-ticket') ?>" class="btn btn-secondary">Kembali</a>
                                <button type="submit" class="btn btn-primary">Simpan</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

    </div>
</main>

<?= $this->include('layouts/footer') ?>