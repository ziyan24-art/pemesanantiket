<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AdamBoat - Pemesanan Tiket</title>
    <link rel="stylesheet" href="<?= base_url('/css/style.css') ?>">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">


    <!-- SweetAlert2 CDN -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <style>
        html,
        body {
            height: 100%;
            margin: 0;
            display: flex;
            flex-direction: column;
        }

        .main-wrapper {
            flex: 1;
            display: flex;
            flex-direction: column;
            background-color: transparent;
        }

        .main-content {
            flex: 1;
        }

        .main-footer {
            background-color: rgb(13, 121, 230);
            padding: 1rem;
            text-align: center;
        }

        /* Header style tetap */
        .main-header {
            background: #0077c2;
            padding: 15px 0;
            color: #fff;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }

        .main-header .logo a {
            color: #fff;
            font-size: 1.5rem;
            text-decoration: none;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .main-header .nav-menu ul {
            list-style: none;
            display: flex;
            gap: 20px;
        }

        .main-header .nav-menu ul li a {
            color: #fff;
            text-decoration: none;
            font-weight: 500;
            transition: color 0.3s;
        }

        .main-header .nav-menu ul li a:hover {
            color: #cfeeff;
        }

        .main-header .btn-search {
            padding: 8px 18px;
            background: #fff;
            color: #0077c2;
            border-radius: 20px;
            font-weight: bold;
            transition: background 0.3s;
        }

        .main-header .btn-search:hover {
            background: #cfeeff;
        }

        .main-header .container {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
    </style>
</head>

<body>


    <div class="main-wrapper">
        <header class="main-header">
            <div class="container">
                <div class="logo">
                    <a href="<?= base_url('/') ?>"><i class="fas fa-ship"></i> <strong>AdamBoat</strong></a>
                </div>
                <nav class="nav-menu">
                    <ul>
                        <li><a href="<?= base_url('/') ?>">Beranda</a></li>
                        <li><a href="<?= base_url('user/routes') ?>">Rute</a></li>
                        <li><a href="<?= base_url('riwayat') ?>">Riwayat Transaksi</a></li>

                        <?php if (session()->has('isLoggedIn') && session('isLoggedIn') === true): ?>
                            <li><a href="<?= base_url('logout') ?>">Logout</a></li>
                        <?php else: ?>
                            <li><a href="<?= base_url('login') ?>">Login</a></li>
                        <?php endif; ?>
                    </ul>
                </nav>
            </div>
        </header>


        <!-- Awal konten halaman -->
        <div class="main-content">