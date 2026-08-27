<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h5 class="fw-bold mb-0"><i class="fas fa-user me-2 text-primary"></i>Detail Pelamar</h5>
        <a href="<?= base_url('Atasan/pelamar') ?>" class="btn btn-outline-secondary btn-sm"><i class="fas fa-arrow-left me-1"></i>Kembali</a>
    </div>

    <!-- Profil -->
    <div class="card shadow-sm border-0 mb-4">
        <div class="card-body">
            <h6 class="fw-bold mb-3"><i class="fas fa-id-card me-2 text-primary"></i>Profil</h6>
            <div class="row">
                <div class="col-md-3 small text-muted fw-bold">Nama</div><div class="col-md-9 mb-2"><?= htmlspecialchars($alternatif->nama_alternatif) ?></div>
                <div class="col-md-3 small text-muted fw-bold">Email</div><div class="col-md-9 mb-2"><?= htmlspecialchars($alternatif->email) ?: '-' ?></div>
                <div class="col-md-3 small text-muted fw-bold">No. Telp</div><div class="col-md-9 mb-2"><?= htmlspecialchars($alternatif->no_telp) ?: '-' ?></div>
                <div class="col-md-3 small text-muted fw-bold">Alamat</div><div class="col-md-9 mb-2"><?= nl2br(htmlspecialchars($alternatif->alamat)) ?: '-' ?></div>
                <div class="col-md-3 small text-muted fw-bold">Jarak Rumah</div><div class="col-md-9 mb-2"><?= htmlspecialchars($alternatif->jarak_rumah) ?: '-' ?> km</div>
                <div class="col-md-3 small text-muted fw-bold">Riwayat Penyakit</div>
                <div class="col-md-9">
                    <?php if ($alternatif->riwayat_penyakit == 'Ya'): ?>
                        <span class="badge bg-danger">Ya</span>
                        <p class="small mt-1 mb-0"><?= nl2br(htmlspecialchars($alternatif->riwayat_penyakit_detail)) ?></p>
                    <?php else: ?>
                        <span class="badge bg-success">Tidak</span>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>

    <!-- Pengalaman -->
    <div class="card shadow-sm border-0 mb-4">
        <div class="card-header bg-white border-0"><h6 class="fw-bold mb-0"><i class="fas fa-briefcase me-2 text-primary"></i>Pengalaman Kerja</h6></div>
        <div class="card-body">
            <?php if (empty($pengalaman)): ?><p class="text-muted small mb-0">Tidak ada data</p>
            <?php else: ?>
            <?php foreach ($pengalaman as $p): ?>
            <div class="mb-3 pb-3 border-bottom">
                <div class="fw-bold"><?= htmlspecialchars($p->posisi) ?></div>
                <div class="small text-muted"><?= htmlspecialchars($p->nama_perusahaan) ?> | <?= $p->tahun_mulai ?> - <?= $p->tahun_selesai ?: 'Sekarang' ?></div>
                <?php if ($p->deskripsi): ?><div class="small mt-1"><?= nl2br(htmlspecialchars($p->deskripsi)) ?></div><?php endif; ?>
            </div>
            <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </div>

    <!-- Pendidikan -->
    <div class="card shadow-sm border-0 mb-4">
        <div class="card-header bg-white border-0"><h6 class="fw-bold mb-0"><i class="fas fa-graduation-cap me-2 text-primary"></i>Pendidikan</h6></div>
        <div class="card-body">
            <?php if (empty($pendidikan)): ?><p class="text-muted small mb-0">Tidak ada data</p>
            <?php else: ?>
            <?php foreach ($pendidikan as $p): ?>
            <div class="mb-3 pb-3 border-bottom">
                <span class="badge bg-primary"><?= $p->jenjang ?></span>
                <div class="fw-bold mt-1"><?= htmlspecialchars($p->jurusan ?: $p->nama_sekolah) ?></div>
                <div class="small text-muted"><?= htmlspecialchars($p->nama_sekolah) ?> | <?= $p->tahun_masuk ?> - <?= $p->tahun_lulus ?: 'Sekarang' ?></div>
            </div>
            <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </div>

    <!-- Organisasi -->
    <div class="card shadow-sm border-0 mb-4">
        <div class="card-header bg-white border-0"><h6 class="fw-bold mb-0"><i class="fas fa-users me-2 text-primary"></i>Organisasi</h6></div>
        <div class="card-body">
            <?php if (empty($organisasi)): ?><p class="text-muted small mb-0">Tidak ada data</p>
            <?php else: ?>
            <?php foreach ($organisasi as $o): ?>
            <div class="mb-3 pb-3 border-bottom">
                <div class="fw-bold"><?= htmlspecialchars($o->nama_organisasi) ?></div>
                <div class="small text-muted"><?= htmlspecialchars($o->jabatan) ?> | <?= $o->tahun_mulai ?> - <?= $o->tahun_selesai ?: 'Sekarang' ?></div>
            </div>
            <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </div>

    <!-- Berkas -->
    <div class="card shadow-sm border-0">
        <div class="card-header bg-white border-0">
            <div class="d-flex justify-content-between align-items-center">
                <h6 class="fw-bold mb-0"><i class="fas fa-file me-2 text-primary"></i>Berkas</h6>
                <?php
                $total = count($berkas);
                $valid = 0; $invalid = 0; $pending = 0;
                foreach ($berkas as $b) {
                    if ($b->status_validasi == 'valid') $valid++;
                    elseif ($b->status_validasi == 'invalid') $invalid++;
                    else $pending++;
                }
                ?>
                <?php if ($total > 0): ?>
                <div>
                    <span class="badge bg-success"><i class="fas fa-check"></i> <?= $valid ?> Valid</span>
                    <span class="badge bg-warning text-dark"><i class="fas fa-clock"></i> <?= $pending ?> Pending</span>
                    <span class="badge bg-danger"><i class="fas fa-times"></i> <?= $invalid ?> Tidak Valid</span>
                </div>
                <?php endif; ?>
            </div>
        </div>
        <div class="card-body">
            <?php if (empty($berkas)): ?><p class="text-muted small mb-0">Tidak ada berkas</p>
            <?php else: ?>
            <div class="row g-2">
                <?php foreach ($berkas as $b): ?>
                <div class="col-md-3">
                    <div class="card border-0 bg-light">
                        <div class="card-body text-center py-3">
                            <?php
                            $is_image = in_array($b->file_type, ['image/jpeg','image/png','image/jpg']);
                            $is_pdf = $b->file_type == 'application/pdf';
                            ?>
                            <?php if ($is_image): ?>
                            <img src="<?= base_url('uploads/'.$b->file_path) ?>" class="img-fluid rounded mb-2" style="max-height: 80px;">
                            <?php elseif ($is_pdf): ?>
                            <i class="fas fa-file-pdf text-danger fa-2x mb-1"></i>
                            <?php else: ?>
                            <i class="fas fa-file text-muted fa-2x mb-1"></i>
                            <?php endif; ?>
                            <div class="small fw-bold"><?= htmlspecialchars($b->nama_berkas) ?></div>
                            <span class="badge bg-secondary" style="font-size: 0.65rem;"><?= htmlspecialchars($b->jenis_berkas) ?></span>

                            <div class="mt-2">
                                <?php if ($b->status_validasi == 'pending'): ?>
                                    <span class="badge bg-warning text-dark" style="font-size: 0.65rem;"><i class="fas fa-clock"></i> Pending</span>
                                <?php elseif ($b->status_validasi == 'valid'): ?>
                                    <span class="badge bg-success" style="font-size: 0.65rem;"><i class="fas fa-check"></i> Valid</span>
                                <?php else: ?>
                                    <span class="badge bg-danger" style="font-size: 0.65rem;"><i class="fas fa-times"></i> Tidak Valid</span>
                                    <?php if ($b->catatan_hrd): ?>
                                        <div class="small text-danger mt-1" style="font-size: 0.65rem;">
                                            <i class="fas fa-info-circle"></i> <?= htmlspecialchars($b->catatan_hrd) ?>
                                        </div>
                                    <?php endif; ?>
                                <?php endif; ?>
                            </div>

                            <div class="mt-1"><a href="<?= base_url('uploads/'.$b->file_path) ?>" target="_blank" class="btn btn-xs btn-outline-primary"><i class="fas fa-eye"></i> Preview</a></div>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
            <?php endif; ?>
        </div>
    </div>
</div>
