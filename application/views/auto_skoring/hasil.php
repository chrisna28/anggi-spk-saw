<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h5 class="fw-bold mb-0"><i class="fas fa-check-circle me-2 text-success"></i>Hasil Auto Skoring</h5>
        <a href="<?= base_url('AutoSkoring') ?>" class="btn btn-outline-primary btn-sm"><i class="fas fa-arrow-left me-1"></i>Kembali</a>
    </div>

    <div class="row g-3 mb-4">
        <div class="col-md-6">
            <div class="card shadow-sm border-0 bg-success text-white">
                <div class="card-body text-center py-4">
                    <h2 class="fw-bold mb-0"><?= $total_tersimpan ?></h2>
                    <small>Penilaian Tersimpan</small>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card shadow-sm border-0 bg-primary text-white">
                <div class="card-body text-center py-4">
                    <h2 class="fw-bold mb-0"><?= $total_pelamar ?></h2>
                    <small>Pelamar Diproses</small>
                </div>
            </div>
        </div>
    </div>

    <div class="card shadow-sm border-0">
        <div class="card-header bg-white border-0"><h6 class="fw-bold mb-0">Log Proses</h6></div>
        <div class="card-body">
            <table class="table table-hover">
                <thead><tr><th>No</th><th>Pelamar</th><th>Kriteria Terpenuhi</th><th>Total</th></tr></thead>
                <tbody>
                    <?php foreach ($log as $i => $l): ?>
                    <tr>
                        <td><?= $i+1 ?></td>
                        <td class="fw-bold"><?= htmlspecialchars($l['nama']) ?></td>
                        <td><?= htmlspecialchars($l['kriteria']) ?></td>
                        <td><span class="badge bg-<?= $l['total'] > 0 ? 'success' : 'secondary' ?>"><?= $l['total'] ?></span></td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
