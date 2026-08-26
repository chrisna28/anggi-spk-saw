<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h5 class="fw-bold mb-0"><i class="fas fa-edit me-2 text-primary"></i>Edit Aturan Skoring</h5>
        <a href="<?= base_url('AturanSkoring') ?>" class="btn btn-outline-secondary btn-sm"><i class="fas fa-arrow-left me-1"></i>Kembali</a>
    </div>

    <div class="card shadow-sm border-0">
        <div class="card-body p-4">
            <form method="post">
                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label small fw-bold">Kriteria</label>
                        <select name="id_kriteria" id="id_kriteria" class="form-select" required>
                            <option value="">Pilih Kriteria</option>
                            <?php foreach ($kriteria as $k): ?>
                            <option value="<?= $k->id_kriteria ?>" <?= $k->id_kriteria == $aturan->id_kriteria ? 'selected' : '' ?>><?= $k->kode_kriteria ?> - <?= htmlspecialchars($k->nama_kriteria) ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label small fw-bold">Sub Kriteria</label>
                        <select name="id_sub" id="id_sub" class="form-select" required>
                            <?php foreach ($sub_kriteria as $s): ?>
                            <option value="<?= $s->id_sub ?>" <?= $s->id_sub == $aturan->id_sub ? 'selected' : '' ?>><?= $s->nama_sub ?> (Nilai: <?= $s->nilai ?>)</option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label small fw-bold">Sumber Data</label>
                        <select name="sumber_data" id="sumber_data" class="form-select" required>
                            <option value="pengalaman_kerja" <?= $aturan->sumber_data=='pengalaman_kerja'?'selected':'' ?>>Pengalaman Kerja</option>
                            <option value="pendidikan" <?= $aturan->sumber_data=='pendidikan'?'selected':'' ?>>Pendidikan</option>
                            <option value="organisasi" <?= $aturan->sumber_data=='organisasi'?'selected':'' ?>>Organisasi</option>
                            <option value="berkas" <?= $aturan->sumber_data=='berkas'?'selected':'' ?>>Berkas</option>
                            <option value="profil" <?= $aturan->sumber_data=='profil'?'selected':'' ?>>Profil</option>
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label small fw-bold">Field Sumber</label>
                        <select name="field_sumber" id="field_sumber" class="form-select" required>
                            <option value="total_tahun" <?= $aturan->field_sumber=='total_tahun'?'selected':'' ?>>Total Tahun Pengalaman</option>
                            <option value="jumlah" <?= $aturan->field_sumber=='jumlah'?'selected':'' ?>>Jumlah</option>
                            <option value="jenjang" <?= $aturan->field_sumber=='jenjang'?'selected':'' ?>>Jenjang Pendidikan Tertinggi</option>
                            <option value="jumlah_valid" <?= $aturan->field_sumber=='jumlah_valid'?'selected':'' ?>>Jumlah Berkas Valid</option>
                            <option value="jenis_berkas" <?= $aturan->field_sumber=='jenis_berkas'?'selected':'' ?>>Jenis Berkas</option>
                            <option value="jarak_rumah" <?= $aturan->field_sumber=='jarak_rumah'?'selected':'' ?>>Jarak Rumah (km)</option>
                            <option value="riwayat_penyakit" <?= $aturan->field_sumber=='riwayat_penyakit'?'selected':'' ?>>Riwayat Penyakit</option>
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label small fw-bold">Operator</label>
                        <select name="operator" class="form-select" required>
                            <option value="=" <?= $aturan->operator=='='?'selected':'' ?>>= (Sama Dengan)</option>
                            <option value=">=" <?= $aturan->operator=='>='?'selected':'' ?>>>= (Lebih Atau Sama Dengan)</option>
                            <option value="<=" <?= $aturan->operator=='<='?'selected':'' ?>><= (Kurang Atau Sama Dengan)</option>
                            <option value=">" <?= $aturan->operator=='>'?'selected':'' ?>> (Lebih Dari)</option>
                            <option value="<" <?= $aturan->operator=='<'?'selected':'' ?>>< (Kurang Dari)</option>
                            <option value="between" <?= $aturan->operator=='between'?'selected':'' ?>>Between (Antara)</option>
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label small fw-bold">Nilai</label>
                        <input type="text" name="nilai_min" class="form-control" value="<?= htmlspecialchars($aturan->nilai_min) ?>" required>
                    </div>
                    <div class="col-md-6" id="field_nilai_max" style="<?= $aturan->operator != 'between' ? 'display:none' : '' ?>">
                        <label class="form-label small fw-bold">Nilai Maksimum</label>
                        <input type="text" name="nilai_max" class="form-control" value="<?= htmlspecialchars($aturan->nilai_max) ?>">
                    </div>
                </div>
                <button type="submit" class="btn btn-primary mt-4 px-4"><i class="fas fa-save me-2"></i>Simpan</button>
            </form>
        </div>
    </div>
</div>

<script>
$(document).ready(function() {
    $('[name="operator"]').change(function() {
        if ($(this).val() == 'between') $('#field_nilai_max').show();
        else $('#field_nilai_max').hide();
    });
});
</script>
