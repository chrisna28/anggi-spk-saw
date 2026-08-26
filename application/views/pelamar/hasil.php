<div class="container-fluid">
    <div class="card shadow-sm border-0">
        <div class="card-body p-4 text-center">
            <h5 class="fw-bold mb-4"><i class="fas fa-chart-line me-2 text-primary"></i>Hasil Rekomendasi</h5>

            <?php if ($hasil): ?>
            <div class="py-4">
                <div class="display-1 fw-bold text-primary mb-2">#<?= $posisi ?></div>
                <p class="text-muted mb-1">dari <?= $total ?> pelamar</p>
                <div class="mt-3">
                    <span class="badge bg-<?= $posisi <= 3 ? 'success' : 'secondary' ?> fs-6 px-3 py-2">
                        <?php if ($posisi == 1): ?>🏆 Peringkat Pertama
                        <?php elseif ($posisi == 2): ?>🥈 Peringkat Kedua
                        <?php elseif ($posisi == 3): ?>🥉 Peringkat Ketiga
                        <?php else: ?>Peringkat Ke-<?= $posisi ?>
                        <?php endif; ?>
                    </span>
                </div>
                <div class="mt-4">
                    <h3 class="fw-bold text-dark"><?= number_format($hasil->nilai, 4) ?></h3>
                    <p class="text-muted small">Nilai Preferensi (V)</p>
                </div>
            </div>
            <?php else: ?>
            <div class="py-5 text-muted">
                <i class="fas fa-clock fa-3x mb-3 d-block"></i>
                <p>Hasil rekomendasi belum tersedia. <br>Silakan lengkapi data Anda dan tunggu proses penilaian dari HRD.</p>
            </div>
            <?php endif; ?>
        </div>
    </div>
</div>
