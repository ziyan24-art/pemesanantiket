<?= $this->include('layouts/header') ?>
<?= $this->include('layouts/sidebar') ?>
<?= $this->include('layouts/topbar') ?>

<div class="container-fluid" style="margin-left: 250px; margin-top: 70px;">

    <!-- 🔹 Row Cards -->
    <div class="row mb-4">
        <div class="col-md-3">
            <div class="card bg-primary text-white shadow">
                <div class="card-body">
                    Total Bulanan
                    <div class="h5">Rp <?= number_format($total_bulan, 0, ',', '.') ?></div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-success text-white shadow">
                <div class="card-body">
                    Hari Ini
                    <div class="h5">
                        Rp <?= number_format($hari_ini, 0, ',', '.') ?>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card bg-warning text-white shadow">
                <div class="card-body">
                    Jumlah Transaksi
                    <div class="h5"><?= $jmlTransaksi ?></div>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card bg-danger text-white shadow">
                <div class="card-body">
                    Tahun
                    <div class="h5"><?= $tahun ?></div>
                </div>
            </div>
        </div>
    </div>
    <div class="d-flex justify-content-between align-items-center mb-3">
        <a href="<?= base_url("admin/pemasukan?bulan=$prevBulan&tahun=$prevTahun") ?>"
            class="btn btn-outline-primary">⬅ Bulan Sebelumnya</a>

        <h5 class="mb-0">
            <?= date("F", mktime(0, 0, 0, $bulan, 1)) ?> <?= $tahun ?>
        </h5>

        <a href="<?= base_url("admin/pemasukan?bulan=$nextBulan&tahun=$nextTahun") ?>"
            class="btn btn-outline-primary">Bulan Berikutnya ➡</a>
    </div>


    <!-- 🔹 Row Grafik -->
    <div class="row">
        <div class="col-lg-8">
            <div class="card shadow mb-4">
                <div class="card-header bg-light">
                    <b>📈 Grafik Pemasukan Harian</b>
                </div>
                <div class="card-body">
                    <canvas id="grafikHarian"></canvas>
                </div>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="card shadow mb-4">
                <div class="card-header bg-light">
                    <b>📊 Pemasukan per Bulan</b>
                </div>
                <div class="card-body">
                    <canvas id="grafikBulanan"></canvas>
                </div>
            </div>
        </div>
    </div>
</div>

<?= $this->include('layouts/footer') ?>

<!-- Chart.js -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    // Grafik Harian (Line/Area)
    var ctx1 = document.getElementById('grafikHarian').getContext('2d');
    new Chart(ctx1, {
        type: 'line',
        data: {
            labels: <?= $hari ?>,
            datasets: [{
                label: 'Pemasukan Harian',
                data: <?= $total ?>,
                borderColor: 'rgba(54, 162, 235, 1)',
                backgroundColor: 'rgba(54, 162, 235, 0.2)',
                fill: true,
                tension: 0.3
            }]
        },
        options: {
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        callback: val => 'Rp ' + val.toLocaleString('id-ID')
                    }
                }
            }
        }
    });

    // Grafik Bulanan (Bar)
    var ctx2 = document.getElementById('grafikBulanan').getContext('2d');
    new Chart(ctx2, {
        type: 'bar',
        data: {
            labels: ["Jan", "Feb", "Mar", "Apr", "Mei", "Jun", "Jul", "Agu", "Sep", "Okt", "Nov", "Des"],
            datasets: [{
                label: 'Pemasukan',
                data: <?= json_encode($pemasukanBulanan ?? array_fill(0, 12, 0)) ?>,
                backgroundColor: 'rgba(255, 99, 132, 0.6)',
                borderColor: 'rgba(255, 99, 132, 1)',
                borderWidth: 1
            }]
        },
        options: {
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        callback: val => 'Rp ' + val.toLocaleString('id-ID')
                    }
                }
            }
        }
    });
</script>