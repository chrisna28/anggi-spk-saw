<div class="container-fluid">
    <div class="d-flex align-items-center justify-content-between mb-4">
        <h4 class="mb-0 fw-bold border-start border-4 ps-3" style="border-color: var(--accent-blue) !important;"><i class="fas fa-chart-bar me-2"></i> Data Hasil Akhir</h4>
        <button onclick="window.print()" class="btn btn-primary-red shadow-sm btn-sm px-3 d-print-none">
            <i class="fas fa-print me-2"></i> Cetak Laporan
        </button>
    </div>

    <?php if (isset($empty) && $empty): ?>
    <div class="card border-0 shadow-sm mb-4">
        <div class="card-body text-center py-5">
            <i class="fas fa-inbox fa-4x text-muted mb-3"></i>
            <h5 class="fw-bold text-muted">Belum Ada Data</h5>
            <p class="text-muted mb-0">Data hasil belum tersedia. Silakan isi data berikut terlebih dahulu:</p>
            <div class="d-flex justify-content-center gap-3 mt-3">
                <a href="<?= base_url('Kriteria') ?>" class="btn btn-outline-primary btn-sm">Kriteria</a>
                <a href="<?= base_url('Sub_Kriteria') ?>" class="btn btn-outline-primary btn-sm">Sub Kriteria</a>
                <a href="<?= base_url('Alternatif') ?>" class="btn btn-outline-primary btn-sm">Alternatif</a>
                <a href="<?= base_url('Penilaian') ?>" class="btn btn-outline-primary btn-sm">Penilaian</a>
            </div>
        </div>
    </div>
    <?php else: ?>

    <div class="card border-0 shadow-sm ranking-card">
        <div class="card-header bg-white py-3">
            <h6 class="m-0 fw-bold text-muted"><i class="fas fa-trophy me-2"></i> Ranking Alternatif Terbaik</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead>
                        <tr class="text-center">
                            <th width="10%">Ranking</th>
                            <th class="text-start">Nama Alternatif</th>
                            <th width="20%">Nilai Preferensi</th>
                            <th width="15%">Keterangan</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $no=1; foreach($hasil as $h): ?>
                        <tr class="<?= $no == 1 ? 'table-warning' : '' ?>">
                            <td class="text-center">
                                <?php if($no == 1): ?>
                                    <div class="badge bg-warning text-dark px-3 py-2 fs-6">
                                        <i class="fas fa-crown me-1"></i> <?= $no++ ?>
                                    </div>
                                <?php else: ?>
                                    <span class="badge bg-light text-dark border px-3 py-2"><?= $no++ ?></span>
                                <?php endif; ?>
                            </td>
                            <td class="fw-bold"><?= $h['nama'] ?></td>
                            <td class="text-center fw-bold text-primary"><?= round($h['nilai'], 4) ?></td>
                            <td class="text-center">
                                <?php if($no-1 <= 3): ?>
                                    <span class="badge bg-success px-3 py-2">Direkomendasikan</span>
                                <?php else: ?>
                                    <span class="badge bg-secondary px-3 py-2">Dipertimbangkan</span>
                                <?php endif; ?>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
            
            <div class="mt-4 pt-3 border-top d-print-none text-muted small">
                <p><i class="fas fa-info-circle me-1"></i> Ranking diurutkan berdasarkan nilai preferensi tertinggi menggunakan metode Simple Additive Weighting (SAW).</p>
            </div>
        </div>
    </div>
    <?php endif; ?>
</div>

<style>
@media print {
    #sidebar, .topbar, .d-print-none { display: none !important; }
    #content { margin-left: 0 !important; width: 100% !important; padding: 0 !important; }
    .card { border: 1px solid #ddd !important; box-shadow: none !important; }
}
</style>
