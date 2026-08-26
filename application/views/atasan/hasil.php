<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h5 class="fw-bold mb-0"><i class="fas fa-chart-bar me-2 text-primary"></i>Hasil Akhir Rekomendasi</h5>
    </div>

    <div class="card shadow-sm border-0">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead><tr><th>Peringkat</th><th>Nama Pelamar</th><th>Nilai Preferensi (V)</th><th>Status</th></tr></thead>
                    <tbody>
                        <?php if (empty($ranking)): ?>
                        <tr><td colspan="4" class="text-center text-muted py-4">Belum ada hasil perhitungan</td></tr>
                        <?php else: $no=1; foreach ($ranking as $r): ?>
                        <tr class="<?= $no <= 3 ? 'table-warning' : '' ?>">
                            <td class="fw-bold"><?= $no ?></td>
                            <td class="fw-bold"><?= htmlspecialchars($r->nama_alternatif) ?></td>
                            <td class="fw-bold text-primary"><?= number_format($r->nilai, 4) ?></td>
                            <td>
                                <?php if ($no == 1): ?><span class="badge bg-success fs-6 px-3 py-2">🏆 Rekomendasi Utama</span>
                                <?php elseif ($no <= 3): ?><span class="badge bg-info">Rekomendasi</span>
                                <?php else: ?><span class="badge bg-secondary">-</span>
                                <?php endif; ?>
                            </td>
                        </tr>
                        <?php $no++; endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
