<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h5 class="fw-bold mb-0"><i class="fas fa-plus-circle me-2 text-primary"></i>Tambah Aturan Skoring</h5>
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
                            <option value="<?= $k->id_kriteria ?>"><?= $k->kode_kriteria ?> - <?= htmlspecialchars($k->nama_kriteria) ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label small fw-bold">Sub Kriteria</label>
                        <select name="id_sub" id="id_sub" class="form-select" required>
                            <option value="">Pilih Kriteria Terlebih Dahulu</option>
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label small fw-bold">Sumber Data</label>
                        <select name="sumber_data" id="sumber_data" class="form-select" required>
                            <option value="">Pilih Sumber</option>
                            <option value="pengalaman_kerja">Pengalaman Kerja</option>
                            <option value="pendidikan">Pendidikan</option>
                            <option value="organisasi">Organisasi</option>
                            <option value="berkas">Berkas</option>
                            <option value="profil">Profil</option>
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label small fw-bold">Field Sumber</label>
                        <select name="field_sumber" id="field_sumber" class="form-select" required>
                            <option value="">Pilih Sumber Terlebih Dahulu</option>
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label small fw-bold">Operator</label>
                        <select name="operator" class="form-select" required>
                            <option value="=">= (Sama Dengan)</option>
                            <option value=">=">>= (Lebih Atau Sama Dengan)</option>
                            <option value="<="><= (Kurang Atau Sama Dengan)</option>
                            <option value=">">> (Lebih Dari)</option>
                            <option value="<">< (Kurang Dari)</option>
                            <option value="between">Between (Antara)</option>
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label small fw-bold" id="label_nilai_min">Nilai Minimum</label>
                        <input type="text" name="nilai_min" class="form-control" required placeholder="Contoh: 3 atau S1">
                    </div>
                    <div class="col-md-6" id="field_nilai_max">
                        <label class="form-label small fw-bold">Nilai Maksimum</label>
                        <input type="text" name="nilai_max" class="form-control" placeholder="Hanya untuk operator Between">
                    </div>
                </div>
                <button type="submit" class="btn btn-primary mt-4 px-4"><i class="fas fa-save me-2"></i>Simpan</button>
            </form>
        </div>
    </div>
</div>

<script>
$(document).ready(function() {
    $('#id_kriteria').change(function() {
        var id = $(this).val();
        if (id) {
            $.get('<?= base_url("AturanSkoring/get_sub_by_kriteria") ?>', {id_kriteria: id}, function(data) {
                var options = '<option value="">Pilih Sub Kriteria</option>';
                $.each(data, function(i, s) {
                    options += '<option value="'+s.id_sub+'">'+s.nama_sub+' (Nilai: '+s.nilai+')</option>';
                });
                $('#id_sub').html(options);
            }, 'json');
        } else {
            $('#id_sub').html('<option value="">Pilih Kriteria Terlebih Dahulu</option>');
        }
    });

    $('#sumber_data').change(function() {
        var sumber = $(this).val();
        if (sumber) {
            $.get('<?= base_url("AturanSkoring/get_field_by_sumber") ?>', {sumber_data: sumber}, function(data) {
                var options = '<option value="">Pilih Field</option>';
                $.each(data, function(i, f) {
                    options += '<option value="'+f.value+'">'+f.label+'</option>';
                });
                $('#field_sumber').html(options);
            }, 'json');
        } else {
            $('#field_sumber').html('<option value="">Pilih Sumber Terlebih Dahulu</option>');
        }
    });

    $('[name="operator"]').change(function() {
        if ($(this).val() == 'between') {
            $('#field_nilai_max').show();
            $('#label_nilai_min').text('Nilai Minimum');
        } else {
            $('#field_nilai_max').hide();
            $('#label_nilai_min').text('Nilai');
        }
    }).trigger('change');
});
</script>
