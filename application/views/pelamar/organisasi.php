<div class="container-fluid">
    <?php if ($msg = $this->session->flashdata('success')): ?>
    <div class="alert alert-success alert-dismissible shadow-sm border-0"><?= $msg ?><button type="button" class="btn-close" data-bs-dismiss="alert"></button></div>
    <?php endif; ?>

    <div class="d-flex justify-content-between align-items-center mb-4">
        <h5 class="fw-bold mb-0"><i class="fas fa-users me-2 text-primary"></i>Riwayat Organisasi</h5>
        <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#modalTambah"><i class="fas fa-plus me-1"></i>Tambah</button>
    </div>

    <?php if (empty($organisasi)): ?>
    <div class="text-center py-5 text-muted"><i class="fas fa-inbox fa-3x mb-3 d-block"></i>Belum ada riwayat organisasi</div>
    <?php else: ?>
    <div class="row g-3">
        <?php foreach ($organisasi as $o): ?>
        <div class="col-12">
            <div class="card shadow-sm border-0">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div>
                            <h6 class="fw-bold mb-1"><?= htmlspecialchars($o->nama_organisasi) ?></h6>
                            <p class="mb-1 text-muted small"><?= htmlspecialchars($o->jabatan) ?></p>
                            <p class="mb-0 small"><?= $o->tahun_mulai ?> - <?= $o->tahun_selesai ?: 'Sekarang' ?></p>
                        </div>
                        <div>
                            <button class="btn btn-sm btn-outline-primary" data-bs-toggle="modal" data-bs-target="#modalEdit<?= $o->id_organisasi ?>"><i class="fas fa-edit"></i></button>
                            <a href="<?= base_url('Pelamar/hapus_organisasi/'.$o->id_organisasi) ?>" class="btn btn-sm btn-outline-danger" onclick="return confirm('Hapus?')"><i class="fas fa-trash"></i></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php endforeach; ?>
    </div>
    <?php endif; ?>
</div>

<div class="modal fade" id="modalTambah" tabindex="-1">
    <div class="modal-dialog">
        <form method="post" class="modal-content">
            <div class="modal-header"><h5 class="modal-title fw-bold">Tambah Organisasi</h5><button type="button" class="btn-close" data-bs-dismiss="modal"></button></div>
            <div class="modal-body">
                <div class="mb-3"><label class="form-label small fw-bold">Nama Organisasi</label><input type="text" name="nama_organisasi" class="form-control" required></div>
                <div class="mb-3"><label class="form-label small fw-bold">Jabatan</label><input type="text" name="jabatan" class="form-control"></div>
                <div class="row"><div class="col-md-6 mb-3"><label class="form-label small fw-bold">Tahun Mulai</label><input type="number" name="tahun_mulai" class="form-control" min="1950" max="2099" required></div>
                <div class="col-md-6 mb-3"><label class="form-label small fw-bold">Tahun Selesai</label><input type="number" name="tahun_selesai" class="form-control" min="1950" max="2099"></div></div>
            </div>
            <div class="modal-footer"><button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button><button type="submit" class="btn btn-primary">Simpan</button></div>
        </form>
    </div>
</div>

<?php foreach ($organisasi as $o): ?>
<div class="modal fade" id="modalEdit<?= $o->id_organisasi ?>" tabindex="-1">
    <div class="modal-dialog">
        <form method="post" action="<?= base_url('Pelamar/edit_organisasi/'.$o->id_organisasi) ?>" class="modal-content">
            <div class="modal-header"><h5 class="modal-title fw-bold">Edit Organisasi</h5><button type="button" class="btn-close" data-bs-dismiss="modal"></button></div>
            <div class="modal-body">
                <div class="mb-3"><label class="form-label small fw-bold">Nama Organisasi</label><input type="text" name="nama_organisasi" class="form-control" value="<?= htmlspecialchars($o->nama_organisasi) ?>" required></div>
                <div class="mb-3"><label class="form-label small fw-bold">Jabatan</label><input type="text" name="jabatan" class="form-control" value="<?= htmlspecialchars($o->jabatan) ?>"></div>
                <div class="row"><div class="col-md-6 mb-3"><label class="form-label small fw-bold">Tahun Mulai</label><input type="number" name="tahun_mulai" class="form-control" value="<?= $o->tahun_mulai ?>" required></div>
                <div class="col-md-6 mb-3"><label class="form-label small fw-bold">Tahun Selesai</label><input type="number" name="tahun_selesai" class="form-control" value="<?= $o->tahun_selesai ?>"></div></div>
            </div>
            <div class="modal-footer"><button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button><button type="submit" class="btn btn-primary">Simpan</button></div>
        </form>
    </div>
</div>
<?php endforeach; ?>
