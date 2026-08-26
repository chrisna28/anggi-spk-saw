<div class="container-fluid">
    <div class="alert alert-primary alert-dismissible shadow-sm mb-4 border-0" role="alert" style="background: white; border-left: 5px solid var(--accent-blue) !important;">
        <div class="d-flex align-items-center">
            <i class="fas fa-info-circle fa-lg me-3 text-primary"></i>
            <div>
                <h6 class="mb-0 fw-bold text-primary">Selamat datang, <?= $alternatif->nama_alternatif ?>!</h6>
                <p class="mb-0 small text-muted">Lengkapi biodata Anda untuk mengikuti proses seleksi. Semakin lengkap data Anda, semakin akurat hasil rekomendasi.</p>
            </div>
        </div>
    </div>

    <div class="row g-4">
        <div class="col-md-3">
            <a href="<?= base_url('Pelamar/profil') ?>" class="text-decoration-none">
                <div class="dash-card shadow-sm border-0">
                    <div class="icon-box"><i class="fas fa-user"></i></div>
                    <div><p class="text-muted small mb-1 fw-bold">BIODATA</p><h3 class="fw-bold mb-0 text-dark"><i class="fas fa-arrow-right small"></i></h3></div>
                </div>
            </a>
        </div>
        <div class="col-md-3">
            <a href="<?= base_url('Pelamar/pengalaman') ?>" class="text-decoration-none">
                <div class="dash-card shadow-sm border-0" style="border-left-color: #2ecc71 !important;">
                    <div class="icon-box" style="background: #eafaf1; color: #2ecc71;"><i class="fas fa-briefcase"></i></div>
                    <div><p class="text-muted small mb-1 fw-bold">PENGALAMAN</p><h3 class="fw-bold mb-0 text-dark"><?= $count_pengalaman ?></h3></div>
                </div>
            </a>
        </div>
        <div class="col-md-3">
            <a href="<?= base_url('Pelamar/pendidikan') ?>" class="text-decoration-none">
                <div class="dash-card shadow-sm border-0" style="border-left-color: #f1c40f !important;">
                    <div class="icon-box" style="background: #fef9e7; color: #f1c40f;"><i class="fas fa-graduation-cap"></i></div>
                    <div><p class="text-muted small mb-1 fw-bold">PENDIDIKAN</p><h3 class="fw-bold mb-0 text-dark"><?= $count_pendidikan ?></h3></div>
                </div>
            </a>
        </div>
        <div class="col-md-3">
            <a href="<?= base_url('Pelamar/berkas') ?>" class="text-decoration-none">
                <div class="dash-card shadow-sm border-0" style="border-left-color: #9b59b6 !important;">
                    <div class="icon-box" style="background: #f5eef8; color: #9b59b6;"><i class="fas fa-file"></i></div>
                    <div><p class="text-muted small mb-1 fw-bold">BERKAS</p><h3 class="fw-bold mb-0 text-dark"><?= $count_berkas ?></h3></div>
                </div>
            </a>
        </div>
    </div>
</div>
