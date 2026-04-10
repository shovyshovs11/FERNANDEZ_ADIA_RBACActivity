<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-md-8">

            <?php if (session()->getFlashdata('success')): ?>
                <div class="alert alert-success alert-dismissible fade show">
                    <?= session()->getFlashdata('success') ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            <?php endif; ?>

            <div class="card shadow">
                <div class="card-header bg-primary text-white d-flex justify-content-between">
                    <h4 class="mb-0">Student Profile</h4>
                    <a href="<?= base_url('profile/edit') ?>" class="btn btn-light btn-sm">Edit Profile</a>
                </div>

                <div class="card-body">
                    <div class="row">
                        <!-- Profile Image -->
                        <div class="col-md-4 text-center mb-4">
                            <?php if (!empty($user['profile_image']) && is_string($user['profile_image'])): ?>
                                <img src="<?= base_url('uploads/profiles/' . esc($user['profile_image'])) ?>"
                                     alt="Profile"
                                     class="rounded-circle img-thumbnail shadow-sm"
                                     style="width: 150px; height: 150px; object-fit: cover;">
                            <?php else: ?>
                                <div class="rounded-circle bg-secondary d-flex align-items-center justify-content-center mx-auto shadow-sm"
                                     style="width: 150px; height: 150px;">
                                    <span class="text-white display-4">
                                        <?= strtoupper(substr((string)$user['name'], 0, 1)) ?>
                                    </span>
                                </div>
                                <small class="text-muted d-block mt-2">No photo</small>
                            <?php endif; ?>

                            <h5 class="mt-3 mb-0"><?= esc((string)$user['name']) ?></h5>
                            <small class="text-muted"><?= esc((string)$user['email']) ?></small>
                        </div>

                        <!-- Details -->
                        <div class="col-md-8">
                            <h5 class="border-bottom pb-2 mb-3">Academic Info</h5>
                            <dl class="row">
                                <dt class="col-sm-4">Student ID:</dt>
                                <dd class="col-sm-8">
                                    <?= !empty($user['student_id']) ? esc((string)$user['student_id']) : '<span class="text-muted">Not set</span>' ?>
                                </dd>

                                <dt class="col-sm-4">Course:</dt>
                                <dd class="col-sm-8">
                                    <?= !empty($user['course']) ? esc((string)$user['course']) : '<span class="text-muted">Not set</span>' ?>
                                </dd>

                                <dt class="col-sm-4">Year Level:</dt>
                                <dd class="col-sm-8">
                                    <?= !empty($user['year_level']) ? esc((string)$user['year_level']) : '<span class="text-muted">Not set</span>' ?>
                                </dd>

                                <dt class="col-sm-4">Section:</dt>
                                <dd class="col-sm-8">
                                    <?= !empty($user['section']) ? esc((string)$user['section']) : '<span class="text-muted">Not set</span>' ?>
                                </dd>
                            </dl>

                            <h5 class="border-bottom pb-2 mb-3 mt-4">Contact Info</h5>
                            <dl class="row">
                                <dt class="col-sm-4">Phone:</dt>
                                <dd class="col-sm-8">
                                    <?= !empty($user['phone']) ? esc((string)$user['phone']) : '<span class="text-muted">Not set</span>' ?>
                                </dd>

                                <dt class="col-sm-4">Address:</dt>
                                <dd class="col-sm-8">
                                    <?php if (!empty($user['address'])): ?>
                                        <?= nl2br(esc((string)$user['address'])) ?>
                                    <?php else: ?>
                                        <span class="text-muted">Not set</span>
                                    <?php endif; ?>
                                </dd>
                            </dl>

                            <h5 class="border-bottom pb-2 mb-3 mt-4">Account</h5>
                            <dl class="row">
                                <dt class="col-sm-4">Member Since:</dt>
                                <dd class="col-sm-8">
                                    <?= !empty($user['created_at']) ? date('F j, Y', strtotime((string)$user['created_at'])) : 'N/A' ?>
                                </dd>

                                <dt class="col-sm-4">Last Updated:</dt>
                                <dd class="col-sm-8">
                                    <?= !empty($user['updated_at']) ? date('F j, Y g:i A', strtotime((string)$user['updated_at'])) : 'N/A' ?>
                                </dd>
                            </dl>
                        </div>
                    </div>
                </div>

                <div class="card-footer text-end">
                    <!-- Students use /student/dashboard, not /dashboard -->
                    <a href="<?= base_url('student/dashboard') ?>" class="btn btn-outline-secondary">Back to Dashboard</a>
                </div>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>