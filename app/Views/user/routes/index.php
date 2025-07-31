<?= $this->include('layout/header') ?>
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">
<!-- Loading Screen -->
<div id="loading-screen">
    <div class="logo-container">
        <i class="fas fa-ship fa-3x text-white mb-3"></i>
        <p class="text-white">AdamBoat</p>
        <div class="progress-bar"></div>
    </div>
</div>


<style>
    body {
        font-family: 'Inter', sans-serif;
        margin: 0;
        padding: 0;
        background: url('/images/image.png') no-repeat center center fixed;
        background-size: cover;
        position: relative;
    }

    /* Blur background for the whole page */
    .background-blur-overlay {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        backdrop-filter: blur(6px);
        background-color: rgba(255, 255, 255, 0.25);
        z-index: 0;
    }

    /* Everything else stays above the blur */
    header,
    footer,
    .container,
    .card-custom,
    .main-wrapper {
        position: relative;
        z-index: 1;
    }

    .fade-in {
        opacity: 0;
        transform: translateY(20px);
        animation: fadeInUp 0.6s ease forwards;
    }

    @keyframes fadeInUp {
        to {
            opacity: 1;
            transform: none;
        }
    }

    .section-title {
        font-size: 2.2rem;
        font-weight: 700;
        margin-bottom: 3rem;
        text-align: center;
        color: #fff;
        text-shadow: 1px 1px 3px rgba(0, 0, 0, 0.4);
    }

    .card-custom {
        border: none;
        border-radius: 16px;
        background-color: rgba(255, 255, 255, 0.95);
        transition: transform 0.2s ease, box-shadow 0.3s ease;
        max-width: 500px;
        margin: 0 auto;
        display: flex;
        flex-direction: column;
        overflow: hidden;
        backdrop-filter: blur(4px);
    }

    .card-custom {
        margin-bottom: 1.5rem;
        /* atau 24px */
    }


    .card-custom:hover {
        transform: translateY(-5px);
        box-shadow: 0 12px 25px rgba(0, 0, 0, 0.12);
    }

    .card-body-custom {
        padding: 30px 25px 20px;
        flex: 1;
    }

    .card-title {
        font-size: 1.6rem;
        margin-bottom: 1rem;
        margin-top: 0.3rem;
        color: #333;
    }

    .card-text {
        margin-bottom: 15px;
        color: #444;
    }

    .badge-status {
        display: inline-block;
        padding: 6px 14px;
        font-size: 13px;
        border-radius: 12px;
        font-weight: 600;
        color: #fff;
        margin-bottom: 1rem;
    }

    .badge-terisi {
        background-color: #dc3545;
    }

    .badge-tersedia {
        background-color: #28a745;
    }

    .btn-modern {
        display: flex;
        align-items: center;
        justify-content: center;
        width: 100%;
        padding: 14px;
        font-size: 18px;
        font-weight: 600;
        background: linear-gradient(135deg, #007bff, #0056b3);
        color: white;
        border: none;
        border-top: 1px solid rgba(0, 0, 0, 0.05);
        border-bottom-left-radius: 16px;
        border-bottom-right-radius: 16px;
        transition: background 0.3s ease, transform 0.2s ease;
        text-decoration: none;
        text-align: center;
    }

    .btn-modern:hover {
        background: linear-gradient(135deg, #0056b3, #003d80);
        transform: scale(1.01);
    }

    @media (max-width: 480px) {
        .swal2-popup.swal2-mobile {
            width: 90% !important;
            font-size: 0.9rem;
        }

        .swal2-title {
            font-size: 1.3rem !important;
        }

        .swal2-html-container {
            font-size: 1rem !important;
        }

        .swal2-confirm {
            font-size: 1rem !important;
            padding: 0.6rem 1.2rem !important;
        }
    }

    @media (min-width: 481px) {
        .swal2-popup.swal2-mobile {
            max-width: 400px !important;
            font-size: 1rem;
        }
    }

    #loading-screen {
        position: fixed;
        top: 0;
        left: 0;
        width: 100vw;
        height: 100vh;
        background-color: #ffffff;
        display: flex;
        justify-content: center;
        align-items: center;
        flex-direction: column;
        z-index: 9999;
    }

    .logo-container {
        text-align: center;
        animation: fadeIn 1s ease-in-out;
    }

    .logo-container i {
        color: #007bff;
        /* biru cerah */
        font-size: 48px;
    }

    .progress-bar {
        margin-top: 20px;
        width: 200px;
        height: 6px;
        background-color: #eee;
        border-radius: 10px;
        overflow: hidden;
        position: relative;
    }

    .progress-bar::before {
        content: "";
        position: absolute;
        left: -40%;
        width: 50%;
        height: 100%;
        background-color: #007bff;
        animation: loading 2s infinite;
    }

    @keyframes loading {
        0% {
            left: -50%;
        }

        50% {
            left: 100%;
        }

        100% {
            left: -50%;
        }
    }

    @keyframes fadeIn {
        from {
            opacity: 0;
            transform: scale(0.95);
        }

        to {
            opacity: 1;
            transform: scale(1);
        }
    }
</style>

<!-- Blur overlay (pindahkan ke sini, paling atas setelah body) -->
<div class="background-blur-overlay"></div>

<div class="container py-5">
    <h2 class="section-title fade-in">🌊 Daftar Rute Speedboat</h2>

    <div class="d-flex flex-column gap-4 align-items-center">
        <?php foreach ($routes as $index => $route): ?>
            <div class="fade-in" style="animation-delay: <?= $index * 0.1 ?>s;">
                <div class="card card-custom shadow-sm text-center">
                    <div class="card-body card-body-custom">
                        <h5 class="fw-bold card-title"><?= esc($route['rute']) ?></h5>

                        <?php if (($route['seat_quota'] ?? 0) <= 0): ?>
                            <span class="badge-status badge-terisi">Penuh</span>
                        <?php else: ?>
                            <span class="badge-status badge-tersedia">Tersedia</span>
                        <?php endif; ?>

                        <p class="card-text">⏰ Berangkat: <strong><?= esc(date('H:i', strtotime($route['jam_berangkat']))) ?></strong></p>
                        <p class="card-text">🕓 Tiba: <strong><?= esc(date('H:i', strtotime($route['perkiraan_tiba']))) ?></strong></p>
                        <p class="card-text">🚤 Speedboat: <strong><?= esc($route['nama_speedboat']) ?></strong></p>
                        <p class="card-text">👥 Penumpang: <strong><?= esc($route['seat_quota'] ?? 0) ?></strong></p>
                        <p class="card-text">💸 Harga: <strong>Rp <?= number_format($route['price'], 0, ',', '.') ?></strong></p>
                    </div>

                    <?php $isLoggedIn = session()->get('isLoggedIn') === true; ?>

                    <a
                        href="<?= $isLoggedIn ? base_url('booking/form/' . $route['id']) : 'javascript:void(0)' ?>"
                        class="btn btn-modern"
                        onclick="<?= $isLoggedIn ? '' : 'showLoginAlert()' ?>">
                        Pesan Sekarang
                    </a>

                </div>
            </div>
        <?php endforeach ?>
    </div>
</div>

<?= $this->include('layout/footer') ?>


<script>
    function showLoginAlert() {
        Swal.fire({
            title: 'Login Diperlukan',
            text: 'Silakan login terlebih dahulu untuk memesan tiket.',
            icon: 'warning',
            confirmButtonText: 'Login Sekarang',
            width: 'auto', // biarkan SweetAlert menyesuaikan otomatis
            customClass: {
                popup: 'swal2-mobile'
            }
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = '<?= base_url("login") ?>';
            }
        });
    }
</script>
<script>
    window.addEventListener("load", function() {
        const loader = document.getElementById("loading-screen");

        // Tambahkan delay sebelum mulai menghilangkan loader
        setTimeout(() => {
            loader.style.transition = "opacity 0.5s ease";
            loader.style.opacity = "0";
            setTimeout(() => {
                loader.style.display = "none";
            }, 500); // Setelah fade selesai, hilangkan elemen
        }, 500); // Delay semu 500ms sebelum mulai fade
    });
</script>