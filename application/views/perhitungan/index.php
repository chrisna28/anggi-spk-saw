<div class="container-fluid">
    <div class="d-flex align-items-center justify-content-between mb-4">
        <h4 class="mb-0 fw-bold border-start border-4 ps-3" style="border-color: var(--accent-blue) !important;"><i class="fas fa-calculator me-2"></i> Data Perhitungan</h4>
    </div>

    <?php if (isset($empty) && $empty): ?>
    <div class="card border-0 shadow-sm mb-4">
        <div class="card-body text-center py-5">
            <i class="fas fa-inbox fa-4x text-muted mb-3"></i>
            <h5 class="fw-bold text-muted">Belum Ada Data</h5>
            <p class="text-muted mb-0">Data perhitungan belum tersedia. Silakan isi data berikut terlebih dahulu:</p>
            <div class="d-flex justify-content-center gap-3 mt-3">
                <a href="<?= base_url('Kriteria') ?>" class="btn btn-outline-primary btn-sm">Kriteria</a>
                <a href="<?= base_url('Sub_Kriteria') ?>" class="btn btn-outline-primary btn-sm">Sub Kriteria</a>
                <a href="<?= base_url('Alternatif') ?>" class="btn btn-outline-primary btn-sm">Alternatif</a>
                <a href="<?= base_url('Penilaian') ?>" class="btn btn-outline-primary btn-sm">Penilaian</a>
            </div>
        </div>
    </div>
    <?php else: ?>

    <!-- 1. Matriks Keputusan -->
    <div class="card border-0 shadow-sm mb-4">
        <div class="card-header bg-white py-3">
            <h6 class="m-0 fw-bold text-muted"><i class="fas fa-th me-2"></i> 1. Matriks Keputusan (X)</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-hover align-middle text-center">
                    <thead class="bg-light">
                        <tr>
                            <th width="5%">No</th>
                            <th>Alternatif</th>
                            <?php foreach($kriteria as $k): ?>
                                <th><?= $k->kode_kriteria ?></th>
                            <?php endforeach; ?>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $no=1; foreach($alternatif as $a): ?>
                        <tr>
                            <td><?= $no++ ?></td>
                            <td class="text-start fw-bold"><?= $a->nama_alternatif ?></td>
                            <?php foreach($kriteria as $k): ?>
                                <td><?= $matrix[$a->id_alternatif][$k->id_kriteria] ?></td>
                            <?php endforeach; ?>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- 2. Matriks Normalisasi -->
    <div class="card border-0 shadow-sm mb-4">
        <div class="card-header bg-white py-3">
            <h6 class="m-0 fw-bold text-muted"><i class="fas fa-sync me-2"></i> 2. Matriks Normalisasi (R)</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-hover align-middle text-center">
                    <thead class="bg-light">
                        <tr>
                            <th width="5%">No</th>
                            <th>Alternatif</th>
                            <?php foreach($kriteria as $k): ?>
                                <th><?= $k->kode_kriteria ?></th>
                            <?php endforeach; ?>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $no=1; foreach($alternatif as $a): ?>
                        <tr>
                            <td><?= $no++ ?></td>
                            <td class="text-start fw-bold"><?= $a->nama_alternatif ?></td>
                            <?php foreach($kriteria as $k): ?>
                                <td><?= round($normal[$a->id_alternatif][$k->id_kriteria], 4) ?></td>
                            <?php endforeach; ?>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- 3. Nilai Preferensi -->
    <div class="card border-0 shadow-sm mb-4">
        <div class="card-header bg-white py-3">
            <h6 class="m-0 fw-bold text-muted"><i class="fas fa-star me-2"></i> 3. Nilai Preferensi (V)</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-hover align-middle text-center">
                    <thead class="bg-light">
                        <tr>
                            <th width="5%">No</th>
                            <th>Alternatif</th>
                            <th>Perhitungan</th>
                            <th width="20%">Nilai Preferensi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $no=1; foreach($alternatif as $a): ?>
                        <tr>
                            <td><?= $no++ ?></td>
                            <td class="text-start fw-bold"><?= $a->nama_alternatif ?></td>
                            <td class="text-start small">
                                <?php 
                                    $calc_parts = [];
                                    foreach($kriteria as $k) {
                                        $calc_parts[] = "(".round($normal[$a->id_alternatif][$k->id_kriteria], 4)." * ".($k->bobot/100).")";
                                    }
                                    echo implode(" + ", $calc_parts);
                                ?>
                            </td>
                            <td class="fw-bold text-primary"><?= round($preferensi[$a->id_alternatif]['nilai'], 4) ?></td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <?php endif; ?>
</div>
