<?= $this->include('layouts/header') ?>
<?= $this->include('layouts/sidebar') ?>
<?= $this->include('layouts/topbar') ?>

<main class="content">
    <h1>Welcome <?= htmlspecialchars(session()->get('username')) ?></h1>
    <p>Selamat datang di dashboard admin Anda. Gunakan menu di samping untuk navigasi.</p>
</main>

<?= $this->include('layouts/footer') ?>