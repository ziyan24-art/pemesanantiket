<form method="post" action="/admin/rute/store">
    <?= csrf_field() ?>
    <div class="mb-3">
        <label for="rute" class="form-label">Rute</label>
        <input type="text" class="form-control" id="rute" name="rute"
            placeholder="Contoh: Balikpapan - Penajam" required>
    </div>
    <div class="mb-3">
        <label for="jam_berangkat" class="form-label">Jam Berangkat</label>
        <input type="time" class="form-control" id="jam_berangkat" name="jam_berangkat" required>
    </div>
    <div class="mb-3">
        <label for="perkiraan_tiba" class="form-label">Perkiraan Tiba</label>
        <input type="time" class="form-control" id="perkiraan_tiba" name="perkiraan_tiba" required>
    </div>
    <div class="mb-3">
        <label for="nama_speedboat" class="form-label">Nama Speedboat</label>
        <input type="text" class="form-control" id="nama_speedboat" name="nama_speedboat"
            placeholder="Contoh: Express Bahari 01" required>
    </div>
    <div class="mb-3">
        <label for="price" class="form-label">Harga Tiket (Rp)</label>
        <input type="number" class="form-control" id="price" name="price"
            placeholder="Contoh: 75000" required>
    </div>
    <div class="mb-3">
        <label for="seat_quota" class="form-label">Jumlah Kursi</label>
        <input type="number" class="form-control" name="seat_quota" id="seat_quota"
            value="<?= old('seat_quota', $rute['seat_quota'] ?? '') ?>" required min="1">
    </div>

    <button type="submit" class="btn btn-primary w-100">Simpan Rute</button>
</form>