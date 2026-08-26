<div class="container-fluid">
    <div class="d-flex align-items-center justify-content-between mb-4">
        <h4 class="mb-0 fw-bold border-start border-4 ps-3" style="border-color: var(--accent-blue) !important;"><i class="fas fa-edit me-2"></i> Data Penilaian</h4>
    </div>

    <?php if($this->session->flashdata('success')): ?>
        <div class="alert alert-success border-0 shadow-sm mb-4"><?= $this->session->flashdata('success') ?></div>
    <?php endif; ?>

    <div class="card border-0 shadow-sm">
        <div class="card-header bg-white py-3">
            <h6 class="m-0 fw-bold text-muted"><i class="fas fa-list me-2"></i> Daftar Penilaian Alternatif</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead>
                        <tr>
                            <th width="5%">No</th>
                            <th>Nama Alternatif</th>
                            <?php foreach($kriteria as $k): ?>
                                <th class="text-center"><?= $k->kode_kriteria ?></th>
                            <?php endforeach; ?>
                            <th width="10%" class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $no=1; foreach($alternatif as $a): ?>
                        <tr>
                            <td><?= $no++ ?></td>
                            <td class="fw-bold text-muted"><?= $a->nama_alternatif ?></td>
                            <?php foreach($kriteria as $k): ?>
                                <td class="text-center">
                                    <?php if(isset($penilaian[$a->id_alternatif][$k->id_kriteria])): ?>
                                        <span class="badge bg-light text-primary border border-primary-subtle px-3 py-2">
                                            <?php 
                                                // Find the sub criteria name
                                                foreach($sub[$k->id_kriteria] as $s) {
                                                    if($s->id_sub == $penilaian[$a->id_alternatif][$k->id_kriteria]->id_sub) {
                                                        echo $s->nilai;
                                                        break;
                                                    }
                                                }
                                            ?>
                                        </span>
                                    <?php else: ?>
                                        <span class="text-muted small"><em>Belum diisi</em></span>
                                    <?php endif; ?>
                                </td>
                            <?php endforeach; ?>
                            <td class="text-center">
                                <button class="btn btn-primary-red btn-sm" data-bs-toggle="modal" data-bs-target="#modalNilai<?= $a->id_alternatif ?>">
                                    <i class="fas fa-edit me-1"></i> Input
                                </button>
                            </td>
                        </tr>

                        <!-- Modal Input Nilai -->
                        <div class="modal fade" id="modalNilai<?= $a->id_alternatif ?>" tabindex="-1">
                            <div class="modal-dialog modal-dialog-centered">
                                <div class="modal-content">
                                    <div class="modal-header text-white" style="background: var(--primary-blue) !important;">
                                        <h5 class="modal-title"><i class="fas fa-edit me-2"></i> Input Penilaian: <?= $a->nama_alternatif ?></h5>
                                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                                    </div>
                                    <form action="<?= base_url('Penilaian/simpan') ?>" method="POST">
                                        <input type="hidden" name="id_alternatif" value="<?= $a->id_alternatif ?>">
                                        <div class="modal-body">
                                            <?php foreach($kriteria as $k): ?>
                                                <div class="mb-3">
                                                    <label class="form-label fw-bold"><?= $k->nama_kriteria ?> (<?= $k->kode_kriteria ?>)</label>
                                                    <select name="kriteria_<?= $k->id_kriteria ?>" class="form-select" required>
                                                        <option value="">-- Pilih Nilai --</option>
                                                        <?php foreach($sub[$k->id_kriteria] as $s): ?>
                                                            <option value="<?= $s->id_sub ?>" <?= (isset($penilaian[$a->id_alternatif][$k->id_kriteria]) && $penilaian[$a->id_alternatif][$k->id_kriteria]->id_sub == $s->id_sub) ? 'selected' : '' ?>>
                                                                <?= $s->nama_sub ?> (Nilai: <?= $s->nilai ?>)
                                                            </option>
                                                        <?php endforeach; ?>
                                                    </select>
                                                </div>
                                            <?php endforeach; ?>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                            <button type="submit" class="btn btn-primary-red px-4">Simpan Penilaian</button>
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
