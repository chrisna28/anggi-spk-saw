<div class="container-fluid">
    <?php if ($msg = $this->session->flashdata('success')): ?>
    <div class="alert alert-success alert-dismissible shadow-sm border-0"><?= $msg ?><button type="button" class="btn-close" data-bs-dismiss="alert"></button></div>
    <?php endif; ?>
    <?php if ($msg = $this->session->flashdata('error')): ?>
    <div class="alert alert-danger alert-dismissible shadow-sm border-0"><?= $msg ?><button type="button" class="btn-close" data-bs-dismiss="alert"></button></div>
    <?php endif; ?>

    <div class="d-flex justify-content-between align-items-center mb-4">
        <h5 class="fw-bold mb-0"><i class="fas fa-briefcase me-2 text-primary"></i>Pengalaman Kerja</h5>
        <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#modalTambah"><i class="fas fa-plus me-1"></i>Tambah</button>
    </div>

    <?php if (empty($pengalaman)): ?>
    <div class="text-center py-5 text-muted"><i class="fas fa-inbox fa-3x mb-3 d-block"></i>Belum ada pengalaman kerja</div>
    <?php else: ?>
    <div class="row g-3">
        <?php foreach ($pengalaman as $p): ?>
        <div class="col-12">
            <div class="card shadow-sm border-0">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div>
                            <h6 class="fw-bold mb-1"><?= htmlspecialchars($p->posisi) ?></h6>
                            <p class="mb-1 text-muted small"><?= htmlspecialchars($p->nama_perusahaan) ?></p>
                            <p class="mb-1 small"><?= $p->tahun_mulai ?> - <?= $p->tahun_selesai ?: 'Sekarang' ?></p>
                            <?php if ($p->deskripsi): ?>
                            <p class="mb-0 small text-muted"><?= nl2br(htmlspecialchars($p->deskripsi)) ?></p>
                            <?php endif; ?>
                        </div>
                        <div>
                            <button class="btn btn-sm btn-outline-primary" data-bs-toggle="modal" data-bs-target="#modalEdit<?= $p->id_pengalaman ?>"><i class="fas fa-edit"></i></button>
                            <a href="<?= base_url('Pelamar/hapus_pengalaman/'.$p->id_pengalaman) ?>" class="btn btn-sm btn-outline-danger" onclick="return confirm('Hapus?')"><i class="fas fa-trash"></i></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php endforeach; ?>
    </div>
    <?php endif; ?>
</div>

<!-- Modal Tambah -->
<div class="modal fade" id="modalTambah" tabindex="-1">
    <div class="modal-dialog">
        <form method="post" class="modal-content">
            <div class="modal-header"><h5 class="modal-title fw-bold">Tambah Pengalaman</h5><button type="button" class="btn-close" data-bs-dismiss="modal"></button></div>
            <div class="modal-body">
                <div class="mb-3"><label class="form-label small fw-bold">Nama Perusahaan</label><input type="text" name="nama_perusahaan" class="form-control" required></div>
                <div class="mb-3"><label class="form-label small fw-bold">Posisi</label><input type="text" name="posisi" class="form-control" required></div>
                <div class="row"><div class="col-md-6 mb-3"><label class="form-label small fw-bold">Tahun Mulai</label><input type="number" name="tahun_mulai" class="form-control" min="1950" max="2099" required></div>
                <div class="col-md-6 mb-3"><label class="form-label small fw-bold">Tahun Selesai</label><input type="number" name="tahun_selesai" class="form-control" min="1950" max="2099" placeholder="Kosongkan jika masih"><small class="text-muted d-block">Kosongkan jika masih berlangsung</small></div></div>
                <div class="mb-3"><label class="form-label small fw-bold">Deskripsi</label><textarea name="deskripsi" class="form-control" rows="3"></textarea></div>
            </div>
            <div class="modal-footer"><button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button><button type="submit" class="btn btn-primary">Simpan</button></div>
        </form>
    </div>
</div>

<!-- Modal Edit -->
<?php foreach ($pengalaman as $p): ?>
<div class="modal fade" id="modalEdit<?= $p->id_pengalaman ?>" tabindex="-1">
    <div class="modal-dialog">
        <form method="post" action="<?= base_url('Pelamar/edit_pengalaman/'.$p->id_pengalaman) ?>" class="modal-content">
            <div class="modal-header"><h5 class="modal-title fw-bold">Edit Pengalaman</h5><button type="button" class="btn-close" data-bs-dismiss="modal"></button></div>
            <div class="modal-body">
                <div class="mb-3"><label class="form-label small fw-bold">Nama Perusahaan</label><input type="text" name="nama_perusahaan" class="form-control" value="<?= htmlspecialchars($p->nama_perusahaan) ?>" required></div>
                <div class="mb-3"><label class="form-label small fw-bold">Posisi</label><input type="text" name="posisi" class="form-control" value="<?= htmlspecialchars($p->posisi) ?>" required></div>
                <div class="row"><div class="col-md-6 mb-3"><label class="form-label small fw-bold">Tahun Mulai</label><input type="number" name="tahun_mulai" class="form-control" value="<?= $p->tahun_mulai ?>" required></div>
                <div class="col-md-6 mb-3"><label class="form-label small fw-bold">Tahun Selesai</label><input type="number" name="tahun_selesai" class="form-control" value="<?= $p->tahun_selesai ?>"></div></div>
                <div class="mb-3"><label class="form-label small fw-bold">Deskripsi</label><textarea name="deskripsi" class="form-control" rows="3"><?= htmlspecialchars($p->deskripsi) ?></textarea></div>
            </div>
            <div class="modal-footer"><button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button><button type="submit" class="btn btn-primary">Simpan</button></div>
        </form>
    </div>
</div>
<?php endforeach; ?>
