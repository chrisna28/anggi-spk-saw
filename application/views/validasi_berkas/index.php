<div class="container-fluid">
    <?php if ($msg = $this->session->flashdata('success')): ?>
    <div class="alert alert-success alert-dismissible shadow-sm border-0"><?= $msg ?><button type="button" class="btn-close" data-bs-dismiss="alert"></button></div>
    <?php endif; ?>
    <?php if ($msg = $this->session->flashdata('error')): ?>
    <div class="alert alert-danger alert-dismissible shadow-sm border-0"><?= $msg ?><button type="button" class="btn-close" data-bs-dismiss="alert"></button></div>
    <?php endif; ?>

    <div class="d-flex justify-content-between align-items-center mb-4">
        <h5 class="fw-bold mb-0"><i class="fas fa-check-circle me-2 text-primary"></i>Validasi Berkas Pelamar</h5>
    </div>

    <?php if (!empty($berkas)): ?>
    <div class="row g-3 mb-4">
        <div class="col-md-3">
            <div class="card shadow-sm border-0">
                <div class="card-body">
                    <p class="text-muted small mb-1 fw-bold">TOTAL BERKAS</p>
                    <h3 class="fw-bold mb-0"><?= $summary['total'] ?></h3>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card shadow-sm border-0" style="border-left: 4px solid #2ecc71 !important;">
                <div class="card-body">
                    <p class="text-muted small mb-1 fw-bold">VALID</p>
                    <h3 class="fw-bold mb-0 text-success"><?= $summary['valid'] ?></h3>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card shadow-sm border-0" style="border-left: 4px solid #f39c12 !important;">
                <div class="card-body">
                    <p class="text-muted small mb-1 fw-bold">PENDING</p>
                    <h3 class="fw-bold mb-0 text-warning"><?= $summary['pending'] ?></h3>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card shadow-sm border-0" style="border-left: 4px solid #e74c3c !important;">
                <div class="card-body">
                    <p class="text-muted small mb-1 fw-bold">TIDAK VALID</p>
                    <h3 class="fw-bold mb-0 text-danger"><?= $summary['invalid'] ?></h3>
                </div>
            </div>
        </div>
    </div>
    <?php endif; ?>

    <?php if (empty($berkas)): ?>
    <div class="text-center py-5 text-muted"><i class="fas fa-inbox fa-3x mb-3 d-block"></i>Belum ada berkas untuk divalidasi</div>
    <?php else: ?>
    <div class="card shadow-sm border-0">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>Pelamar</th>
                            <th>Nama Berkas</th>
                            <th>Jenis</th>
                            <th>File</th>
                            <th>Tanggal Upload</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($berkas as $b): ?>
                        <tr>
                            <td>
                                <div class="fw-bold"><?= htmlspecialchars($b->nama_alternatif) ?></div>
                                <small class="text-muted"><?= htmlspecialchars($b->email) ?></small>
                            </td>
                            <td><?= htmlspecialchars($b->nama_berkas) ?></td>
                            <td><span class="badge bg-secondary"><?= htmlspecialchars($b->jenis_berkas) ?></span></td>
                            <td>
                                <a href="<?= base_url('uploads/'.$b->file_path) ?>" target="_blank" class="btn btn-sm btn-outline-primary">
                                    <i class="fas fa-eye"></i> Lihat
                                </a>
                            </td>
                            <td><?= date('d/m/Y H:i', strtotime($b->uploaded_at)) ?></td>
                            <td>
                                <?php if ($b->status_validasi == 'pending'): ?>
                                    <span class="badge bg-warning text-dark">Pending</span>
                                <?php elseif ($b->status_validasi == 'valid'): ?>
                                    <span class="badge bg-success">Valid</span>
                                <?php else: ?>
                                    <span class="badge bg-danger">Tidak Valid</span>
                                <?php endif; ?>
                                <?php if ($b->catatan_hrd): ?>
                                    <div class="small text-muted mt-1"><i class="fas fa-sticky-note"></i> <?= htmlspecialchars($b->catatan_hrd) ?></div>
                                <?php endif; ?>
                            </td>
                            <td>
                                <button class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#modalValidasi<?= $b->id_berkas ?>">
                                    <i class="fas fa-check"></i> Validasi
                                </button>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <?php endif; ?>
</div>

<?php foreach ($berkas as $b): ?>
<div class="modal fade" id="modalValidasi<?= $b->id_berkas ?>" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <form method="post" action="<?= base_url('ValidasiBerkas/validasi/'.$b->id_berkas) ?>" class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title fw-bold">Validasi Berkas</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="row g-4">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label small fw-bold">Pelamar</label>
                            <div class="form-control-plaintext"><?= htmlspecialchars($b->nama_alternatif) ?></div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label small fw-bold">Nama Berkas</label>
                            <div class="form-control-plaintext"><?= htmlspecialchars($b->nama_berkas) ?></div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label small fw-bold">Jenis</label>
                            <div class="form-control-plaintext"><span class="badge bg-secondary"><?= htmlspecialchars($b->jenis_berkas) ?></span></div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label small fw-bold">Status Validasi</label>
                            <select name="status" class="form-select" required>
                                <option value="">Pilih Status</option>
                                <option value="valid">Valid (Berkas Benar)</option>
                                <option value="invalid">Tidak Valid (Berkas Salah)</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label small fw-bold">Catatan HRD <small class="text-muted">(opsional)</small></label>
                            <textarea name="catatan" class="form-control" rows="4" placeholder="Tambahkan catatan jika berkas tidak valid..."></textarea>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label small fw-bold">Preview File</label>
                        <div class="border rounded p-3 text-center bg-light h-100 d-flex flex-column justify-content-center align-items-center">
                            <?php
                            $is_image = in_array($b->file_type, ['image/jpeg','image/png','image/jpg']);
                            $is_pdf = $b->file_type == 'application/pdf';
                            ?>
                            <?php if ($is_image): ?>
                                <img src="<?= base_url('uploads/'.$b->file_path) ?>" class="img-fluid rounded mb-2" style="max-height: 300px; object-fit: contain;">
                            <?php elseif ($is_pdf): ?>
                                <i class="fas fa-file-pdf text-danger fa-5x mb-3"></i>
                                <div class="small text-muted">File PDF</div>
                            <?php else: ?>
                                <i class="fas fa-file text-muted fa-5x mb-3"></i>
                                <div class="small text-muted">File Dokumen</div>
                            <?php endif; ?>
                            <a href="<?= base_url('uploads/'.$b->file_path) ?>" target="_blank" class="btn btn-sm btn-outline-primary mt-2">
                                <i class="fas fa-external-link-alt"></i> Buka di Tab Baru
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                <button type="submit" class="btn btn-primary">Simpan Validasi</button>
            </div>
        </form>
    </div>
</div>
<?php endforeach; ?>
