<div class="container-fluid">
    <?php if ($msg = $this->session->flashdata('success')): ?>
    <div class="alert alert-success alert-dismissible shadow-sm border-0"><?= $msg ?><button type="button" class="btn-close" data-bs-dismiss="alert"></button></div>
    <?php endif; ?>
    <?php if ($msg = $this->session->flashdata('error')): ?>
    <div class="alert alert-danger alert-dismissible shadow-sm border-0"><?= $msg ?><button type="button" class="btn-close" data-bs-dismiss="alert"></button></div>
    <?php endif; ?>

    <div class="d-flex justify-content-between align-items-center mb-4">
        <h5 class="fw-bold mb-0"><i class="fas fa-file me-2 text-primary"></i>Berkas & Sertifikat</h5>
        <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#modalUpload"><i class="fas fa-upload me-1"></i>Upload</button>
    </div>

    <?php if (!empty($berkas)): ?>
    <?php
    $total = count($berkas);
    $valid = 0; $invalid = 0; $pending = 0;
    foreach ($berkas as $b) {
        if ($b->status_validasi == 'valid') $valid++;
        elseif ($b->status_validasi == 'invalid') $invalid++;
        else $pending++;
    }
    ?>
    <div class="row g-3 mb-4">
        <div class="col-md-4">
            <div class="card shadow-sm border-0" style="border-left: 4px solid #2ecc71 !important;">
                <div class="card-body py-2">
                    <span class="badge bg-success"><i class="fas fa-check"></i> <?= $valid ?> Berkas Valid</span>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card shadow-sm border-0" style="border-left: 4px solid #f39c12 !important;">
                <div class="card-body py-2">
                    <span class="badge bg-warning text-dark"><i class="fas fa-clock"></i> <?= $pending ?> Menunggu Validasi</span>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card shadow-sm border-0" style="border-left: 4px solid #e74c3c !important;">
                <div class="card-body py-2">
                    <span class="badge bg-danger"><i class="fas fa-times"></i> <?= $invalid ?> Tidak Valid</span>
                </div>
            </div>
        </div>
    </div>
    <?php endif; ?>

    <?php if (empty($berkas)): ?>
    <div class="text-center py-5 text-muted"><i class="fas fa-inbox fa-3x mb-3 d-block"></i>Belum ada berkas</div>
    <?php else: ?>
    <div class="row g-3">
        <?php foreach ($berkas as $b): ?>
        <div class="col-md-4">
            <div class="card shadow-sm border-0 h-100">
                <div class="card-body text-center">
                    <?php
                    $is_image = in_array($b->file_type, ['image/jpeg','image/png','image/jpg']);
                    $is_pdf = $b->file_type == 'application/pdf';
                    ?>
                    <?php if ($is_image): ?>
                        <img src="<?= base_url('uploads/'.$b->file_path) ?>" class="img-fluid rounded mb-2" style="max-height: 150px; object-fit: cover;">
                    <?php elseif ($is_pdf): ?>
                        <i class="fas fa-file-pdf text-danger fa-4x mb-2"></i>
                    <?php else: ?>
                        <i class="fas fa-file text-muted fa-4x mb-2"></i>
                    <?php endif; ?>
                    <h6 class="fw-bold small mb-1"><?= htmlspecialchars($b->nama_berkas) ?></h6>
                    <span class="badge bg-secondary mb-2"><?= htmlspecialchars($b->jenis_berkas) ?></span>

                    <div class="mb-2">
                        <?php if ($b->status_validasi == 'pending'): ?>
                            <span class="badge bg-warning text-dark"><i class="fas fa-clock"></i> Menunggu Validasi</span>
                        <?php elseif ($b->status_validasi == 'valid'): ?>
                            <span class="badge bg-success"><i class="fas fa-check-circle"></i> Valid</span>
                        <?php else: ?>
                            <span class="badge bg-danger"><i class="fas fa-times-circle"></i> Tidak Valid</span>
                            <?php if ($b->catatan_hrd): ?>
                                <div class="small text-danger mt-1 text-start">
                                    <i class="fas fa-info-circle"></i> <?= htmlspecialchars($b->catatan_hrd) ?>
                                </div>
                            <?php endif; ?>
                        <?php endif; ?>
                    </div>

                    <div class="d-flex justify-content-center gap-1">
                        <a href="<?= base_url('uploads/'.$b->file_path) ?>" target="_blank" class="btn btn-sm btn-outline-primary"><i class="fas fa-eye"></i></a>
                        <a href="<?= base_url('Pelamar/hapus_berkas/'.$b->id_berkas) ?>" class="btn btn-sm btn-outline-danger" onclick="return confirm('Hapus berkas ini?')"><i class="fas fa-trash"></i></a>
                    </div>
                </div>
            </div>
        </div>
        <?php endforeach; ?>
    </div>
    <?php endif; ?>
</div>

<div class="modal fade" id="modalUpload" tabindex="-1">
    <div class="modal-dialog">
        <form method="post" action="<?= base_url('Pelamar/upload_berkas') ?>" enctype="multipart/form-data" class="modal-content">
            <div class="modal-header"><h5 class="modal-title fw-bold">Upload Berkas</h5><button type="button" class="btn-close" data-bs-dismiss="modal"></button></div>
            <div class="modal-body">
                <div class="mb-3"><label class="form-label small fw-bold">Nama Berkas</label><input type="text" name="nama_berkas" class="form-control" required placeholder="Contoh: Ijazah S1"></div>
                <div class="mb-3"><label class="form-label small fw-bold">Jenis Berkas</label>
                    <select name="jenis_berkas" class="form-select" required>
                        <option value="">Pilih Jenis</option>
                        <option value="Ijazah SD">Ijazah SD</option>
                        <option value="Ijazah SMP">Ijazah SMP</option>
                        <option value="Ijazah SMA">Ijazah SMA</option>
                        <option value="Ijazah D3">Ijazah D3</option>
                        <option value="Ijazah S1">Ijazah S1</option>
                        <option value="Ijazah S2">Ijazah S2</option>
                        <option value="Ijazah S3">Ijazah S3</option>
                        <option value="Sertifikat">Sertifikat</option>
                        <option value="CV">CV</option>
                        <option value="Lainnya">Lainnya</option>
                    </select>
                </div>
                <div class="mb-3"><label class="form-label small fw-bold">File</label><input type="file" name="file_berkas" class="form-control" required accept=".pdf,.jpg,.jpeg,.png,.doc,.docx"></div>
                <small class="text-muted">Format: PDF, JPG, PNG, DOC, DOCX. Maks 5MB.</small>
            </div>
            <div class="modal-footer"><button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button><button type="submit" class="btn btn-primary">Upload</button></div>
        </form>
    </div>
</div>
