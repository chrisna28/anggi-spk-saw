<div class="container-fluid">
    <?php if ($this->session->flashdata('success')): ?>
    <div class="alert alert-success alert-dismissible shadow-sm border-0"><?= $this->session->flashdata('success') ?><button type="button" class="btn-close" data-bs-dismiss="alert"></button></div>
    <?php endif; ?>

    <div class="card shadow-sm border-0">
        <div class="card-body p-4">
            <h5 class="fw-bold mb-4"><i class="fas fa-user-circle me-2 text-primary"></i>Biodata Saya</h5>
            <form method="post">
                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label small fw-bold">Nama Lengkap</label>
                        <input type="text" name="nama_alternatif" class="form-control" value="<?= set_value('nama_alternatif', $alternatif->nama_alternatif) ?>" required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label small fw-bold">Email</label>
                        <input type="email" name="email" class="form-control" value="<?= set_value('email', $alternatif->email) ?>">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label small fw-bold">No. Telepon</label>
                        <input type="text" name="no_telp" class="form-control" value="<?= set_value('no_telp', $alternatif->no_telp) ?>">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label small fw-bold">Jarak Rumah ke Tempat Kerja</label>
                        <div class="input-group">
                            <input type="text" name="jarak_rumah" class="form-control" value="<?= set_value('jarak_rumah', $alternatif->jarak_rumah) ?>" placeholder="Contoh: 5">
                            <span class="input-group-text">km</span>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <label class="form-label small fw-bold">Alamat</label>
                        <textarea name="alamat" class="form-control" rows="3"><?= set_value('alamat', $alternatif->alamat) ?></textarea>
                    </div>
                    <div class="col-md-12">
                        <hr>
                        <h6 class="fw-bold"><i class="fas fa-heartbeat me-2 text-danger"></i>Riwayat Kesehatan</h6>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label small fw-bold">Memiliki Riwayat Penyakit?</label>
                        <div class="d-flex gap-3 mt-1">
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="riwayat_penyakit" id="penyakitYa" value="Ya" <?= set_value('riwayat_penyakit', $alternatif->riwayat_penyakit) == 'Ya' ? 'checked' : '' ?> onchange="togglePenyakit()">
                                <label class="form-check-label" for="penyakitYa">Ya</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="riwayat_penyakit" id="penyakitTidak" value="Tidak" <?= set_value('riwayat_penyakit', $alternatif->riwayat_penyakit) == 'Tidak' ? 'checked' : '' ?> onchange="togglePenyakit()">
                                <label class="form-check-label" for="penyakitTidak">Tidak</label>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12" id="detailPenyakit" style="display: <?= $alternatif->riwayat_penyakit == 'Ya' ? 'block' : 'none' ?>">
                        <label class="form-label small fw-bold">Detail Riwayat Penyakit</label>
                        <textarea name="riwayat_penyakit_detail" class="form-control" rows="3" placeholder="Jelaskan riwayat penyakit yang dimiliki..."><?= set_value('riwayat_penyakit_detail', $alternatif->riwayat_penyakit_detail) ?></textarea>
                    </div>
                </div>
                <button type="submit" class="btn btn-primary mt-4 px-4"><i class="fas fa-save me-2"></i>Simpan</button>
            </form>
        </div>
    </div>
</div>

<script>
function togglePenyakit() {
    var ya = document.getElementById('penyakitYa').checked;
    document.getElementById('detailPenyakit').style.display = ya ? 'block' : 'none';
}
</script>
