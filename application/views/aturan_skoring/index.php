<div class="container-fluid">
    <?php if ($msg = $this->session->flashdata('success')): ?>
    <div class="alert alert-success alert-dismissible shadow-sm border-0"><?= $msg ?><button type="button" class="btn-close" data-bs-dismiss="alert"></button></div>
    <?php endif; ?>

    <div class="d-flex justify-content-between align-items-center mb-4">
        <h5 class="fw-bold mb-0"><i class="fas fa-cog me-2 text-primary"></i>Aturan Skoring</h5>
        <a href="<?= base_url('AturanSkoring/tambah') ?>" class="btn btn-primary btn-sm"><i class="fas fa-plus me-1"></i>Tambah Aturan</a>
    </div>

    <div class="card shadow-sm border-0">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead><tr><th>No</th><th>Kriteria</th><th>Sub Kriteria</th><th>Sumber Data</th><th>Field</th><th>Operator</th><th>Nilai</th><th>Aksi</th></tr></thead>
                    <tbody>
                        <?php if (empty($aturan)): ?>
                        <tr><td colspan="8" class="text-center text-muted py-4">Belum ada aturan skoring</td></tr>
                        <?php else: $no=1; foreach ($aturan as $a): ?>
                        <tr>
                            <td><?= $no++ ?></td>
                            <td><span class="badge bg-info"><?= $a->kode_kriteria ?></span> <?= htmlspecialchars($a->nama_kriteria) ?></td>
                            <td><?= htmlspecialchars($a->nama_sub) ?> (<?= $a->nilai ?>)</td>
                            <td><?= str_replace('_', ' ', ucfirst($a->sumber_data)) ?></td>
                            <td><?= htmlspecialchars($a->field_sumber) ?></td>
                            <td><code><?= $a->operator ?></code></td>
                            <td><?= htmlspecialchars($a->nilai_min) ?><?= $a->operator == 'between' ? ' - '.htmlspecialchars($a->nilai_max) : '' ?></td>
                            <td>
                                <a href="<?= base_url('AturanSkoring/edit/'.$a->id_aturan) ?>" class="btn btn-sm btn-outline-primary"><i class="fas fa-edit"></i></a>
                                <a href="<?= base_url('AturanSkoring/hapus/'.$a->id_aturan) ?>" class="btn btn-sm btn-outline-danger" onclick="return confirm('Hapus aturan ini?')"><i class="fas fa-trash"></i></a>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
