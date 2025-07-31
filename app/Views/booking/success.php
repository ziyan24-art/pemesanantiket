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

        /* Card Success */
        .success-card {
            max-width: 700px;
            margin: 80px auto;
            border-radius: 16px;
            overflow: hidden;
            border: none;
            animation: fadeInUp 0.8s ease-in-out;
        }

        .success-header {
            background: linear-gradient(135deg, #28a745, #20c997);
            color: white;
            padding: 30px;
            text-align: center;
        }

        .success-header h3 {
            margin: 0;
            font-weight: bold;
        }

        .ticket-info p {
            margin-bottom: 8px;
            font-size: 16px;
        }

        .ticket-code {
            background: #f1f3f6;
            border: 2px dashed #6c757d;
            padding: 15px;
            border-radius: 10px;
            text-align: center;
            font-size: 20px;
            font-weight: bold;
            letter-spacing: 2px;
        }

        .btn-print {
            background: #28a745;
            border: none;
            font-weight: 600;
            padding: 10px 20px;
        }

        .btn-print:hover {
            background: #218838;
        }

        .btn-back {
            background: #6c757d;
            border: none;
            font-weight: 600;
            padding: 10px 20px;
            margin-left: 10px;
        }

        .btn-back:hover {
            background: #5a6268;
        }

        /* Animasi muncul */
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
    <div class="card shadow success-card">
        <div class="success-header">
            <h3>✅ Pemesanan Berhasil!</h3>
            <p class="mb-0">Terima kasih telah melakukan pemesanan tiket speedboat</p>
        </div>
        <div class="card-body">
            <div class="ticket-info">
                <p><strong>Jumlah Penumpang:</strong> <?= $booking['quantity'] ?></p>
                <p><strong>Total:</strong> Rp<?= number_format($booking['total_price'], 0, ',', '.') ?></p>

                <?php if (!empty($booking['departure_date'])): ?>
                    <p><strong>Tanggal Keberangkatan:</strong>
                        <?= date('d-m-Y', strtotime($booking['departure_date'])) ?>
                    </p>
                <?php endif; ?>

                <?php if (!empty($route) && !empty($route['jam_berangkat'])): ?>
                    <p><strong>Jam Keberangkatan:</strong>
                        <?= date('H:i', strtotime($route['jam_berangkat'])) ?> WIB
                    </p>
                <?php endif; ?>
            </div>

            <hr>
            <h5 class="mb-3">Detail Pembayaran</h5>
            <?php if (!empty($paymentMethod)): ?>
                <p><strong>Bank:</strong> <?= esc($paymentMethod['nama_bank']) ?></p>
                <p><strong>No Rekening:</strong> <?= esc($paymentMethod['no_rek']) ?></p>
                <p><strong>Status:</strong>
                    <span class="badge bg-<?= $transaction['status'] == 'paid' ? 'success' : 'warning' ?>">
                        <?= ucfirst($transaction['status']) ?>
                    </span>
                </p>
            <?php else: ?>
                <p><strong>Metode:</strong> <?= ucfirst($transaction['payment_method']) ?></p>
                <p><strong>Status:</strong> <?= ucfirst($transaction['status']) ?></p>
            <?php endif; ?>

            <hr>
            <h5 class="mb-3">Kode E-Tiket</h5>
            <div class="ticket-code mb-3">
                <?= $transaction['transaction_code'] ?>
            </div>

            <div class="d-flex justify-content-center">
                <a href="/booking/print/<?= $transaction['transaction_code'] ?>" class="btn btn-print" target="_blank">
                    🖨 Print / Download Tiket
                </a>
                <a href="/" class="btn btn-back">
                    ⬅ Kembali ke Beranda
                </a>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>