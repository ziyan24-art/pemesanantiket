<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Form Pembayaran</title>
    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <style>
        body {
            font-family: 'Segoe UI', sans-serif;
            margin: 0;
            padding: 0;
            position: relative;
            min-height: 100vh;
            overflow-x: hidden;
        }

        body::before {
            content: "";
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-image: url('/images/image.png');
            background-size: cover;
            background-position: center;
            filter: blur(6px);
            z-index: -1;
            opacity: 0.7;
        }

        .container {
            max-width: 800px;
            background-color: #fff;
            margin: 40px auto;
            padding: 30px;
            border-radius: 12px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        }

        h2 {
            text-align: center;
            color: #333;
            margin-bottom: 30px;
        }

        form {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
        }

        form .full {
            grid-column: span 2;
        }

        label {
            font-weight: bold;
            color: #444;
            display: block;
            margin-bottom: 6px;
        }

        input,
        select,
        textarea {
            width: 100%;
            padding: 10px 12px;
            border: 1px solid #ccc;
            border-radius: 6px;
            font-size: 14px;
            transition: border 0.3s ease;
        }

        input:focus,
        select:focus,
        textarea:focus {
            border-color: #4CAF50;
            outline: none;
        }

        .info-text {
            font-size: 13px;
            color: #666;
            margin-top: 5px;
        }

        button {
            grid-column: span 2;
            padding: 14px;
            background-color: #4CAF50;
            color: white;
            font-weight: bold;
            font-size: 16px;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        button:hover {
            background-color: #45a049;
        }

        @media (max-width: 700px) {
            form {
                grid-template-columns: 1fr;
            }

            button {
                grid-column: span 1;
            }
        }

        .back-button {
            display: inline-block;
            margin-bottom: 20px;
            padding: 10px 16px;
            background-color: #ddd;
            color: #333;
            text-decoration: none;
            border-radius: 6px;
            font-weight: bold;
            transition: background-color 0.3s ease;
        }

        .back-button:hover {
            background-color: rgb(238, 28, 28);
            color: white;
        }

        /* Loading Screen */
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
            display: none;
        }

        .logo-container {
            text-align: center;
            animation: fadeIn 1s ease-in-out;
        }

        .logo-container p {
            font-weight: bold;
            font-size: 20px;
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
            background-color:rgb(32, 140, 241);
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
</head>

<body>

    <!-- Loading Screen -->
    <!-- Loading Screen -->
    <div id="loading-screen">
        <div class="logo-container">
            <i class="fas fa-ship fa-3x text-primary mb-3"></i>
            <p class="text-dark">Memuat Halaman...</p>
            <div class="progress-bar"></div>
        </div>
    </div>


    <div class="container">
        <h2>Form Pembayaran</h2>
        <a href="<?= base_url('/') ?>" class="back-button"><- Kembali</a>

                <form id="paymentForm" action="<?= base_url('booking/submit') ?>" method="post">
                    <?= csrf_field() ?>
                    <input type="hidden" name="route_id" value="<?= esc($rute['id']) ?>">

                    <div>
                        <label>Nama Lengkap:</label>
                        <input type="text" name="name" required>
                    </div>

                    <div>
                        <label>Email Aktif:</label>
                        <input type="email" name="email" required>
                    </div>

                    <div>
                        <label>Nomor HP / WA:</label>
                        <input type="tel" name="phone" required>
                    </div>
                    <div>
                        <label>Tanggal Keberangkatan:</label>
                        <input type="date" name="departure_date" required>
                    </div>

                    <div>
                        <label>Jumlah Kursi:</label>
                        <input type="number" name="seat_qty" id="seat_qty" min="1" value="1"
                            max="<?= esc($rute['seat_quota']) ?>" required>
                        <div class="info-text">Tersedia: <?= esc($rute['seat_quota']) ?> | Harga per kursi: Rp
                            <?= number_format($rute['price'], 0, ',', '.') ?></div>
                    </div>

                    <div>
                        <label>Total Harga:</label>
                        <input type="text" id="display_total" readonly>
                        <input type="hidden" name="total_price" id="total_price">
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Metode Pembayaran:</label>
                        <select name="payment_method" class="form-select" required>
                            <option value="">-- Pilih --</option>
                            <?php foreach ($methods as $m): ?>
                                <option value="<?= esc($m['id']) ?>">
                                    <?= esc($m['nama_bank']) ?> (<?= esc($m['no_rek']) ?>)
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="full">
                        <label>Catatan (Opsional):</label>
                        <textarea name="notes" rows="3"></textarea>
                    </div>

                    <button type="submit">✅ Bayar Sekarang</button>
                </form>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const seatQtyInput = document.getElementById('seat_qty');
            const displayTotal = document.getElementById('display_total');
            const totalPriceInput = document.getElementById('total_price');
            const pricePerSeat = <?= json_encode((int)$rute['price']) ?>;
            const form = document.getElementById('paymentForm');
            const loadingScreen = document.getElementById('loading-screen');

            function updateTotal() {
                const qty = parseInt(seatQtyInput.value) || 0;
                const total = qty * pricePerSeat;
                displayTotal.value = 'Rp ' + total.toLocaleString('id-ID');
                totalPriceInput.value = total;
            }

            seatQtyInput.addEventListener('input', updateTotal);
            updateTotal();

            // Saat form submit, tampilkan loading screen
            form.addEventListener('submit', function() {
                loadingScreen.style.display = 'flex';
                loadingScreen.querySelector("p").textContent = "Memproses Pembayaran...";
            });

            // Saat halaman pertama kali load
            loadingScreen.style.display = 'flex';
            window.addEventListener("load", function() {
                // delay biar efek fade lebih halus
                setTimeout(() => {
                    loadingScreen.style.display = 'none';
                }, 800);
            });
        });
    </script>


</body>

</html>