<div class="topbar shadow-sm">
    <div class="d-flex align-items-center">
        <button type="button" id="sidebarCollapse" class="btn btn-light bg-white border-0 shadow-sm me-3 d-lg-none">
            <i class="fas fa-bars"></i>
        </button>
        <h5 class="mb-0 fw-bold" style="color: var(--primary-blue);"><?= isset($title) ? $title : 'Dashboard' ?></h5>
    </div>
    <div class="dropdown">
        <button class="btn btn-transparent dropdown-toggle border-0 d-flex align-items-center p-0" type="button" data-bs-toggle="dropdown">
            <div class="text-end me-3 d-none d-md-block">
                <p class="mb-0 small fw-bold text-dark"><?= $this->session->userdata('nama') ?></p>
                <p class="mb-0 text-muted" style="font-size: 0.75rem;"><?= role_label($this->session->userdata('level')) ?></p>
            </div>
            <div class="bg-primary-red text-white rounded-circle d-flex align-items-center justify-content-center shadow-sm" style="width: 40px; height: 40px; background-color: var(--accent-blue) !important;">
                <i class="fas fa-user-circle fa-lg"></i>
            </div>
        </button>
        <ul class="dropdown-menu dropdown-menu-end border-0 shadow-lg mt-2 p-2" style="border-radius: 12px;">
            <li><a class="dropdown-item rounded-3 py-2" href="<?= base_url('Auth/logout') ?>"><i class="fas fa-sign-out-alt me-2 text-danger"></i> Logout</a></li>
        </ul>
    </div>
</div>
