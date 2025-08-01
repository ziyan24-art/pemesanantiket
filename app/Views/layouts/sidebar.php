<div class="sidebar" role="navigation" aria-label="Admin Sidebar">
    <h2 class="sidebar-title">🚍 E-Tiket</h2>
    <nav>
        <ul class="sidebar-menu">
            <li><a href="/dashboard" class="sidebar-link" title="Dashboard">🏠 Dashboard</a></li>

            <?php if (session('role') === 'admin'): ?>
                <li><a href="/admin/users" class="sidebar-link" title="Kelola User">👥 Kelola User</a></li>
                <li><a href="/admin/rute" class="sidebar-link" title="Kelola Rute">🗺️ Kelola Rute</a></li>
                <li><a href="/messages" class="sidebar-link" title="Kelola Pesan & Konfirmasi E-Tiket">✉️ Konfirmasi E-Tiket</a></li>
                <li><a href="/admin/popular-ticket" class="sidebar-link" title="Kelola Tiket Populer">⚙️ Kelola Tiket Populer</a></li>
                <li>
                    <a href="<?= base_url('admin/paymentmethod') ?>" class="sidebar-link" title="Kelola Metode Pembayaran">
                        ⚙️ Kelola Metode Pembayaran
                    </a>
                </li>
                <li>
                    <a href="<?= base_url('admin/orders') ?>" class="sidebar-link" title="Kelola Orderan">
                        📊 Kelola Orderan
                    </a>
                </li>
                <li>
                    <a href="<?= base_url('admin/laporan-transaksi') ?>" class="sidebar-link" title="Laporan Transaksi">
                        📊 Laporan Transaksi
                    </a>
                </li>
                <!-- ❌ Admin tidak bisa akses Pemasukan -->

            <?php elseif (session('role') === 'pemilik'): ?>
                <!-- Pemilik hanya bisa lihat laporan -->
                <li>
                    <a href="<?= base_url('admin/laporan-transaksi') ?>" class="sidebar-link" title="Laporan Transaksi">
                        📊 Laporan Transaksi
                    </a>
                </li>
                <li>
                    <a href="<?= base_url('admin/pemasukan') ?>"
                        class="sidebar-link <?= (url_is('admin/pemasukan')) ? 'active' : '' ?>"
                        title="Laporan Pemasukan">
                        📊 Pemasukan
                    </a>
                </li>
            <?php endif; ?>

            <li><a href="/logout" class="sidebar-link logout" title="Logout">🚪 Logout</a></li>
        </ul>
    </nav>
</div>