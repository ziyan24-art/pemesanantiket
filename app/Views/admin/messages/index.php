<?= $this->include('layouts/header') ?>
<?= $this->include('layouts/sidebar') ?>
<?= $this->include('layouts/topbar') ?>

<main class="content">
    <h1>Konfirmasi E-Tiket</h1>

    <!-- tampilkan flash message -->
    <?php if (session()->getFlashdata('error')): ?>
        <div class="alert alert-danger">
            <?= session()->getFlashdata('error') ?>
        </div>
    <?php endif; ?>

    <?php if (session()->getFlashdata('success')): ?>
        <div class="alert alert-success">
            <?= session()->getFlashdata('success') ?>
        </div>
    <?php endif; ?>

    <!-- form cari e-tiket -->
    <section class="card mt-4 p-3">
        <h2 class="h4">Cari Kode E-Tiket</h2>
        <form action="<?= base_url('messages/search') ?>" method="post" class="d-flex gap-2 mt-2">
            <?= csrf_field() ?>
            <input type="text" name="kode" class="form-control" placeholder="Masukkan Kode E-Tiket" required>
            <button type="submit" class="btn btn-primary">Cari</button>
        </form>
    </section>

    <!-- detail transaksi jika ada -->
    <?php if (isset($transaction)): ?>
        <section class="card mt-4 p-3">
            <h2 class="h4">🧾 Detail Transaksi E-Tiket</h2>
            <table class="table table-bordered mt-3">
                <tr>
                    <td><strong>Kode E-Tiket</strong></td>
                    <td><?= esc($transaction['transaction_code']) ?></td>
                </tr>
                <tr>
                    <td><strong>Nama Penumpang</strong></td>
                    <td><?= esc($transaction['username'] ?? '-') ?></td>
                </tr>
                <tr>
                    <td><strong>Jumlah Tiket</strong></td>
                    <td><?= esc($transaction['quantity'] ?? 0) ?></td>
                </tr>
                <tr>
                    <td><strong>Total Bayar</strong></td>
                    <td>Rp<?= number_format($transaction['total_price'] ?? 0, 0, ',', '.') ?></td>
                </tr>
                <tr>
                    <td><strong>Status Boarding</strong></td>
                    <td><?= ucfirst(esc($transaction['boarding_status'] ?? 'belum')) ?></td>
                </tr>
            </table>

            <?php if (($transaction['boarding_status'] ?? 'belum') !== 'naik'): ?>
                <form action="<?= base_url('messages/confirm') ?>" method="post" class="mt-3">
                    <?= csrf_field() ?>
                    <input type="hidden" name="id" value="<?= $transaction['id'] ?>">
                    <button type="submit" class="btn btn-success"
                        onclick="return confirm('Yakin penumpang ini sudah naik?')">
                        ✅ Konfirmasi Naik
                    </button>
                </form>
            <?php else: ?>
                <p class="mt-3 text-success">✅ Penumpang sudah dikonfirmasi naik.</p>
            <?php endif; ?>
        </section>
    <?php endif; ?>
</main>

<?= $this->include('layouts/footer') ?>