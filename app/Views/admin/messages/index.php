<?= session()->getFlashdata('error') ?>
<?= session()->getFlashdata('success') ?>

<h2>Cari Kode E-Tiket</h2>
<form action="<?= base_url('messages/search') ?>" method="post">
    <?= csrf_field() ?>
    <input type="text" name="kode" placeholder="Masukkan Kode E-Tiket" required>
    <button type="submit">Cari</button>
</form>