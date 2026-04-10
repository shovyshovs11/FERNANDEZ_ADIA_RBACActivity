<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
<div class="row justify-content-center">
    <div class="col-md-7">
        <div class="card glass-card border-0 pb-2">
            <div class="card-body p-5">
                <div class="text-center mb-5">
                    <div class="bg-primary bg-opacity-10 text-primary rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width:60px;height:60px;">
                        <i class="bi bi-shield-plus fs-2"></i>
                    </div>
                    <h3 class="fw-bold">Create New Role</h3>
                    <p class="text-muted">Define a new permission group for the system</p>
                </div>
                
                <form action="<?= base_url('admin/roles/store') ?>" method="post">
                    <?= csrf_field() ?>
                    
                    <div class="form-floating mb-4">
                        <input type="text" id="name" name="name" class="form-control bg-light border-0 <?= isset($validation) && $validation->hasError('name') ? 'is-invalid' : '' ?>" value="<?= set_value('name') ?>" placeholder="Slug" required>
                        <label for="name">Role Name (Slug)</label>
                        <small class="form-text text-muted ms-2">Lowercase, no spaces (e.g. <code>editor</code>)</small>
                        <?php if(isset($validation) && $validation->hasError('name')): ?>
                            <div class="invalid-feedback"><?= $validation->getError('name') ?></div>
                        <?php endif; ?>
                    </div>

                    <div class="form-floating mb-4">
                        <input type="text" id="label" name="label" class="form-control bg-light border-0 <?= isset($validation) && $validation->hasError('label') ? 'is-invalid' : '' ?>" value="<?= set_value('label') ?>" placeholder="Label" required>
                        <label for="label">Display Label</label>
                        <?php if(isset($validation) && $validation->hasError('label')): ?>
                            <div class="invalid-feedback"><?= $validation->getError('label') ?></div>
                        <?php endif; ?>
                    </div>

                    <div class="form-floating mb-5">
                        <textarea id="description" name="description" class="form-control bg-light border-0" placeholder="Description" style="height: 100px"><?= set_value('description') ?></textarea>
                        <label for="description">Detailed Description</label>
                    </div>

                    <div class="d-flex justify-content-between align-items-center">
                        <a href="<?= base_url('admin/roles') ?>" class="btn btn-light rounded-pill px-4 text-secondary fw-semibold">Cancel</a>
                        <button type="submit" class="btn btn-brand btn-modern rounded-pill px-5">Save Role</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>
