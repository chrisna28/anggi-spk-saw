<div class="container-fluid">
    <div class="d-flex align-items-center justify-content-between mb-4">
        <h4 class="mb-0 fw-bold border-start border-4 ps-3" style="border-color: var(--accent-blue) !important;"><i class="fas fa-cube me-2"></i> Data Kriteria</h4>
        <button class="btn btn-success shadow-sm btn-sm px-3" data-bs-toggle="modal" data-bs-target="#modalTambah">
            <i class="fas fa-plus me-2"></i> Tambah Data
        </button>
    </div>

    <?php if($this->session->flashdata('success')): ?>
        <div class="alert alert-success border-0 shadow-sm mb-4"><?= $this->session->flashdata('success') ?></div>
    <?php endif; ?>

    <div class="card border-0 shadow-sm">
        <div class="card-header bg-white py-3">
            <h6 class="m-0 fw-bold text-muted"><i class="fas fa-list me-2"></i> Daftar Data Kriteria</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead>
                        <tr>
                            <th width="5%">No</th>
                            <th width="15%">Kode Kriteria</th>
                            <th>Nama Kriteria</th>
                            <th width="10%">Bobot</th>
                            <th width="15%">Jenis</th>
                            <th width="15%" class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $no=1; foreach($kriteria as $k): ?>
                        <tr>
                            <td><?= $no++ ?></td>
                            <td><span class="badge bg-light text-dark fw-bold border"><?= $k->kode_kriteria ?></span></td>
                            <td><?= $k->nama_kriteria ?></td>
                            <td><?= $k->bobot ?></td>
                            <td>
                                <span class="badge <?= $k->jenis == 'Benefit' ? 'badge-benefit' : 'badge-cost' ?> p-2 px-3">
                                    <?= $k->jenis ?>
                                </span>
                            </td>
                            <td class="text-center">
                                <button class="btn btn-warning btn-sm text-white" data-bs-toggle="modal" data-bs-target="#modalEdit<?= $k->id_kriteria ?>">
                                    <i class="fas fa-edit"></i>
                                </button>
                                <a href="<?= base_url('Kriteria/hapus/'.$k->id_kriteria) ?>" class="btn btn-danger btn-sm" onclick="return confirm('Apakah anda yakin ingin menghapus data ini?')">
                                    <i class="fas fa-trash"></i>
                                </a>
                            </td>
                        </tr>

                        <!-- Modal Edit -->
                        <div class="modal fade" id="modalEdit<?= $k->id_kriteria ?>" tabindex="-1">
                            <div class="modal-dialog modal-dialog-centered">
                                <div class="modal-content">
                                    <div class="modal-header bg-primary text-white" style="background: var(--primary-blue) !important;">
                                        <h5 class="modal-title"><i class="fas fa-edit me-2"></i> Edit Data Kriteria</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                    </div>
                                    <form action="<?= base_url('Kriteria/edit/'.$k->id_kriteria) ?>" method="POST">
                                        <div class="modal-body">
                                            <div class="mb-3">
                                                <label class="form-label fw-bold">Kode Kriteria</label>
                                                <input type="text" name="kode_kriteria" class="form-control" value="<?= $k->kode_kriteria ?>" required>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label fw-bold">Nama Kriteria</label>
                                                <input type="text" name="nama_kriteria" class="form-control" value="<?= $k->nama_kriteria ?>" required>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label fw-bold">Bobot (%)</label>
                                                <input type="number" step="any" name="bobot" class="form-control" value="<?= $k->bobot ?>" required>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label fw-bold">Jenis</label>
                                                <select name="jenis" class="form-select" required>
                                                    <option value="Benefit" <?= $k->jenis == 'Benefit' ? 'selected' : '' ?>>Benefit</option>
                                                    <option value="Cost" <?= $k->jenis == 'Cost' ? 'selected' : '' ?>>Cost</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                            <button type="submit" class="btn btn-primary-red px-4">Update Data</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Modal Tambah -->
<div class="modal fade" id="modalTambah" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white" style="background: var(--primary-blue) !important;">
                <h5 class="modal-title"><i class="fas fa-plus me-2"></i> Tambah Data Kriteria</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="<?= base_url('Kriteria/tambah') ?>" method="POST">
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label fw-bold">Kode Kriteria</label>
                        <input type="text" name="kode_kriteria" class="form-control" placeholder="C01" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold">Nama Kriteria</label>
                        <input type="text" name="nama_kriteria" class="form-control" placeholder="Contoh: Masa Kerja" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold">Bobot (%)</label>
                        <input type="number" step="any" name="bobot" class="form-control" placeholder="Contoh: 25" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold">Jenis</label>
                        <select name="jenis" class="form-select" required>
                            <option value="Benefit">Benefit</option>
                            <option value="Cost">Cost</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary-red px-4">Simpan Data</button>
                </div>
            </form>
        </div>
    </div>
</div>
