<div class="container-fluid">
    <div class="d-flex align-items-center justify-content-between mb-4">
        <h4 class="mb-0 fw-bold border-start border-4 ps-3" style="border-color: var(--accent-blue) !important;"><i class="fas fa-users me-2"></i> Data Alternatif</h4>
        <button class="btn btn-success shadow-sm btn-sm px-3" data-bs-toggle="modal" data-bs-target="#modalTambah">
            <i class="fas fa-plus me-2"></i> Tambah Data
        </button>
    </div>

    <?php if($this->session->flashdata('success')): ?>
        <div class="alert alert-success border-0 shadow-sm mb-4"><?= $this->session->flashdata('success') ?></div>
    <?php endif; ?>

    <div class="card border-0 shadow-sm">
        <div class="card-header bg-white py-3">
            <h6 class="m-0 fw-bold text-muted"><i class="fas fa-list me-2"></i> Daftar Data Alternatif</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead>
                        <tr>
                            <th width="5%">No</th>
                            <th>Nama Alternatif</th>
                            <th>Email</th>
                            <th>No. Telp</th>
                            <th width="18%" class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $no=1; foreach($alternatif as $a): ?>
                        <tr>
                            <td><?= $no++ ?></td>
                            <td><?= $a->nama_alternatif ?></td>
                            <td><?= $a->email ?: '-' ?></td>
                            <td><?= $a->no_telp ?: '-' ?></td>
                            <td class="text-center">
                                <a href="<?= base_url('Alternatif/detail/'.$a->id_alternatif) ?>" class="btn btn-info btn-sm text-white">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <button class="btn btn-warning btn-sm text-white" data-bs-toggle="modal" data-bs-target="#modalEdit<?= $a->id_alternatif ?>">
                                    <i class="fas fa-edit"></i>
                                </button>
                                <a href="<?= base_url('Alternatif/hapus/'.$a->id_alternatif) ?>" class="btn btn-danger btn-sm" onclick="return confirm('Apakah anda yakin ingin menghapus data ini?')">
                                    <i class="fas fa-trash"></i>
                                </a>
                            </td>
                        </tr>

                        <!-- Modal Edit -->
                        <div class="modal fade" id="modalEdit<?= $a->id_alternatif ?>" tabindex="-1">
                            <div class="modal-dialog modal-dialog-centered">
                                <div class="modal-content">
                                    <div class="modal-header bg-primary text-white" style="background: var(--primary-blue) !important;">
                                        <h5 class="modal-title"><i class="fas fa-edit me-2"></i> Edit Data Alternatif</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                    </div>
                                    <form action="<?= base_url('Alternatif/edit/'.$a->id_alternatif) ?>" method="POST">
                                        <div class="modal-body">
                                            <div class="mb-3">
                                                <label class="form-label fw-bold">Nama Alternatif</label>
                                                <input type="text" name="nama_alternatif" class="form-control" value="<?= $a->nama_alternatif ?>" required>
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
                <h5 class="modal-title"><i class="fas fa-plus me-2"></i> Tambah Data Alternatif</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="<?= base_url('Alternatif/tambah') ?>" method="POST">
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label fw-bold">Nama Alternatif</label>
                        <input type="text" name="nama_alternatif" class="form-control" placeholder="Contoh: Ferdi" required>
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
