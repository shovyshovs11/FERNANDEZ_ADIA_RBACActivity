<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
<div class="row justify-content-center">
    <div class="col-md-6">
        <div class="card glass-card border-0 p-4 text-center">
            <div class="bg-primary bg-opacity-10 text-primary rounded-circle d-inline-flex align-items-center justify-content-center mx-auto mb-3" style="width:80px;height:80px;">
                <i class="bi bi-person-badge fs-1"></i>
            </div>
            <h3 class="fw-bold"><?= esc($student['name']) ?></h3>
            <p class="text-muted fs-5 mb-4"><?= esc($student['email']) ?></p>
            
            <div class="d-flex justify-content-center">
                <a href="<?= base_url('students') ?>" class="btn btn-light rounded-pill px-4 shadow-sm"><i class="bi bi-arrow-left me-2"></i>Back to Index</a>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>
