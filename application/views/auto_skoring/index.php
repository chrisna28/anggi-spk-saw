<div class="container-fluid">
    <?php if ($msg = $this->session->flashdata('success')): ?>
    <div class="alert alert-success alert-dismissible shadow-sm border-0"><?= $msg ?><button type="button" class="btn-close" data-bs-dismiss="alert"></button></div>
    <?php endif; ?>
    <?php if ($msg = $this->session->flashdata('error')): ?>
    <div class="alert alert-danger alert-dismissible shadow-sm border-0"><?= $msg ?><button type="button" class="btn-close" data-bs-dismiss="alert"></button></div>
    <?php endif; ?>

    <div class="d-flex justify-content-between align-items-center mb-4">
        <h5 class="fw-bold mb-0"><i class="fas fa-robot me-2 text-primary"></i>Auto Skoring</h5>
        <a href="<?= base_url('AturanSkoring') ?>" class="btn btn-outline-primary btn-sm"><i class="fas fa-cog me-1"></i>Aturan Skoring</a>
    </div>

    <div class="row">
        <div class="col-md-8">
            <div class="card shadow-sm border-0">
                <div class="card-body text-center py-5">
                    <i class="fas fa-magic fa-4x text-primary mb-3"></i>
                    <h6 class="fw-bold">Generate Penilaian Otomatis</h6>
                    <p class="text-muted small mb-4">Sistem akan membaca data pelamar (pengalaman, pendidikan, organisasi, berkas) dan mencocokkan dengan aturan skoring untuk mengisi penilaian secara otomatis.</p>

                    <?php if ($aturan_count == 0): ?>
                    <div class="alert alert-warning"><i class="fas fa-exclamation-triangle me-2"></i>Belum ada aturan skoring. <a href="<?= base_url('AturanSkoring/tambah') ?>" class="alert-link">Buat aturan</a> terlebih dahulu.</div>
                    <?php else: ?>
                    <p class="small text-muted mb-3"><?= $aturan_count ?> aturan skoring tersedia. <?= count($alternatif) ?> pelamar akan diproses.</p>
                    <a href="<?= base_url('AutoSkoring/generate') ?>" class="btn btn-primary btn-lg px-5" onclick="return confirm('Generate penilaian untuk semua pelamar? Data penilaian yang sudah ada akan ditimpa.')">
                        <i class="fas fa-play me-2"></i>Generate Semua Pelamar
                    </a>
                    <?php endif; ?>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-white border-0"><h6 class="fw-bold mb-0"><i class="fas fa-info-circle me-2 text-primary"></i>Informasi</h6></div>
                <div class="card-body">
                    <p class="small text-muted mb-2"><strong>Cara kerja:</strong></p>
                    <ol class="small text-muted ps-3">
                        <li class="mb-1">Pelamar mengisi data (pengalaman, pendidikan, organisasi) dan upload berkas</li>
                        <li class="mb-1">HRD membuat aturan skoring di menu Aturan Skoring</li>
                        <li class="mb-1">Klik Generate untuk mengisi penilaian otomatis</li>
                        <li>HRD review hasil penilaian dan bisa edit manual</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
</div>
