<?= $this->include('layout/header') ?>

<!-- Swiper CSS -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />
<!-- Swiper JS -->
<script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>

<style>
    html,
    body {
        height: 100%;
        margin: 0;
        scroll-behavior: smooth;
        overflow: auto;
        font-family: 'Segoe UI', sans-serif;
        background-color: #f5f5f5;
    }

    .fullpage-container {
        height: 100vh;
        overflow-y: auto;
        scroll-snap-type: y mandatory;
        scroll-behavior: smooth;
    }

    .fullpage-section {
        scroll-snap-align: start;
        min-height: 100vh;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-direction: column;
        opacity: 0;
        transform: translateY(20px);
        transition: all 0.6s ease-in-out;
    }

    .fullpage-section.active {
        opacity: 1;
        transform: translateY(0);
    }

    .section {
        padding: 20px 20px;
        width: 100%;
    }

    .table-box {
        max-height: 50vh;
        overflow-y: auto;
    }

    .grid-cards {
        display: flex;
        flex-wrap: wrap;
        gap: 20px;
        justify-content: center;
    }

    .ticket-card {
        background-color: #fff;
        border-radius: 10px;
        overflow: hidden;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        width: 280px;
        display: flex;
        flex-direction: column;
    }

    .ticket-card img {
        width: 100%;
        height: 200px;
        object-fit: cover;
    }

    .ticket-card .card-content {
        padding: 20px;
        text-align: center;
        flex-grow: 1;
        display: flex;
        flex-direction: column;
        justify-content: center;
    }

    .ticket-card h3 {
        margin: 0;
        font-size: 18px;
        color: #333;
    }

    .ticket-card .price {
        margin-top: 8px;
        font-size: 16px;
        color: #007bff;
        font-weight: bold;
    }

    @media (max-width: 768px) {
        .section {
            padding: 15px;
        }

        .ticket-card {
            width: 100%;
            max-width: 90vw;
        }

        .ticket-card img {
            height: 160px;
        }
    }

    .rute-section {
        align-items: flex-start !important;
        padding-top: 30px !important;
        padding-bottom: 60px !important;
    }

    .rute-container {
        margin-top: 100px;
    }

    .hero-container {
        margin-top: 150px;
    }

    .harga-container {
        margin-top: 40px;
    }

    .cta-container {
        margin-top: 200px;
    }
</style>

<!-- LOADING ANIMATION -->
<div id="loader-wrapper">
    <div id="loader-content">
        <i class="fas fa-ship ship-icon"></i>
        <div class="progress-bar">
            <div class="progress-fill"></div>
        </div>
    </div>
</div>

<div class="fullpage-container">

    <!-- HERO -->
    <section class="hero-ticket fullpage-section">
        <div class="overlay">
            <div class="container hero-content hero-container">
                <h1>🚤 Selamat Datang di <span class="brand">AdamBoat</span></h1>
                <p class="subtitle">Pesan tiket kapal cepat dengan mudah, aman, dan praktis.</p>
                <a href="<?= base_url('user/routes') ?>" class="btn-search">
                    <i class="fas fa-ticket-alt"></i> Pesan Tiket Sekarang
                </a>
            </div>
        </div>
    </section>

    <!-- JADWAL KEBERANGKATAN -->
    <section class="section bg-white fullpage-section">
        <div class="container rute-container">
            <h2 class="section-title"><i class="fas fa-calendar-alt"></i> Jadwal Keberangkatan</h2>
            <div class="table-box">
                <table>
                    <thead>
                        <tr>
                            <th><i class="fas fa-route"></i> Rute</th>
                            <th><i class="fas fa-clock"></i> Berangkat</th>
                            <th><i class="fas fa-flag-checkered"></i> Tiba</th>
                            <th><i class="fas fa-ship"></i> Kapal</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($rute)): ?>
                            <?php foreach ($rute as $row): ?>
                                <tr>
                                    <td><?= esc($row['rute']) ?></td>
                                    <td><?= date('H:i', strtotime($row['jam_berangkat'])) ?></td>
                                    <td><?= date('H:i', strtotime($row['perkiraan_tiba'])) ?></td>
                                    <td><?= esc($row['nama_speedboat']) ?></td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="4" class="text-center text-muted">Tidak ada jadwal keberangkatan saat ini.</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </section>

    <!-- HARGA TIKET -->
    <section class="section blue-bg fullpage-section">
        <div class="container harga-container">
            <h2 class="section-title text-white"><i class="fas fa-money-bill-wave"></i> Harga Tiket Populer</h2>
            <div class="grid-cards">
                <?php foreach ($popularTickets as $ticket): ?>
                    <div class="card ticket-card">
                        <img src="<?= base_url($ticket['image']) ?>" alt="<?= esc($ticket['route']) ?>">
                        <div class="card-content">
                            <h3><i class="fas fa-map-marker-alt"></i> <?= esc($ticket['route']) ?></h3>
                            <p class="price">Rp <?= number_format($ticket['price'], 0, ',', '.') ?></p>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </section>

    <!-- RUTE POPULER -->
    <section class="section bg-light fullpage-section rute-section">
        <div class="container rute-container">
            <h2 class="section-title"><i class="fas fa-map-signs"></i> Rute Populer</h2>
            <ul class="rute-list">
                <?php if (!empty($rute)) : ?>
                    <?php foreach ($rute as $item) : ?>
                        <li><i class="fas fa-anchor"></i> <?= esc($item['rute']) ?></li>
                    <?php endforeach; ?>
                <?php else : ?>
                    <li>Tidak ada rute yang tersedia.</li>
                <?php endif; ?>
            </ul>
        </div>
    </section>


    <!-- CTA -->
    <section class="section cta-section fullpage-section" style="margin-top: -40px;">
        <div class="container text-center cta-container">
            <h2 class="text-blue"><i class="fas fa-phone-volume"></i> Butuh Bantuan?</h2>
            <p class="text-blue">Hubungi layanan pelanggan kami 24/7 di <strong>0812-3456-7890</strong> atau email <strong>info@adamboat.com</strong></p>
        </div>
    </section>

</div>

<?= $this->include('layout/footer') ?>

<!-- Loading Animation Fade-out -->
<script>
    window.addEventListener('load', function() {
        const loaderWrapper = document.getElementById('loader-wrapper');
        if (loaderWrapper) {
            loaderWrapper.style.transition = 'opacity 0.5s ease';
            loaderWrapper.style.opacity = '0';
            setTimeout(() => loaderWrapper.style.display = 'none', 500);
        }
    });
</script>

<!-- Scroll Observer -->
<script>
    const sections = document.querySelectorAll('.fullpage-section');

    const observer = new IntersectionObserver(entries => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.classList.add('active');
            }
        });
    }, {
        threshold: 0.3
    });

    sections.forEach(section => {
        observer.observe(section);
    });
</script>