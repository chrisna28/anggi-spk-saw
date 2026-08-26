<div class="container-fluid">
    <div class="alert alert-primary alert-dismissible shadow-sm mb-4 border-0" role="alert" style="background: white; border-left: 5px solid var(--accent-blue) !important;">
        <div class="d-flex align-items-center">
            <i class="fas fa-info-circle fa-lg me-3 text-primary"></i>
            <div>
                <h6 class="mb-0 fw-bold text-primary">Selamat datang, <?= $this->session->userdata('nama') ?>!</h6>
                <p class="mb-0 small text-muted">Anda dapat memantau seluruh proses penilaian dan hasil rekomendasi karyawan.</p>
            </div>
        </div>
    </div>

    <div class="row g-4 mb-4">
        <div class="col-md-4">
            <div class="dash-card shadow-sm border-0">
                <div class="icon-box"><i class="fas fa-users"></i></div>
                <div><p class="text-muted small mb-1 fw-bold">TOTAL PELAMAR</p><h3 class="fw-bold mb-0 text-dark"><?= $count_alternatif ?></h3></div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="dash-card shadow-sm border-0" style="border-left-color: #2ecc71 !important;">
                <div class="icon-box" style="background: #eafaf1; color: #2ecc71;"><i class="fas fa-list-ul"></i></div>
                <div><p class="text-muted small mb-1 fw-bold">KRITERIA</p><h3 class="fw-bold mb-0 text-dark"><?= $count_kriteria ?></h3></div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="dash-card shadow-sm border-0" style="border-left-color: #f1c40f !important;">
                <div class="icon-box" style="background: #fef9e7; color: #f1c40f;"><i class="fas fa-chart-line"></i></div>
                <div><p class="text-muted small mb-1 fw-bold">PELAMAR DINILAI</p><h3 class="fw-bold mb-0 text-dark"><?= $total_pelamar ?></h3></div>
            </div>
        </div>
    </div>

    <?php if (!empty($ranking_top)): ?>
    <div class="card shadow-sm border-0">
        <div class="card-header bg-white border-0"><h6 class="fw-bold mb-0"><i class="fas fa-trophy me-2 text-warning"></i>Top 3 Pelamar</h6></div>
        <div class="card-body">
            <table class="table table-hover">
                <thead><tr><th>#</th><th>Nama</th><th>Nilai</th><th>Status</th></tr></thead>
                <tbody>
                    <?php foreach ($ranking_top as $i => $r): ?>
                    <tr>
                        <td class="fw-bold"><?= $i+1 ?></td>
                        <td><?= htmlspecialchars($r->nama_alternatif) ?></td>
                        <td><?= number_format($r->nilai, 4) ?></td>
                        <td><span class="badge bg-success">Rekomendasi</span></td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
            <a href="<?= base_url('Atasan/hasil') ?>" class="btn btn-sm btn-outline-primary">Lihat Semua</a>
        </div>
    </div>
    <?php endif; ?>
</div>
