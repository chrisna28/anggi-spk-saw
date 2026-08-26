<div class="container-fluid">
    <h5 class="fw-bold mb-4"><i class="fas fa-edit me-2 text-primary"></i>Data Penilaian</h5>
    <div class="card shadow-sm border-0">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead><tr><th>No</th><th>Alternatif</th><th>Kriteria</th><th>Sub Kriteria</th><th>Nilai</th></tr></thead>
                    <tbody>
                        <?php if (empty($penilaian)): ?>
                        <tr><td colspan="5" class="text-center text-muted py-4">Belum ada data penilaian</td></tr>
                        <?php else: $no=1; foreach ($penilaian as $p): ?>
                        <tr>
                            <td><?= $no++ ?></td>
                            <td class="fw-bold"><?= htmlspecialchars($p->nama_alternatif) ?></td>
                            <td><span class="badge bg-info"><?= $p->kode_kriteria ?></span> <?= htmlspecialchars($p->nama_kriteria) ?></td>
                            <td><?= htmlspecialchars($p->nama_sub) ?></td>
                            <td><span class="badge bg-dark"><?= $p->nilai ?></span></td>
                        </tr>
                        <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
