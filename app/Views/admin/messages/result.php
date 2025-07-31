<h2>🧾 Detail Transaksi E-Tiket</h2>

<?php if (isset($transaction)): ?>
    <table border="1" cellpadding="10" cellspacing="0" style="margin-top: 15px;">
        <tr>
            <td><strong>Kode E-Tiket</strong></td>
            <td><?= esc($transaction['transaction_code']) ?></td>
        </tr>
        <tr>
            <td><strong>Nama Penumpang</strong></td>
            <td><?= esc($transaction['username'] ?? '-') ?></td>
        </tr>
        <tr>
            <td><strong>Jumlah Tiket</strong></td>
            <td><?= esc($transaction['quantity'] ?? 0) ?></td>
        </tr>
        <tr>
            <td><strong>Total Bayar</strong></td>
            <td>Rp<?= number_format($transaction['total_price'] ?? 0, 0, ',', '.') ?></td>
        </tr>
        <tr>
            <td><strong>Status Boarding</strong></td>
            <td><?= ucfirst(esc($transaction['boarding_status'] ?? 'belum')) ?></td>
        </tr>
    </table>

    <?php if (($transaction['boarding_status'] ?? 'belum') !== 'naik'): ?>
        <form action="<?= base_url('messages/confirm') ?>" method="post" style="margin-top: 15px;">
            <?= csrf_field() ?>
            <input type="hidden" name="id" value="<?= $transaction['id'] ?>">
            <button type="submit" onclick="return confirm('Yakin penumpang ini sudah naik?')">
                ✅ Konfirmasi Naik
            </button>
        </form>
    <?php else: ?>
        <p style="margin-top: 15px;">✅ Penumpang sudah dikonfirmasi naik.</p>
    <?php endif; ?>
<?php else: ?>
    <p>Data transaksi tidak ditemukan.</p>
<?php endif; ?>