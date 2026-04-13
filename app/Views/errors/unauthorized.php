<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
<div class="row justify-content-center mt-3">
    <div class="col-md-7 text-center">
        <div class="card glass-card border-0 p-5">
            <h1 class="display-1 text-danger fw-bolder mb-0"><i class="bi bi-exclamation-octagon-fill"></i></h1>
            <h1 class="display-4 text-danger fw-bold mt-2">403</h1>
            <h3 class="mb-4 fw-bold">Access Denied</h3>
            <p class="lead text-muted mb-5">
                You are currently logged in as a <strong><span class="badge bg-dark bg-opacity-10 text-dark border px-3 py-2 ms-1"><?= esc(session('role') ?? session('user')['role'] ?? 'Guest') ?></span></strong>.<br>
                You do not have the required permissions to view this directory or page.
            </p>
            
            <?php
                $role = session('role') ?? (session()->has('user') ? session('user')['role'] : '');
                $dashboardLink = '/login';
                if ($role === 'student') $dashboardLink = '/student/dashboard';
                if (in_array($role, ['teacher', 'admin'])) $dashboardLink = '/dashboard';
            ?>
            <div>
                <a href="<?= base_url($dashboardLink) ?>" class="btn btn-brand btn-modern rounded-pill px-5 py-2">
                    <i class="bi bi-arrow-left me-2"></i>Return to Safe Zone
                </a>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>
