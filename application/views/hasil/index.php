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

<!-- ==================== LAPORAN CETAK ==================== -->
<div class="print-report">
    <div class="print-header">
        <div class="print-logo">
            <img src="<?= base_url('assets/logo.jpeg') ?>" alt="Logo">
        </div>
        <h1 class="print-company"><?= $nama_perusahaan ?></h1>
        <h2 class="print-title">LAPORAN HASIL PERANGKINGAN KARYAWAN TERBAIK</h2>
        <p class="print-period">Periode Penilaian : Tahun <?= $periode ?></p>
    </div>

    <div class="print-meta">
        <table class="print-meta-table">
            <tr>
                <td class="print-meta-label">Dicetak Oleh</td>
                <td class="print-meta-sep">:</td>
                <td><?= $this->session->userdata('nama') ?: 'Admin HRD' ?></td>
            </tr>
            <tr>
                <td class="print-meta-label">Tanggal Cetak</td>
                <td class="print-meta-sep">:</td>
                <td><?= $tanggal_cetak ?></td>
            </tr>
            <tr>
                <td class="print-meta-label">Status</td>
                <td class="print-meta-sep">:</td>
                <td>Disetujui Direktur</td>
            </tr>
            <tr>
                <td class="print-meta-label">Jumlah Karyawan</td>
                <td class="print-meta-sep">:</td>
                <td><?= $total_alternatif ?> Orang</td>
            </tr>
        </table>
    </div>

    <div class="print-table-wrapper">
        <table class="print-table">
            <thead>
                <tr>
                    <th class="print-th-rank">Ranking</th>
                    <th class="print-th-name">Nama Karyawan</th>
                    <?php foreach($kriteria as $k): ?>
                        <th class="print-th-score">
                            <?= $k->nama_kriteria ?><br>
                            <span class="print-th-weight">(<?= $k->bobot ?>%)</span>
                        </th>
                    <?php endforeach; ?>
                    <th class="print-th-pref">Nilai Preferensi (V)</th>
                    <th class="print-th-ket">Keterangan</th>
                </tr>
            </thead>
            <tbody>
                <?php $no=1; foreach($hasil as $h): ?>
                <tr>
                    <td class="text-center"><?= $no ?></td>
                    <td><?= $h['nama'] ?></td>
                    <?php foreach($kriteria as $k): ?>
                        <td class="text-center">
                            <?= $matrix[$h['id_alternatif']][$k->id_kriteria] ?? '-' ?>
                        </td>
                    <?php endforeach; ?>
                    <td class="text-center print-pref"><?= number_format($h['nilai'], 4, ',', '.') ?></td>
                    <td class="text-center">
                        <?php if($no <= 3): ?>
                            Terbaik
                        <?php endif; ?>
                    </td>
                </tr>
                <?php $no++; endforeach; ?>
            </tbody>
        </table>
    </div>

    <div class="print-keterangan">
        <p class="print-ket-title">Keterangan :</p>
        <p>- Nilai Preferensi (V) yang lebih besar menunjukkan kinerja yang lebih baik.</p>
    </div>

    <div class="print-sign">
        <p>Mengetahui,</p>
        <p class="print-sign-role">Direktur <?= $nama_perusahaan ?></p>
        <div class="print-sign-line">
            <span>L</span>
        </div>
    </div>
</div>

<style>
@media print {
    body { margin: 0; padding: 0; }
    #sidebar, .topbar, .d-print-none, .ranking-card { display: none !important; }
    #content { margin-left: 0 !important; width: 100% !important; padding: 0 !important; }
    .container-fluid { display: none !important; }

    .print-report {
        display: block !important;
        font-family: 'Times New Roman', Times, serif;
        font-size: 12px;
        color: #000;
        padding: 20px 30px;
        line-height: 1.5;
    }
}

@media screen {
    .print-report { display: none !important; }
}

.print-report {
    font-family: 'Times New Roman', Times, serif;
    font-size: 12px;
    color: #000;
    max-width: 900px;
    margin: 0 auto;
    padding: 20px 30px;
    line-height: 1.5;
}

.print-header {
    text-align: center;
    margin-bottom: 15px;
    border-bottom: 3px double #000;
    padding-bottom: 15px;
}

.print-logo {
    margin-bottom: 10px;
}

.print-logo img {
    max-height: 80px;
    width: auto;
}

.print-company {
    font-size: 18px;
    font-weight: bold;
    margin: 0 0 5px 0;
    letter-spacing: 1px;
}

.print-title {
    font-size: 15px;
    font-weight: bold;
    margin: 0 0 8px 0;
    text-transform: uppercase;
}

.print-period {
    font-size: 12px;
    margin: 0;
}

.print-meta {
    margin-bottom: 20px;
}

.print-meta-table {
    border-collapse: collapse;
}

.print-meta-table td {
    padding: 2px 5px;
    vertical-align: top;
    font-size: 12px;
}

.print-meta-label {
    font-weight: bold;
    width: 150px;
}

.print-meta-sep {
    width: 15px;
    text-align: center;
}

.print-table-wrapper {
    margin-bottom: 15px;
}

.print-table {
    width: 100%;
    border-collapse: collapse;
    font-size: 11px;
}

.print-table th,
.print-table td {
    border: 1px solid #000;
    padding: 6px 8px;
}

.print-table thead tr {
    background-color: #d9d9d9;
}

.print-th-rank {
    text-align: center;
    width: 55px;
    font-weight: bold;
}

.print-th-name {
    text-align: center;
    width: 100px;
    font-weight: bold;
}

.print-th-score {
    text-align: center;
    font-weight: bold;
    font-size: 10px;
}

.print-th-weight {
    font-weight: normal;
    font-size: 10px;
}

.print-th-pref {
    text-align: center;
    width: 100px;
    font-weight: bold;
}

.print-th-ket {
    text-align: center;
    width: 80px;
    font-weight: bold;
}

.print-pref {
    font-weight: bold;
}

.print-keterangan {
    margin: 15px 0;
    font-size: 11px;
}

.print-ket-title {
    font-weight: bold;
    margin-bottom: 5px;
}

.print-sign {
    margin-top: 40px;
    text-align: left;
    font-size: 12px;
}

.print-sign-role {
    margin-bottom: 60px;
}

.print-sign-line {
    text-align: center;
    width: 150px;
    border-top: 1px solid #000;
    padding-top: 5px;
}
</style>
