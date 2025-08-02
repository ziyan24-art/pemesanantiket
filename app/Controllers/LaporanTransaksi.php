<?php

namespace App\Controllers;

use App\Models\TransactionModel;
use App\Models\BookingModel;
use App\Models\PaymentMethodModel;
use App\Models\Rute;
use App\Models\UserModel;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use Dompdf\Dompdf;

class LaporanTransaksi extends BaseController
{
    private function getFilteredData()
    {
        $transactionModel = new TransactionModel();
        $bookingModel     = new BookingModel();
        $routeModel       = new Rute();
        $paymentModel     = new PaymentMethodModel();
        $userModel        = new UserModel();

        // Ambil input filter
        $start = $this->request->getGet('start_date');
        $end   = $this->request->getGet('end_date');

        $builder = $transactionModel->where('status', 'paid');

        if ($start && $end) {
            $builder = $builder->where("DATE(created_at) >=", $start)
                ->where("DATE(created_at) <=", $end);
        }

        $transactions = $builder->orderBy('created_at', 'DESC')->findAll();

        $laporan = [];
        foreach ($transactions as $t) {
            $booking = $bookingModel->find($t['booking_id']);
            $route   = $routeModel->find($booking['route_id']);
            $payment = $paymentModel->find($t['payment_method']);
            $user    = $userModel->find($booking['user_id']);

            $laporan[] = [
                'transaction' => $t,
                'booking'     => $booking,
                'route'       => $route,
                'payment'     => $payment,
                'user'        => $user,
            ];
        }

        return $laporan;
    }

    public function index()
    {
        $laporan = $this->getFilteredData();
        return view('admin/laporan_transaksi', [
            'laporan'    => $laporan,
            'start_date' => $this->request->getGet('start_date'),
            'end_date'   => $this->request->getGet('end_date')
        ]);
    }

    // ✅ Export Excel
    public function exportExcel()
    {
        $laporan = $this->getFilteredData();

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setTitle("Laporan Transaksi");

        // Header
        $headers = ['No', 'Kode Transaksi', 'Nama Customer', 'Rute', 'Speedboat', 'Tgl Berangkat', 'Jam Berangkat', 'Jumlah Kursi', 'Total Bayar', 'Metode Bayar', 'Tanggal Transaksi'];
        $col = 'A';
        foreach ($headers as $h) {
            $sheet->setCellValue($col . '1', $h);
            $col++;
        }

        // Data
        $row = 2;
        $no = 1;
        foreach ($laporan as $l) {
            $sheet->setCellValue("A{$row}", $no++);
            $sheet->setCellValue("B{$row}", $l['transaction']['transaction_code']);
            $sheet->setCellValue("C{$row}", $l['user']['username'] ?? '-');
            $sheet->setCellValue("D{$row}", $l['route']['rute'] ?? '-');
            $sheet->setCellValue("E{$row}", $l['route']['nama_speedboat'] ?? '-');
            $sheet->setCellValue("F{$row}", $l['booking']['departure_date']);
            $sheet->setCellValue("G{$row}", $l['route']['jam_berangkat'] ?? '-');
            $sheet->setCellValue("H{$row}", $l['booking']['quantity']);
            $sheet->setCellValue("I{$row}", $l['booking']['total_price']);
            $sheet->setCellValue("J{$row}", $l['payment']['nama_bank'] ?? '-');
            $sheet->setCellValue("K{$row}", $l['transaction']['created_at']);
            $row++;
        }

        $writer = new Xlsx($spreadsheet);
        $fileName = 'laporan-transaksi.xlsx';
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header("Content-Disposition: attachment; filename=\"$fileName\"");
        $writer->save("php://output");
        exit;
    }

