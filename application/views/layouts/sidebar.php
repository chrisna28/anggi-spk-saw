<nav id="sidebar">
    <div class="sidebar-header">
        <h4 class="mb-0 fw-bold"><i class="fas fa-layer-group me-2"></i> SPK SAW</h4>
    </div>

    <?php $level = $this->session->userdata('level'); ?>

    <?php if ($level === 'admin'): ?>
    <ul class="list-unstyled components">
        <li class="<?= $this->uri->segment(1) == 'Dashboard' ? 'active' : '' ?>">
            <a href="<?= base_url('Dashboard') ?>"><i class="fas fa-home me-2"></i> Dashboard</a>
        </li>
        <div class="section-title text-white">Master Data</div>
        <li class="<?= $this->uri->segment(1) == 'Kriteria' ? 'active' : '' ?>">
            <a href="<?= base_url('Kriteria') ?>"><i class="fas fa-cube me-2"></i> Data Kriteria</a>
        </li>
        <li class="<?= $this->uri->segment(1) == 'Sub_Kriteria' ? 'active' : '' ?>">
            <a href="<?= base_url('Sub_Kriteria') ?>"><i class="fas fa-cubes me-2"></i> Data Sub Kriteria</a>
        </li>
        <li class="<?= $this->uri->segment(1) == 'Alternatif' ? 'active' : '' ?>">
            <a href="<?= base_url('Alternatif') ?>"><i class="fas fa-users me-2"></i> Data Alternatif</a>
        </li>
        <li class="<?= $this->uri->segment(1) == 'Penilaian' ? 'active' : '' ?>">
            <a href="<?= base_url('Penilaian') ?>"><i class="fas fa-edit me-2"></i> Data Penilaian</a>
        </li>
        <li class="<?= $this->uri->segment(1) == 'Perhitungan' ? 'active' : '' ?>">
            <a href="<?= base_url('Perhitungan') ?>"><i class="fas fa-calculator me-2"></i> Data Perhitungan</a>
        </li>
        <li class="<?= $this->uri->segment(1) == 'Hasil' ? 'active' : '' ?>">
            <a href="<?= base_url('Hasil') ?>"><i class="fas fa-chart-bar me-2"></i> Data Hasil Akhir</a>
        </li>
        <div class="section-title text-white">Validasi</div>
        <li class="<?= $this->uri->segment(1) == 'ValidasiBerkas' ? 'active' : '' ?>">
            <a href="<?= base_url('ValidasiBerkas') ?>"><i class="fas fa-check-circle me-2"></i> Validasi Berkas</a>
        </li>
        <div class="section-title text-white">Auto Skoring</div>
        <li class="<?= $this->uri->segment(1) == 'AutoSkoring' ? 'active' : '' ?>">
            <a href="<?= base_url('AutoSkoring') ?>"><i class="fas fa-robot me-2"></i> Auto Skoring</a>
        </li>
        <li class="<?= $this->uri->segment(1) == 'AturanSkoring' ? 'active' : '' ?>">
            <a href="<?= base_url('AturanSkoring') ?>"><i class="fas fa-cog me-2"></i> Aturan Skoring</a>
        </li>
    </ul>
    <?php elseif ($level === 'atasan'): ?>
    <ul class="list-unstyled components">
        <li class="<?= $this->uri->segment(1) == 'Atasan' && $this->uri->segment(2) == '' ? 'active' : '' ?>">
            <a href="<?= base_url('Atasan') ?>"><i class="fas fa-home me-2"></i> Dashboard</a>
        </li>
        <div class="section-title text-white">Monitoring</div>
        <li class="<?= $this->uri->segment(1) == 'Atasan' && $this->uri->segment(2) == 'pelamar' ? 'active' : '' ?>">
            <a href="<?= base_url('Atasan/pelamar') ?>"><i class="fas fa-users me-2"></i> Data Pelamar</a>
        </li>
        <li class="<?= $this->uri->segment(1) == 'Atasan' && $this->uri->segment(2) == 'penilaian' ? 'active' : '' ?>">
            <a href="<?= base_url('Atasan/penilaian') ?>"><i class="fas fa-edit me-2"></i> Penilaian</a>
        </li>
        <li class="<?= $this->uri->segment(1) == 'Atasan' && $this->uri->segment(2) == 'perhitungan' ? 'active' : '' ?>">
            <a href="<?= base_url('Atasan/perhitungan') ?>"><i class="fas fa-calculator me-2"></i> Perhitungan</a>
        </li>
        <li class="<?= $this->uri->segment(1) == 'Atasan' && $this->uri->segment(2) == 'hasil' ? 'active' : '' ?>">
            <a href="<?= base_url('Atasan/hasil') ?>"><i class="fas fa-chart-bar me-2"></i> Hasil Akhir</a>
        </li>
    </ul>
    <?php elseif ($level === 'pelamar'): ?>
    <ul class="list-unstyled components">
        <li class="<?= $this->uri->segment(1) == 'Pelamar' && $this->uri->segment(2) == '' ? 'active' : '' ?>">
            <a href="<?= base_url('Pelamar') ?>"><i class="fas fa-home me-2"></i> Dashboard</a>
        </li>
        <div class="section-title text-white">Biodata</div>
        <li class="<?= $this->uri->segment(1) == 'Pelamar' && $this->uri->segment(2) == 'profil' ? 'active' : '' ?>">
            <a href="<?= base_url('Pelamar/profil') ?>"><i class="fas fa-user me-2"></i> Profil Saya</a>
        </li>
        <li class="<?= $this->uri->segment(1) == 'Pelamar' && $this->uri->segment(2) == 'pengalaman' ? 'active' : '' ?>">
            <a href="<?= base_url('Pelamar/pengalaman') ?>"><i class="fas fa-briefcase me-2"></i> Pengalaman Kerja</a>
        </li>
        <li class="<?= $this->uri->segment(1) == 'Pelamar' && $this->uri->segment(2) == 'pendidikan' ? 'active' : '' ?>">
            <a href="<?= base_url('Pelamar/pendidikan') ?>"><i class="fas fa-graduation-cap me-2"></i> Pendidikan</a>
        </li>
        <li class="<?= $this->uri->segment(1) == 'Pelamar' && $this->uri->segment(2) == 'organisasi' ? 'active' : '' ?>">
            <a href="<?= base_url('Pelamar/organisasi') ?>"><i class="fas fa-users me-2"></i> Organisasi</a>
        </li>
        <li class="<?= $this->uri->segment(1) == 'Pelamar' && $this->uri->segment(2) == 'berkas' ? 'active' : '' ?>">
            <a href="<?= base_url('Pelamar/berkas') ?>"><i class="fas fa-file me-2"></i> Berkas</a>
        </li>
        <div class="section-title text-white">Hasil</div>
        <li class="<?= $this->uri->segment(1) == 'Pelamar' && $this->uri->segment(2) == 'hasil' ? 'active' : '' ?>">
            <a href="<?= base_url('Pelamar/hasil') ?>"><i class="fas fa-chart-line me-2"></i> Hasil Rekomendasi</a>
        </li>
    </ul>
    <?php endif; ?>

    <ul class="list-unstyled mb-3">
        <li>
            <a href="<?= base_url('Auth/logout') ?>"><i class="fas fa-sign-out-alt me-2"></i> Keluar</a>
        </li>
    </ul>
</nav>

<div id="content">
