<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pemesanan Berhasil</title>
    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <style>
        body {
            background: #f7f9fc;
            font-family: 'Inter', sans-serif;
            margin: 0;
            padding: 0;
        }

        .success-card {
            max-width: 750px;
            margin: 60px auto;
            border-radius: 16px;
            overflow: hidden;
            border: none;
            box-shadow: 0 8px 24px rgba(0, 0, 0, 0.08);
            animation: fadeInUp 0.8s ease-in-out;
        }

        .success-header {
            background: linear-gradient(135deg, #28a745, #20c997);
            color: white;
            padding: 40px 20px;
            text-align: center;
        }

        .success-header h3 {
            margin: 0;
            font-weight: bold;
        }

        .success-header p {
            margin-top: 8px;
            font-size: 15px;
            opacity: 0.9;
        }

        .ticket-info p {
            margin-bottom: 8px;
            font-size: 16px;
        }

        .ticket-code {
            background: #f8f9fa;
            border: 2px dashed #6c757d;
            padding: 18px;
            border-radius: 12px;
            text-align: center;
            font-size: 22px;
            font-weight: bold;
            letter-spacing: 2px;
            color: #212529;
        }

        .btn-print {
            background: #28a745;
            border: none;
            font-weight: 600;
            padding: 12px 22px;
            border-radius: 10px;
        }

        .btn-print:hover {
            background: #218838;
        }

        .btn-back {
            background: #6c757d;
            border: none;
            font-weight: 600;
            padding: 12px 22px;
            border-radius: 10px;
            margin-left: 10px;
        }

        .btn-back:hover {
            background: #5a6268;
        }

        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
    </style>
</head>

<body>
    <div class="card success-card">
        <div class="success-header">
            <h3><i class="fa-solid fa-circle-check"></i> Pemesanan Berhasil!</h3>
            <p class="mb-0">Terima kasih telah melakukan pemesanan tiket speedboat 🚤</p>
        </div>
        <div class="card-body p-4">
            <h5 class="mb-3"><i class="fa-solid fa-ticket"></i> Detail Tiket</h5>
            <div class="ticket-info">
                <p><strong><i class="fa-solid fa-user-group"></i> Jumlah Penumpang:</strong> <?= $booking['quantity'] ?></p>
                <p><strong><i class="fa-solid fa-money-bill-wave"></i> Total:</strong> Rp<?= number_format($booking['total_price'], 0, ',', '.') ?></p>

                <?php if (!empty($booking['departure_date'])): ?>
                    <p><strong><i class="fa-solid fa-calendar-day"></i> Tanggal Keberangkatan:</strong>
                        <?= date('d-m-Y', strtotime($booking['departure_date'])) ?>
                    </p>
                <?php endif; ?>

                <?php if (!empty($route) && !empty($route['jam_berangkat'])): ?>
                    <p><strong><i class="fa-solid fa-clock"></i> Jam Keberangkatan:</strong>
                        <?= date('H:i', strtotime($route['jam_berangkat'])) ?> WIB
                    </p>
                <?php endif; ?>
            </div>

            <hr>
            <h5 class="mb-3"><i class="fa-solid fa-credit-card"></i> Detail Pembayaran</h5>
            <?php if (!empty($paymentMethod)): ?>
                <p><strong>Bank:</strong> <?= esc($paymentMethod['nama_bank']) ?></p>
                <p><strong>No Rekening:</strong> <?= esc($paymentMethod['no_rek']) ?></p>
                <p><strong>Status:</strong>
                    <?php
                    $badgeClass = 'warning';
                    $statusMessage = '';

                    switch ($transaction['status']) {
                        case 'paid':
                            $badgeClass = 'success';
                            $statusMessage = '<small class="text-success">✅ Pembayaran sudah diterima, tiket Anda aktif.</small>';
                            break;
                        case 'pending':
                            $badgeClass = 'warning';
                            $statusMessage = '<small class="text-warning">⚠️ Menunggu pembayaran. Silakan selesaikan pembayaran agar tiket aktif.</small>';
                            break;
                        case 'failed':
                            $badgeClass = 'danger';
                            $statusMessage = '<small class="text-danger">❌ Pembayaran gagal. Silakan coba lagi atau gunakan metode lain.</small>';
                            break;
                        default:
                            $badgeClass = 'secondary';
                            $statusMessage = '<small class="text-muted">ℹ️ Status tidak diketahui.</small>';
                            break;
                    }
                    ?>
                    <span class="badge bg-<?= $badgeClass ?> px-3 py-2">
                        <?= ucfirst($transaction['status']) ?>
                    </span>
                </p>

                <?= $statusMessage ?>


            <?php else: ?>
                <p><strong>Metode:</strong> <?= ucfirst($transaction['payment_method']) ?></p>
                <p><strong>Status:</strong>
                    <span class="badge bg-<?= $transaction['status'] == 'paid' ? 'success' : 'warning' ?> px-3 py-2">
                        <?= ucfirst($transaction['status']) ?>
                    </span>
                </p>
            <?php endif; ?>

            <hr>
            <h5 class="mb-3"><i class="fa-solid fa-barcode"></i> Kode E-Tiket</h5>
            <div class="ticket-code mb-3">
                <?= $transaction['transaction_code'] ?>
            </div>

            <div class="d-flex justify-content-center mt-4">
                <a href="/booking/print/<?= $transaction['transaction_code'] ?>" class="btn btn-print" target="_blank">
                    <i class="fa-solid fa-print"></i> Print / Download Tiket
                </a>
                <a href="/" class="btn btn-back">
                    <i class="fa-solid fa-house"></i> Kembali ke Beranda
                </a>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>