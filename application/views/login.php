<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login | SPK SAW</title>
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Custom CSS -->
    <link rel="stylesheet" href="<?= base_url('assets/css/style.css') ?>">
    <style>
        .login-bg-theme {
            background-color: #2c3e50;
            min-height: 100vh;
            display: flex;
            align-items: center;
            font-family: 'Plus Jakarta Sans', sans-serif;
        }

        .login-glass-card {
            background: #ffffff;
            border-radius: 12px;
            padding: 3rem 2.5rem;
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.15);
        }

        .login-form-group {
            margin-bottom: 1.25rem;
        }

        .login-form-group .input-group-text {
            background: #f4f6f9;
            border: none;
            border-radius: 8px 0 0 8px;
            color: #6c757d;
            padding-left: 1.25rem;
        }

        .login-form-group .form-control {
            background: #f4f6f9;
            border: none;
            border-radius: 0 8px 8px 0;
            padding: 0.8rem 1rem 0.8rem 0.5rem;
            color: #495057;
            box-shadow: none;
            font-size: 0.95rem;
        }

        .login-form-group .form-control::placeholder {
            color: #adb5bd !important;
        }

        .login-form-group .form-control:focus {
            background: #eef1f6;
            box-shadow: none;
        }
        
        .login-form-group .input-group:focus-within .input-group-text {
            background: #eef1f6;
        }

        .login-btn-theme {
            background-color: #2c3e50;
            border: none;
            color: white;
            padding: 0.85rem;
            border-radius: 8px;
            font-weight: 700;
            transition: all 0.3s ease;
            width: 100%;
            margin-top: 0.5rem;
        }

        .login-btn-theme:hover {
            background-color: #1a252f;
            color: white;
        }

        .login-title-left {
            font-size: 2.5rem;
            font-weight: 800;
            line-height: 1.25;
            margin-bottom: 1.5rem;
            color: #ffffff;
        }

        .login-desc-left {
            font-size: 1.05rem;
            line-height: 1.7;
            color: #ffffff;
            margin-bottom: 1.5rem;
            opacity: 0.95;
        }
    </style>
</head>
<body class="login-bg-theme">
    <div class="container py-5">
        <div class="row align-items-center justify-content-center">
            <div class="col-lg-6 pe-lg-5 mb-5 mb-lg-0">
                <h1 class="login-title-left">Sistem Pendukung Keputusan Metode SAW</h1>
                <p class="login-desc-left">
                    Sistem Pendukung Keputusan (SPK) merupakan suatu sistem informasi spesifik yang ditujukan untuk membantu manajemen dalam mengambil keputusan yang berkaitan dengan persoalan yang bersifat semi terstruktur.
                </p>
                <p class="login-desc-left mb-0">
                    Simple Additive Weighting (SAW) adalah salah satu Metode Fuzzy Multiple Attribute Decision Making (FMADM) yang mampu menyelesaikan masalah multiple attribute decision making dengan cara membobotkan semua kriteria dan alternatif yang menghasilkan nilai referensi yang tepat.
                </p>
            </div>
            <div class="col-lg-5 offset-lg-1 col-md-8">
                <div class="login-glass-card">
                    <h3 class="text-center fw-bold mb-4" style="color: #212529;">Login Account</h3>
                    
                    <?php if($this->session->flashdata('success')): ?>
                        <div class="alert alert-success py-2 small border-0 mb-4"><?= $this->session->flashdata('success') ?></div>
                    <?php endif; ?>
                    <?php if($this->session->flashdata('error')): ?>
                        <div class="alert alert-danger py-2 small border-0 mb-4"><?= $this->session->flashdata('error') ?></div>
                    <?php endif; ?>

                    <form action="<?= base_url('Auth/login') ?>" method="POST">
                        <div class="login-form-group">
                            <div class="input-group">
                                <span class="input-group-text"><i class="fas fa-user"></i></span>
                                <input type="text" name="username" class="form-control" placeholder="Username" required autofocus>
                            </div>
                        </div>
                        <div class="login-form-group">
                            <div class="input-group">
                                <span class="input-group-text"><i class="fas fa-lock"></i></span>
                                <input type="password" name="password" class="form-control" placeholder="Password" required>
                            </div>
                        </div>
                        <button type="submit" class="login-btn-theme">
                            <i class="fas fa-sign-in-alt me-2"></i> Masuk
                        </button>
                        <div class="text-center mt-3">
                            <small class="text-muted">Belum punya akun? <a href="<?= base_url('Auth/register') ?>" class="fw-bold" style="color: var(--accent-blue);">Daftar</a></small>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
