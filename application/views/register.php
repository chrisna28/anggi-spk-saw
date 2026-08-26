<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar - SPK SAW</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link href="<?= base_url('assets/css/style.css') ?>" rel="stylesheet">
    <style>
        body { background: linear-gradient(135deg, #0f172a 0%, #1e293b 100%); min-height: 100vh; display: flex; align-items: center; }
        .register-card { background: rgba(255,255,255,0.05); backdrop-filter: blur(20px); border-radius: 20px; padding: 40px; border: 1px solid rgba(255,255,255,0.1); }
        .register-card h2 { color: #fff; }
        .register-card .form-label { color: rgba(255,255,255,0.7); }
        .register-card .form-control { background: rgba(255,255,255,0.08); border: 1px solid rgba(255,255,255,0.15); color: #fff; }
        .register-card .form-control:focus { background: rgba(255,255,255,0.12); border-color: var(--accent-blue); color: #fff; }
        .register-card .form-control::placeholder { color: rgba(255,255,255,0.3); }
        .register-card .text-muted { color: rgba(255,255,255,0.5) !important; }
    </style>
</head>
<body>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-5">
                <div class="register-card shadow">
                    <div class="text-center mb-4">
                        <div class="mb-3">
                            <span style="background: linear-gradient(135deg, #60a5fa, #3b82f6); width: 60px; height: 60px; display: inline-flex; align-items: center; justify-content: center; border-radius: 15px;">
                                <i class="fas fa-layer-group fa-2x text-white"></i>
                            </span>
                        </div>
                        <h2 class="fw-bold">Daftar Akun</h2>
                        <p class="text-muted">Isi data Anda untuk mendaftar sebagai pelamar</p>
                    </div>

                    <?php if ($msg = $this->session->flashdata('error')): ?>
                    <div class="alert alert-danger py-2"><?= $msg ?></div>
                    <?php endif; ?>
                    <?php if ($msg = $this->session->flashdata('success')): ?>
                    <div class="alert alert-success py-2"><?= $msg ?></div>
                    <?php endif; ?>

                    <form method="post">
                        <div class="mb-3">
                            <label class="form-label small fw-bold">Nama Lengkap</label>
                            <input type="text" name="nama" class="form-control" placeholder="Masukkan nama lengkap" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label small fw-bold">Username</label>
                            <input type="text" name="username" class="form-control" placeholder="Buat username" required>
                        </div>
                        <div class="mb-4">
                            <label class="form-label small fw-bold">Password</label>
                            <input type="password" name="password" class="form-control" placeholder="Buat password" required>
                        </div>
                        <button type="submit" class="btn btn-primary w-100 py-2 fw-bold"><i class="fas fa-user-plus me-2"></i>Daftar</button>
                    </form>

                    <div class="text-center mt-4">
                        <p class="text-muted small">Sudah punya akun? <a href="<?= base_url('Auth') ?>" class="text-white fw-bold">Masuk</a></p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
