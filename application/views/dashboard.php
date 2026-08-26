<div class="container-fluid">
    <div class="alert alert-primary alert-dismissible shadow-sm mb-4 border-0" role="alert" style="background: white; border-left: 5px solid var(--accent-blue) !important;">
        <div class="d-flex align-items-center">
            <i class="fas fa-info-circle fa-lg me-3 text-primary"></i>
            <div>
                <h6 class="mb-0 fw-bold text-primary">Selamat datang kembali!</h6>
                <p class="mb-0 small text-muted">Halo <strong><?= $this->session->userdata('nama') ?></strong>, Anda masuk sebagai Administrator. Silakan gunakan menu di samping untuk mengelola sistem.</p>
            </div>
        </div>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>

    <div class="row g-4">
        <!-- Card 1: Kriteria -->
        <div class="col-md-4">
            <a href="<?= base_url('Kriteria') ?>" class="text-decoration-none">
                <div class="dash-card shadow-sm border-0">
                    <div class="icon-box">
                        <i class="fas fa-list-ul"></i>
                    </div>
                    <div>
                        <p class="text-muted small mb-1 fw-bold">KRITERIA</p>
                        <h3 class="fw-bold mb-0 text-dark"><?= $count_kriteria ?></h3>
                    </div>
                </div>
            </a>
        </div>

        <!-- Card 2: Sub Kriteria -->
        <div class="col-md-4">
            <a href="<?= base_url('Sub_Kriteria') ?>" class="text-decoration-none">
                <div class="dash-card shadow-sm border-0" style="border-left-color: #2ecc71 !important;">
                    <div class="icon-box" style="background: #eafaf1; color: #2ecc71;">
                        <i class="fas fa-layer-group"></i>
                    </div>
                    <div>
                        <p class="text-muted small mb-1 fw-bold">SUB KRITERIA</p>
                        <h3 class="fw-bold mb-0 text-dark"><?= $count_sub ?></h3>
                    </div>
                </div>
            </a>
        </div>

        <!-- Card 3: Alternatif -->
        <div class="col-md-4">
            <a href="<?= base_url('Alternatif') ?>" class="text-decoration-none">
                <div class="dash-card shadow-sm border-0" style="border-left-color: #f1c40f !important;">
                    <div class="icon-box" style="background: #fef9e7; color: #f1c40f;">
                        <i class="fas fa-users"></i>
                    </div>
                    <div>
                        <p class="text-muted small mb-1 fw-bold">ALTERNATIF</p>
                        <h3 class="fw-bold mb-0 text-dark"><?= $count_alternatif ?></h3>
                    </div>
                </div>
            </a>
        </div>

        <!-- Card 4: Penilaian -->
        <div class="col-md-4">
            <a href="<?= base_url('Penilaian') ?>" class="text-decoration-none">
                <div class="dash-card shadow-sm border-0" style="border-left-color: #9b59b6 !important;">
                    <div class="icon-box" style="background: #f5eef8; color: #9b59b6;">
                        <i class="fas fa-edit"></i>
                    </div>
                    <div>
                        <p class="text-muted small mb-1 fw-bold">PENILAIAN</p>
                        <h6 class="mb-0 fw-bold text-dark">Input Nilai <i class="fas fa-arrow-right ms-1 small"></i></h6>
                    </div>
                </div>
            </a>
        </div>

        <!-- Card 5: Perhitungan -->
        <div class="col-md-4">
            <a href="<?= base_url('Perhitungan') ?>" class="text-decoration-none">
                <div class="dash-card shadow-sm border-0" style="border-left-color: #34495e !important;">
                    <div class="icon-box" style="background: #ebedef; color: #34495e;">
                        <i class="fas fa-calculator"></i>
                    </div>
                    <div>
                        <p class="text-muted small mb-1 fw-bold">PROSES SAW</p>
                        <h6 class="mb-0 fw-bold text-dark">Lihat Matriks <i class="fas fa-arrow-right ms-1 small"></i></h6>
                    </div>
                </div>
            </a>
        </div>

        <!-- Card 6: Hasil -->
        <div class="col-md-4">
            <a href="<?= base_url('Hasil') ?>" class="text-decoration-none">
                <div class="dash-card shadow-sm border-0" style="border-left-color: #e67e22 !important;">
                    <div class="icon-box" style="background: #fdf2e9; color: #e67e22;">
                        <i class="fas fa-chart-line"></i>
                    </div>
                    <div>
                        <p class="text-muted small mb-1 fw-bold">HASIL AKHIR</p>
                        <h6 class="mb-0 fw-bold text-dark">Ranking <i class="fas fa-arrow-right ms-1 small"></i></h6>
                    </div>
                </div>
            </a>
        </div>
    </div>
</div>
