<div class="container-fluid">
    <h5 class="fw-bold mb-4"><i class="fas fa-calculator me-2 text-primary"></i>Data Perhitungan SAW</h5>

    <!-- Matriks X -->
    <div class="card shadow-sm border-0 mb-4">
        <div class="card-header bg-white border-0"><h6 class="fw-bold mb-0">1. Matriks Keputusan (X)</h6></div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-hover">
                    <thead><tr><th>Alternatif</th><?php foreach ($kriteria as $k): ?><th><?= $k->kode_kriteria ?><br><small class="text-muted"><?= $k->jenis ?></small></th><?php endforeach; ?></tr></thead>
                    <tbody>
                        <?php foreach ($alternatif as $a): ?>
                        <tr>
                            <td class="fw-bold"><?= htmlspecialchars($a->nama_alternatif) ?></td>
                            <?php foreach ($kriteria as $k): ?>
                            <td><?= $matrix_x[$a->id_alternatif][$k->id_kriteria] ?? 0 ?></td>
                            <?php endforeach; ?>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Matriks R -->
    <div class="card shadow-sm border-0 mb-4">
        <div class="card-header bg-white border-0"><h6 class="fw-bold mb-0">2. Matriks Normalisasi (R)</h6></div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-hover">
                    <thead><tr><th>Alternatif</th><?php foreach ($kriteria as $k): ?><th><?= $k->kode_kriteria ?><br><small class="text-muted"><?= $k->jenis ?></small></th><?php endforeach; ?></tr></thead>
                    <tbody>
                        <?php foreach ($alternatif as $a): ?>
                        <tr>
                            <td class="fw-bold"><?= htmlspecialchars($a->nama_alternatif) ?></td>
                            <?php foreach ($kriteria as $k): ?>
                            <td><?= number_format($matrix_r[$a->id_alternatif][$k->id_kriteria] ?? 0, 4) ?></td>
                            <?php endforeach; ?>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Nilai V -->
    <div class="card shadow-sm border-0">
        <div class="card-header bg-white border-0"><h6 class="fw-bold mb-0">3. Nilai Preferensi (V)</h6></div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-hover">
                    <thead><tr><th>Ranking</th><th>Alternatif</th><?php foreach ($kriteria as $k): ?><th><?= $k->kode_kriteria ?> (<?= $k->bobot ?>%)</th><?php endforeach; ?><th>Total V</th></tr></thead>
                    <tbody>
                        <?php
                        $sorted = $alternatif;
                        usort($sorted, function($a, $b) use ($nilai_v) {
                            return ($nilai_v[$b->id_alternatif] ?? 0) <=> ($nilai_v[$a->id_alternatif] ?? 0);
                        });
                        $no = 1;
                        ?>
                        <?php foreach ($sorted as $a): ?>
                        <tr class="<?= $no == 1 ? 'table-warning' : '' ?>">
                            <td class="fw-bold"><?= $no++ ?></td>
                            <td class="fw-bold"><?= htmlspecialchars($a->nama_alternatif) ?></td>
                            <?php foreach ($kriteria as $k): ?>
                            <td><?= number_format(($matrix_r[$a->id_alternatif][$k->id_kriteria] ?? 0) * ($k->bobot/100), 4) ?></td>
                            <?php endforeach; ?>
                            <td class="fw-bold text-primary"><?= number_format($nilai_v[$a->id_alternatif] ?? 0, 4) ?></td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
