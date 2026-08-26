<div class="container-fluid">
    <?php if ($msg = $this->session->flashdata('success')): ?>
    <div class="alert alert-success alert-dismissible shadow-sm border-0"><?= $msg ?><button type="button" class="btn-close" data-bs-dismiss="alert"></button></div>
    <?php endif; ?>

    <div class="d-flex justify-content-between align-items-center mb-4">
        <h5 class="fw-bold mb-0"><i class="fas fa-graduation-cap me-2 text-primary"></i>Riwayat Pendidikan</h5>
        <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#modalTambah"><i class="fas fa-plus me-1"></i>Tambah</button>
    </div>

    <?php if (empty($pendidikan)): ?>
    <div class="text-center py-5 text-muted"><i class="fas fa-inbox fa-3x mb-3 d-block"></i>Belum ada riwayat pendidikan</div>
    <?php else: ?>
    <div class="row g-3">
        <?php foreach ($pendidikan as $p): ?>
        <div class="col-12">
            <div class="card shadow-sm border-0">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div>
                            <span class="badge bg-primary mb-2"><?= $p->jenjang ?></span>
                            <h6 class="fw-bold mb-1"><?= htmlspecialchars($p->jurusan ?: $p->nama_sekolah) ?></h6>
                            <?php if ($p->jurusan): ?><p class="mb-0 text-muted small"><?= htmlspecialchars($p->nama_sekolah) ?></p><?php endif; ?>
                            <p class="mb-0 small"><?= $p->tahun_masuk ?> - <?= $p->tahun_lulus ?: 'Sekarang' ?><?= $p->ipk ? ' | IPK: '.$p->ipk : '' ?></p>
                        </div>
                        <div>
                            <button class="btn btn-sm btn-outline-primary" data-bs-toggle="modal" data-bs-target="#modalEdit<?= $p->id_pendidikan ?>"><i class="fas fa-edit"></i></button>
                            <a href="<?= base_url('Pelamar/hapus_pendidikan/'.$p->id_pendidikan) ?>" class="btn btn-sm btn-outline-danger" onclick="return confirm('Hapus?')"><i class="fas fa-trash"></i></a>
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
            <div class="modal-header"><h5 class="modal-title fw-bold">Tambah Pendidikan</h5><button type="button" class="btn-close" data-bs-dismiss="modal"></button></div>
            <div class="modal-body">
                <div class="mb-3"><label class="form-label small fw-bold">Jenjang</label>
                    <select name="jenjang" class="form-select" required>
                        <option value="">Pilih Jenjang</option>
                        <option value="SD">SD</option><option value="SMP">SMP</option><option value="SMA">SMA/SMK</option>
                        <option value="D3">D3</option><option value="S1">S1</option><option value="S2">S2</option><option value="S3">S3</option>
                    </select>
                </div>
                <div class="mb-3"><label class="form-label small fw-bold">Nama Sekolah/Universitas</label><input type="text" name="nama_sekolah" class="form-control" required></div>
                <div class="mb-3"><label class="form-label small fw-bold">Jurusan</label><input type="text" name="jurusan" class="form-control"></div>
                <div class="row"><div class="col-md-6 mb-3"><label class="form-label small fw-bold">Tahun Masuk</label><input type="number" name="tahun_masuk" class="form-control" min="1950" max="2099" required></div>
                <div class="col-md-6 mb-3"><label class="form-label small fw-bold">Tahun Lulus</label><input type="number" name="tahun_lulus" class="form-control" min="1950" max="2099"></div></div>
                <div class="mb-3"><label class="form-label small fw-bold">IPK</label><input type="text" name="ipk" class="form-control" placeholder="Contoh: 3.75"></div>
            </div>
            <div class="modal-footer"><button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button><button type="submit" class="btn btn-primary">Simpan</button></div>
        </form>
    </div>
</div>

<?php foreach ($pendidikan as $p): ?>
<div class="modal fade" id="modalEdit<?= $p->id_pendidikan ?>" tabindex="-1">
    <div class="modal-dialog">
        <form method="post" action="<?= base_url('Pelamar/edit_pendidikan/'.$p->id_pendidikan) ?>" class="modal-content">
            <div class="modal-header"><h5 class="modal-title fw-bold">Edit Pendidikan</h5><button type="button" class="btn-close" data-bs-dismiss="modal"></button></div>
            <div class="modal-body">
                <div class="mb-3"><label class="form-label small fw-bold">Jenjang</label>
                    <select name="jenjang" class="form-select" required>
                        <option value="SD" <?= $p->jenjang=='SD'?'selected':'' ?>>SD</option>
                        <option value="SMP" <?= $p->jenjang=='SMP'?'selected':'' ?>>SMP</option>
                        <option value="SMA" <?= $p->jenjang=='SMA'?'selected':'' ?>>SMA/SMK</option>
                        <option value="D3" <?= $p->jenjang=='D3'?'selected':'' ?>>D3</option>
                        <option value="S1" <?= $p->jenjang=='S1'?'selected':'' ?>>S1</option>
                        <option value="S2" <?= $p->jenjang=='S2'?'selected':'' ?>>S2</option>
                        <option value="S3" <?= $p->jenjang=='S3'?'selected':'' ?>>S3</option>
                    </select>
                </div>
                <div class="mb-3"><label class="form-label small fw-bold">Nama Sekolah/Universitas</label><input type="text" name="nama_sekolah" class="form-control" value="<?= htmlspecialchars($p->nama_sekolah) ?>" required></div>
                <div class="mb-3"><label class="form-label small fw-bold">Jurusan</label><input type="text" name="jurusan" class="form-control" value="<?= htmlspecialchars($p->jurusan) ?>"></div>
                <div class="row"><div class="col-md-6 mb-3"><label class="form-label small fw-bold">Tahun Masuk</label><input type="number" name="tahun_masuk" class="form-control" value="<?= $p->tahun_masuk ?>" required></div>
                <div class="col-md-6 mb-3"><label class="form-label small fw-bold">Tahun Lulus</label><input type="number" name="tahun_lulus" class="form-control" value="<?= $p->tahun_lulus ?>"></div></div>
                <div class="mb-3"><label class="form-label small fw-bold">IPK</label><input type="text" name="ipk" class="form-control" value="<?= $p->ipk ?>"></div>
            </div>
            <div class="modal-footer"><button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button><button type="submit" class="btn btn-primary">Simpan</button></div>
        </form>
    </div>
</div>
<?php endforeach; ?>
