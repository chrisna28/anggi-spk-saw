<div class="container-fluid">
    <div class="d-flex align-items-center justify-content-between mb-4">
        <h4 class="mb-0 fw-bold border-start border-4 border-primary-red ps-3"><i class="fas fa-cubes me-2"></i> Data Sub Kriteria</h4>
    </div>

    <?php if($this->session->flashdata('success')): ?>
        <div class="alert alert-success border-0 shadow-sm mb-4"><?= $this->session->flashdata('success') ?></div>
    <?php endif; ?>

    <?php foreach($kriteria as $k): ?>
    <div class="card border-0 shadow-sm mb-4">
        <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
            <h6 class="m-0 fw-bold text-muted"><i class="fas fa-list me-2"></i> <?= $k->nama_kriteria ?> (<?= $k->kode_kriteria ?>)</h6>
            <button class="btn btn-success btn-sm shadow-sm px-3" data-bs-toggle="modal" data-bs-target="#modalTambah<?= $k->id_kriteria ?>">
                <i class="fas fa-plus me-2"></i> Tambah Data
            </button>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead>
                        <tr>
                            <th width="10%">No</th>
                            <th>Nama Sub Kriteria</th>
                            <th width="20%">Nilai</th>
                            <th width="15%" class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                        $no = 1;
                        if(empty($sub[$k->id_kriteria])): ?>
                            <tr>
                                <td colspan="4" class="text-center text-muted py-4">Belum ada data sub kriteria</td>
                            </tr>
                        <?php else: 
                            foreach($sub[$k->id_kriteria] as $s): ?>
                            <tr>
                                <td><?= $no++ ?></td>
                                <td><?= $s->nama_sub ?></td>
                                <td><span class="badge bg-light text-dark fw-bold border"><?= $s->nilai ?></span></td>
                                <td class="text-center">
                                    <button class="btn btn-warning btn-sm text-white" data-bs-toggle="modal" data-bs-target="#modalEdit<?= $s->id_sub ?>">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    <a href="<?= base_url('Sub_Kriteria/hapus/'.$s->id_sub) ?>" class="btn btn-danger btn-sm" onclick="return confirm('Apakah anda yakin ingin menghapus data ini?')">
                                        <i class="fas fa-trash"></i>
                                    </a>
                                </td>
                            </tr>

                            <!-- Modal Edit Sub -->
                            <div class="modal fade" id="modalEdit<?= $s->id_sub ?>" tabindex="-1">
                                <div class="modal-dialog modal-dialog-centered">
                                    <div class="modal-content">
                                        <div class="modal-header bg-warning text-white">
                                            <h5 class="modal-title"><i class="fas fa-edit me-2"></i> Edit Sub Kriteria</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                        </div>
                                        <form action="<?= base_url('Sub_Kriteria/edit/'.$s->id_sub) ?>" method="POST">
                                            <div class="modal-body">
                                                <div class="mb-3">
                                                    <label class="form-label fw-bold">Nama Sub Kriteria</label>
                                                    <input type="text" name="nama_sub" class="form-control" value="<?= $s->nama_sub ?>" required>
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label fw-bold">Nilai</label>
                                                    <input type="number" step="any" name="nilai" class="form-control" value="<?= $s->nilai ?>" required>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                                <button type="submit" class="btn btn-warning text-white px-4">Update Data</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            <?php endforeach; 
                        endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Modal Tambah Sub -->
    <div class="modal fade" id="modalTambah<?= $k->id_kriteria ?>" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header bg-success text-white">
                    <h5 class="modal-title"><i class="fas fa-plus me-2"></i> Tambah Sub Kriteria - <?= $k->nama_kriteria ?></h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <form action="<?= base_url('Sub_Kriteria/tambah/'.$k->id_kriteria) ?>" method="POST">
                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label fw-bold">Nama Sub Kriteria</label>
                            <input type="text" name="nama_sub" class="form-control" placeholder="Contoh: Sangat Baik" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-bold">Nilai</label>
                            <input type="number" step="any" name="nilai" class="form-control" placeholder="Contoh: 100" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-success px-4">Simpan Data</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <?php endforeach; ?>
</div>
