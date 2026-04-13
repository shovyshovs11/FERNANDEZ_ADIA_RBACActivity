<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
<div class="row justify-content-center">
    <div class="col-md-7">
        <div class="card glass-card border-0 pb-2">
            <div class="card-body p-5">
                <div class="text-center mb-5">
                    <div class="bg-primary bg-opacity-10 text-primary rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width:60px;height:60px;">
                        <i class="bi bi-pencil-square fs-2"></i>
                    </div>
                    <h3 class="fw-bold">Update Role Details</h3>
                    <p class="text-muted">Change settings for <span class="badge bg-light text-dark shadow-sm border"><?= esc($role['name']) ?></span></p>
                </div>
                
                <form action="<?= base_url("admin/roles/update/{$role['id']}") ?>" method="post">
                    <?= csrf_field() ?>
                    <?php $isCoreRole = in_array($role['name'], ['admin', 'teacher', 'student']); ?>
                    
                    <div class="form-floating mb-4">
                        <input type="text" id="name" name="name" class="form-control bg-light border-0 <?= isset($validation) && $validation->hasError('name') ? 'is-invalid' : '' ?>" value="<?= set_value('name', $role['name']) ?>" placeholder="Slug" <?= $isCoreRole ? 'readonly' : 'required' ?>>
                        <label for="name">Role Name (Slug)</label>
                        <?php if($isCoreRole): ?>
                            <small class="form-text text-danger ms-2"><i class="bi bi-lock-fill"></i> Core roles cannot change their slug name.</small>
                        <?php endif; ?>
                        <?php if(isset($validation) && $validation->hasError('name')): ?>
                            <div class="invalid-feedback"><?= $validation->getError('name') ?></div>
                        <?php endif; ?>
                    </div>

                    <div class="form-floating mb-4">
                        <input type="text" id="label" name="label" class="form-control bg-light border-0 <?= isset($validation) && $validation->hasError('label') ? 'is-invalid' : '' ?>" value="<?= set_value('label', $role['label']) ?>" placeholder="Label" required>
                        <label for="label">Display Label</label>
                        <?php if(isset($validation) && $validation->hasError('label')): ?>
                            <div class="invalid-feedback"><?= $validation->getError('label') ?></div>
                        <?php endif; ?>
                    </div>

                    <div class="form-floating mb-5">
                        <textarea id="description" name="description" class="form-control bg-light border-0" placeholder="Description" style="height: 100px"><?= set_value('description', $role['description']) ?></textarea>
                        <label for="description">Detailed Description</label>
                    </div>

                    <div class="d-flex justify-content-between align-items-center">
                        <a href="<?= base_url('admin/roles') ?>" class="btn btn-light rounded-pill px-4 text-secondary fw-semibold">Cancel</a>
                        <button type="submit" class="btn btn-brand btn-modern rounded-pill px-5">Save Updates</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>