    // ✅ Export PDF
    public function exportPDF()
    {
        $laporan = $this->getFilteredData();

        $html = "<h2 style='text-align:center'>Laporan Transaksi (Paid Only)</h2>";
        $html .= "<table border='1' cellspacing='0' cellpadding='6' width='100%'>
            <thead>
                <tr style='background:#ddd;'>
                    <th>No</th>
                    <th>Kode Transaksi</th>
                    <th>Nama Customer</th>
                    <th>Rute</th>
                    <th>Speedboat</th>
                    <th>Tgl Berangkat</th>
                    <th>Jam Berangkat</th>
                    <th>Kursi</th>
                    <th>Total</th>
                    <th>Metode</th>
                    <th>Tgl Transaksi</th>
                </tr>
            </thead><tbody>";

        $no = 1;
        foreach ($laporan as $l) {
            $html .= "<tr>
                <td>{$no}</td>
                <td>{$l['transaction']['transaction_code']}</td>
                <td>" . ($l['user']['username'] ?? '-') . "</td>
                <td>" . ($l['route']['rute'] ?? '-') . "</td>
                <td>" . ($l['route']['nama_speedboat'] ?? '-') . "</td>
                <td>{$l['booking']['departure_date']}</td>
                <td>" . ($l['route']['jam_berangkat'] ?? '-') . "</td>
                <td>{$l['booking']['quantity']}</td>
                <td>Rp " . number_format($l['booking']['total_price'], 0, ',', '.') . "</td>
                <td>" . ($l['payment']['nama_bank'] ?? '-') . "</td>
                <td>{$l['transaction']['created_at']}</td>
            </tr>";
            $no++;
        }
        $html .= "</tbody></table>";

        $dompdf = new Dompdf();
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'landscape');
        $dompdf->render();
        $dompdf->stream("laporan-transaksi.pdf", ["Attachment" => true]);
    }

    public function pemasukan()
    {

        // 🔒 Batasi akses hanya untuk pemilik
        if (session('role') !== 'pemilik') {
            return redirect()->to('/dashboard')->with('error', 'Anda tidak punya akses ke halaman ini.');
        }
        $db = \Config\Database::connect();
        $bulan = (int) ($this->request->getGet('bulan') ?? date('m'));
        $tahun = (int) ($this->request->getGet('tahun') ?? date('Y'));

        // 🔹 Query pemasukan per hari (untuk grafik)
        $query = $db->query("
        SELECT DAY(t.created_at) as hari, 
               SUM(b.total_price) as total
        FROM transactions t
        JOIN bookings b ON b.id = t.booking_id
        WHERE MONTH(t.created_at) = ? 
          AND YEAR(t.created_at) = ? 
          AND t.status = 'paid'
        GROUP BY DAY(t.created_at)
        ORDER BY hari ASC
    ", [$bulan, $tahun]);

        $result = $query->getResultArray();

        // 🔹 Siapkan array tanggal lengkap 1 s/d akhir bulan
        $jumlahHari = cal_days_in_month(CAL_GREGORIAN, $bulan, $tahun);
        $hari = range(1, $jumlahHari);
        $total = array_fill(0, $jumlahHari, 0);

        // 🔹 Masukkan hasil query ke array total sesuai tanggal
        foreach ($result as $row) {
            $index = $row['hari'] - 1; // index array mulai dari 0
            $total[$index] = (int) $row['total'];
        }

        // 🔹 Pemasukan hari ini
        $hariIni = $total[date('j') - 1] ?? 0;

        // 🔹 Total pemasukan bulan ini
        $total_bulan = array_sum($total);

        // 🔹 Query untuk grafik bulanan (per tahun)
        $queryBulanan = $db->query("
        SELECT MONTH(t.created_at) as bulan, 
               SUM(b.total_price) as total
        FROM transactions t
        JOIN bookings b ON b.id = t.booking_id
        WHERE YEAR(t.created_at) = ? 
          AND t.status = 'paid'
        GROUP BY MONTH(t.created_at)
    ", [$tahun]);

        $resultBulanan = $queryBulanan->getResultArray();
        $pemasukanBulanan = array_fill(0, 12, 0);
        foreach ($resultBulanan as $row) {
            $pemasukanBulanan[$row['bulan'] - 1] = (int) $row['total'];
        }

        // 🔹 Jumlah transaksi bulan ini
        $queryTransaksi = $db->query("
        SELECT COUNT(*) as jml
        FROM transactions t
        WHERE MONTH(t.created_at) = ? 
          AND YEAR(t.created_at) = ? 
          AND t.status = 'paid'
    ", [$bulan, $tahun]);

        $jmlTransaksi = $queryTransaksi->getRow()->jml ?? 0;

        // 🔹 Hitung navigasi bulan
        $prevBulan = $bulan - 1;
        $prevTahun = $tahun;
        $nextBulan = $bulan + 1;
        $nextTahun = $tahun;

        if ($prevBulan == 0) {
            $prevBulan = 12;
            $prevTahun--;
        }
        if ($nextBulan == 13) {
            $nextBulan = 1;
            $nextTahun++;
        }

        return view('admin/pemasukan', [
            'bulan' => $bulan,
            'tahun' => $tahun,
            'hari' => json_encode($hari),
            'total' => json_encode($total),
            'total_bulan' => $total_bulan,
            'hari_ini' => $hariIni,
            'pemasukanBulanan' => $pemasukanBulanan,
            'jmlTransaksi' => $jmlTransaksi,
            'prevBulan' => $prevBulan,
            'prevTahun' => $prevTahun,
            'nextBulan' => $nextBulan,
            'nextTahun' => $nextTahun
        ]);
    }
}
