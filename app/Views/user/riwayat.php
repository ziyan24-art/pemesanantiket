<!-- LOADING ANIMATION -->
<div id="loader-wrapper">
    <div id="loader-content">
        <i class="fas fa-ship ship-icon"></i>
        <div class="progress-bar">
            <div class="progress-fill"></div>
        </div>
    </div>
</div>


<!-- header: tombol kembali + judul -->
<div class="riwayat-header">
    <a href="javascript:history.back()" class="btn-back">⬅ Kembali</a>
    <h2 class="riwayat-title">📑 Riwayat Transaksi</h2>
</div>

<div class="riwayat-container">

    <?php if (!empty($riwayat)): ?>
        <?php foreach ($riwayat as $r): ?>
            <div class="riwayat-card">
                <!-- kiri gambar -->
                <div class="riwayat-img">
                    <?php if (!empty($r['transaction']['payment_proof'])): ?>
                        <a href="<?= base_url($r['transaction']['payment_proof']) ?>" target="_blank">
                            <img src="<?= base_url($r['transaction']['payment_proof']) ?>"
                                alt="Bukti" class="bukti-img">
                        </a>
                    <?php else: ?>
                        <span class="badge">Cash</span>
                    <?php endif; ?>
                </div>

                <!-- kanan detail -->
                <div class="riwayat-detail">
                    <h3><?= esc($r['route']['rute'] ?? '-') ?></h3>
                    <p class="sub"><?= esc($r['route']['nama_speedboat'] ?? '-') ?></p>
                    <p class="kode">Kode: <?= esc($r['transaction']['transaction_code'] ?? '-') ?></p>

                    <ul>
                        <li>🗓 <?= date('d-m-Y', strtotime($r['booking']['departure_date'])) ?></li>
                        <li>💺 Kursi: <?= $r['booking']['quantity'] ?></li>
                        <li>💰 <strong>Rp <?= number_format($r['booking']['total_price'], 0, ",", ".") ?></strong></li>
                        <li>🏦 <?= $r['payment']['nama_bank'] ?? '-' ?></li>
                    </ul>

                    <!-- status -->
                    <div class="status">
                        <?php if (($r['transaction']['status'] ?? '') === 'paid'): ?>
                            <span class="st-paid">✔ Paid</span>
                        <?php elseif (($r['transaction']['status'] ?? '') === 'pending'): ?>
                            <span class="st-pending">⏳ Pending</span>
                        <?php elseif (($r['transaction']['status'] ?? '') === 'canceled'): ?>
                            <span class="st-canceled">✘ Canceled</span>
                        <?php else: ?>
                            <span class="st-none">-</span>
                        <?php endif; ?>
                    </div>

                    <!-- tombol aksi -->
                    <div class="action-btns">
                        <?php if (!empty($r['transaction']['transaction_code'])): ?>
                            <a href="/booking/print/<?= esc($r['transaction']['transaction_code']) ?>"
                                class="btn btn-print" target="_blank">
                                <i class="fa-solid fa-print"></i> Lihat E-Tiket
                            </a>
                        <?php else: ?>
                            <span class="badge bg-secondary">Belum ada E-Tiket</span>
                        <?php endif; ?>
                    </div>



                </div>
            </div>
        <?php endforeach ?>
    <?php else: ?>
        <div class="no-data">Belum ada transaksi.</div>
    <?php endif; ?>

</div>

