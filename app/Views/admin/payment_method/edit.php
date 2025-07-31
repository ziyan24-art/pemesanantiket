<?= $this->include('layouts/header') ?>
<?= $this->include('layouts/sidebar') ?>
<?= $this->include('layouts/topbar') ?>

<div class="container-fluid" style="margin-left: 250px; margin-top: 70px;">
    <div class="card shadow">
        <div class="card-body">
            <h4 class="card-title mb-4">✏️ Edit Metode Pembayaran</h4>

            <form method="post" action="/admin/paymentmethod/update/<?= $method['id']; ?>">
                <div class="mb-3">
                    <label class="form-label">Nama Bank</label>
                    <input type="text" name="nama_bank" class="form-control" value="<?= esc($method['nama_bank']); ?>" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">No Rekening</label>
                    <input type="text" name="no_rek" class="form-control" value="<?= esc($method['no_rek']); ?>" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Status</label>
                    <select name="status" class="form-select">
                        <option value="aktif" <?= $method['status'] == 'aktif' ? 'selected' : '' ?>>Aktif</option>
                        <option value="nonaktif" <?= $method['status'] == 'nonaktif' ? 'selected' : '' ?>>Nonaktif</option>
                    </select>
                </div>

                <button type="submit" class="btn btn-primary">🔄 Update</button>
                <a href="/admin/paymentmethod" class="btn btn-secondary">Batal</a>
            </form>
        </div>
    </div>
</div>

<?= $this->include('layouts/footer') ?>