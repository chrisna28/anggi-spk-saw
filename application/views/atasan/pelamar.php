<div class="container-fluid">
    <h5 class="fw-bold mb-4"><i class="fas fa-users me-2 text-primary"></i>Data Pelamar</h5>
    <div class="card shadow-sm border-0">
        <div class="card-body">
            <table class="table table-hover">
                <thead><tr><th>No</th><th>Nama</th><th>Email</th><th>No. Telp</th><th>Aksi</th></tr></thead>
                <tbody>
                    <?php if (empty($pelamar)): ?>
                    <tr><td colspan="5" class="text-center text-muted py-4">Belum ada data pelamar</td></tr>
                    <?php else: ?>
                    <?php $no=1; foreach ($pelamar as $p): ?>
                    <tr>
                        <td><?= $no++ ?></td>
                        <td class="fw-bold"><?= htmlspecialchars($p->nama_alternatif) ?></td>
                        <td><?= htmlspecialchars($p->email) ?: '-' ?></td>
                        <td><?= htmlspecialchars($p->no_telp) ?: '-' ?></td>
                        <td><a href="<?= base_url('Atasan/detail_pelamar/'.$p->id_alternatif) ?>" class="btn btn-sm btn-outline-primary"><i class="fas fa-eye me-1"></i>Detail</a></td>
                    </tr>
                    <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
