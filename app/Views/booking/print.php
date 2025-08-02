<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>E-Tiket Speedboat</title>
    <style>
        body {
            font-family: "Segoe UI", Arial, sans-serif;
            background: #f5f7fa;
            padding: 40px;
            display: flex;
            justify-content: center;
        }

        .ticket {
            background: #fff;
            border: 2px dashed #2c3e50;
            border-radius: 12px;
            width: 520px;
            padding: 25px 30px;
            box-shadow: 0 6px 16px rgba(0, 0, 0, 0.1);
            position: relative;
        }

        .ticket::before,
        .ticket::after {
            content: "";
            position: absolute;
            width: 20px;
            height: 20px;
            background: #f5f7fa;
            border-radius: 50%;
            top: 50%;
            transform: translateY(-50%);
        }

        .ticket::before {
            left: -11px;
        }

        .ticket::after {
            right: -11px;
        }

        h2 {
            text-align: center;
            margin-bottom: 20px;
            color: #2c3e50;
        }

        .ticket p {
            margin: 8px 0;
            font-size: 15px;
            color: #333;
        }

        .highlight {
            font-weight: bold;
            color: #007bff;
        }

        .ticket-code {
            text-align: center;
            margin: 20px 0;
            font-size: 22px;
            font-weight: bold;
            letter-spacing: 2px;
            color: #2c3e50;
            background: #eef2f7;
            padding: 10px;
            border-radius: 8px;
            border: 1px solid #ccc;
        }

        em {
            display: block;
            margin-top: 15px;
            text-align: center;
            font-size: 13px;
            color: #555;
        }
    </style>
</head>

<body>
    <div class="ticket">
        <h2>🎫 E-Tiket Speedboat</h2>

        <p><strong>Kode Tiket:</strong> <span class="highlight"><?= $transaction['transaction_code'] ?></span></p>
        <p><strong>Jumlah Penumpang:</strong> <?= $booking['quantity'] ?></p>
        <p><strong>Total Harga:</strong> Rp<?= number_format($booking['total_price'], 0, ',', '.') ?></p>

        <?php if (!empty($route['asal']) && !empty($route['tujuan'])): ?>
            <p><strong>Rute:</strong> <?= $route['asal'] ?> ➝ <?= $route['tujuan'] ?></p>
        <?php endif; ?>

        <?php if (!empty($booking['departure_date']) && !empty($route['jam_berangkat'])): ?>
            <p><strong>Keberangkatan:</strong>
                <?= date('d-m-Y', strtotime($booking['departure_date'])) ?> |
                <?= date('H:i', strtotime($route['jam_berangkat'])) ?> WIB
            </p>
        <?php elseif (!empty($booking['departure_date'])): ?>
            <p><strong>Tanggal Keberangkatan:</strong>
                <?= date('d-m-Y', strtotime($booking['departure_date'])) ?>
            </p>
        <?php elseif (!empty($route['jam_berangkat'])): ?>
            <p><strong>Jam Keberangkatan:</strong>
                <?= date('H:i', strtotime($route['jam_berangkat'])) ?> WIB
            </p>
        <?php endif; ?>

        <div class="ticket-code">
            <?= strtoupper($transaction['transaction_code']) ?>
        </div>

        <em>Tunjukkan tiket ini saat naik speedboat 🚤</em>
        <em>*Tolong Konfirmasi tiket 30 menit sebelum keberangkatan</em>
    </div>

    <script>
        window.print();
    </script>
</body>

</html>