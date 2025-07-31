<?= $this->include('layouts/header') ?>
<?= $this->include('layouts/sidebar') ?>
<?= $this->include('layouts/topbar') ?>

<main class="main-content" style="margin-left: 250px; padding: 20px;">
    <div class="container-fluid">
        <h2 class="mb-4">✏️ Edit Rute Speedboat</h2>

        <?php if (session()->has('success')): ?>
            <?= $this->include('layouts/partials/toast') ?>
        <?php endif; ?>

        <div class="card shadow-sm border-0">
            <div class="card-body">
                <form method="post" action="/admin/rute/update/<?= $rute['id'] ?>">
                    <?= csrf_field() ?>

                    <div class="mb-3">
                        <label for="rute" class="form-label">Rute</label>
                        <input type="text" name="rute" id="rute" class="form-control" value="<?= esc($rute['rute']) ?>" required>
                    </div>

                    <div class="mb-3">
                        <label for="jam_berangkat" class="form-label">Jam Berangkat</label>
                        <input type="time" name="jam_berangkat" id="jam_berangkat" class="form-control" value="<?= esc($rute['jam_berangkat']) ?>" required>
                    </div>

                    <div class="mb-3">
                        <label for="perkiraan_tiba" class="form-label">Perkiraan Tiba</label>
                        <input type="time" name="perkiraan_tiba" id="perkiraan_tiba" class="form-control" value="<?= esc($rute['perkiraan_tiba']) ?>" required>
                    </div>

                    <div class="mb-3">
                        <label for="nama_speedboat" class="form-label">Nama Speedboat</label>
                        <input type="text" name="nama_speedboat" id="nama_speedboat" class="form-control" value="<?= esc($rute['nama_speedboat']) ?>" required>
                    </div>

                    <div class="mb-3">
                        <label for="price" class="form-label">Harga Tiket (Rp)</label>
                        <input type="number" name="price" id="price" class="form-control" value="<?= esc($rute['price']) ?>" required>
                    </div>

                    <!-- ✅ Tambahan: Jumlah Kursi -->
                    <div class="mb-3">
                        <label for="seat_quota" class="form-label">Jumlah Kursi</label>
                        <input type="number" name="seat_quota" id="seat_quota" class="form-control" value="<?= esc($rute['seat_quota']) ?>" required min="1">
                    </div>

                    <button type="submit" class="btn btn-success">💾 Simpan Perubahan</button>
                    <a href="/admin/rute" class="btn btn-secondary">Kembali</a>
                </form>
            </div>
        </div>
    </div>
</main>

<?= $this->include('layouts/footer') ?>