<style>
    /* header: tombol kembali + judul */
    .riwayat-header {
        max-width: 900px;
        margin: 20px auto 0;
        padding: 0 20px;
        display: flex;
        align-items: center;
        justify-content: space-between;
    }

    .btn-back {
        text-decoration: none;
        padding: 6px 14px;
        border-radius: 8px;
        font-size: 0.85rem;
        font-weight: bold;
        background: #ecf0f1;
        color: #2c3e50;
        transition: all 0.2s ease;
        white-space: nowrap;
    }

    .btn-back:hover {
        background: #bdc3c7;
    }

    .riwayat-title {
        font-size: 1.6rem;
        font-weight: bold;
        color: #2c3e50;
        text-align: center;
        flex: 1;
        margin: 0;
        position: relative;
    }

    .riwayat-title::after {
        content: "";
        display: block;
        width: 80px;
        height: 3px;
        background: #3498db;
        margin: 8px auto 0;
        border-radius: 5px;
    }

    /* container grid */
    .riwayat-container {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(260px, 1fr));
        gap: 20px;
        padding: 20px;
        max-width: 900px;
        margin: 0 auto;
    }

    /* card */
    .riwayat-card {
        background: #fff;
        border-radius: 15px;
        box-shadow: 0 6px 15px rgba(0, 0, 0, 0.1);
        display: flex;
        padding: 12px;
        aspect-ratio: 1/1;
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }

    .riwayat-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 20px rgba(0, 0, 0, 0.2);
    }

    /* kiri gambar */
    .riwayat-img {
        flex: 0 0 100px;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-right: 12px;
    }

    .riwayat-img img {
        width: 95px;
        height: 95px;
        border-radius: 10px;
        object-fit: cover;
        transition: transform 0.3s ease;
    }

    .riwayat-img img:hover {
        transform: scale(1.1);
    }

    /* kanan detail */
    .riwayat-detail {
        flex: 1;
        display: flex;
        flex-direction: column;
    }

    .riwayat-detail h3 {
        margin: 0;
        font-size: 1rem;
        color: #333;
    }

    .riwayat-detail .sub {
        margin: 2px 0;
        font-size: 0.85rem;
        color: #777;
    }

    .riwayat-detail .kode {
        font-size: 0.75rem;
        color: #aaa;
    }

    .riwayat-detail ul {
        list-style: none;
        padding: 0;
        margin: 8px 0;
        font-size: 0.85rem;
        color: #444;
    }

    .riwayat-detail ul li {
        margin-bottom: 3px;
    }

    /* status badge */
    .status {
        margin-top: auto;
        text-align: right;
    }

    .status span {
        padding: 4px 8px;
        border-radius: 6px;
        font-size: 0.75rem;
        font-weight: bold;
    }

    .st-paid {
        background: #d4f8d4;
        color: #2e7d32;
    }

    .st-pending {
        background: #fff3cd;
        color: #856404;
    }

    .st-canceled {
        background: #f8d7da;
        color: #721c24;
    }

    .st-none {
        background: #e0e0e0;
        color: #555;
    }

    /* tombol aksi */
    .action-btns {
        display: flex;
        gap: 10px;
        margin-top: 10px;
        justify-content: flex-end;
    }

    .action-btns .btn {
        text-decoration: none;
        padding: 8px 14px;
        border-radius: 10px;
        font-size: 0.8rem;
        font-weight: bold;
        display: inline-flex;
        align-items: center;
        gap: 6px;
        transition: all 0.25s ease;
    }

    /* tombol e-tiket */
    .btn-etiket {
        background: linear-gradient(135deg, #3498db, #2980b9);
        color: #fff;
        box-shadow: 0 3px 6px rgba(52, 152, 219, 0.3);
    }

    .btn-etiket:hover {
        background: linear-gradient(135deg, #2980b9, #1f6391);
        box-shadow: 0 4px 10px rgba(41, 128, 185, 0.4);
        transform: translateY(-2px);
    }

    /* tombol e-tiket status pending (abu2) */
    .btn-etiket.btn-disabled {
        background: linear-gradient(135deg, #95a5a6, #7f8c8d);
        box-shadow: none;
    }

    /* tombol print */
    .btn-print {
        background: linear-gradient(135deg, #2ecc71, #27ae60);
        color: #fff;
        box-shadow: 0 3px 6px rgba(46, 204, 113, 0.3);
    }

    .btn-print:hover {
        background: linear-gradient(135deg, #27ae60, #1e8449);
        box-shadow: 0 4px 10px rgba(39, 174, 96, 0.4);
        transform: translateY(-2px);
    }

    /* teks jika kosong */
    .no-data {
        grid-column: 1 / -1;
        text-align: center;
        color: #888;
        padding: 20px;
    }

    /* Loader */
    #loader-wrapper {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: #fff;
        display: flex;
        align-items: center;
        justify-content: center;
        z-index: 9999;
    }

    #loader-content {
        text-align: center;
    }

    #loader-content .ship-icon {
        font-size: 3rem;
        color: #3498db;
        margin-bottom: 15px;
        animation: bounce 1.2s infinite;
    }

    .progress-bar {
        width: 200px;
        height: 6px;
        background: #eee;
        border-radius: 4px;
        overflow: hidden;
        margin: 0 auto;
    }

    .progress-fill {
        width: 0;
        height: 100%;
        background: linear-gradient(90deg, #3498db, #2980b9);
        animation: loading 2s infinite;
    }

    @keyframes loading {
        0% {
            width: 0;
        }

        50% {
            width: 100%;
        }

        100% {
            width: 0;
        }
    }

    @keyframes bounce {

        0%,
        100% {
            transform: translateY(0);
        }

        50% {
            transform: translateY(-8px);
        }
    }
</style>

<!-- Loader fade out -->
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

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">