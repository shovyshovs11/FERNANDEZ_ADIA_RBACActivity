<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow">
                <div class="card-header bg-primary text-white">
                    <h4 class="mb-0">Edit Profile</h4>
                </div>
                
                <div class="card-body">
                    <form action="<?= base_url('profile/update') ?>" method="post" enctype="multipart/form-data">
                        <?= csrf_field() ?>
                        
                        <div class="row mb-4">
                            <!-- Image Upload -->
                            <div class="col-md-4 text-center">
                                <div class="mb-3">
                                    <?php if (!empty($user['profile_image']) && is_string($user['profile_image'])): ?>
                                        <img id="preview" src="<?= base_url('uploads/profiles/' . esc($user['profile_image'])) ?>" 
                                             class="rounded-circle img-thumbnail shadow-sm"
                                             style="width: 150px; height: 150px; object-fit: cover;">
                                    <?php else: ?>
                                        <img id="preview" src="" class="rounded-circle img-thumbnail shadow-sm d-none"
                                             style="width: 150px; height: 150px; object-fit: cover;">
                                        <div id="placeholder" class="rounded-circle bg-secondary d-flex align-items-center justify-content-center mx-auto shadow-sm"
                                             style="width: 150px; height: 150px;">
                                            <span class="text-white display-4"><?= strtoupper(substr((string)$user['name'], 0, 1)) ?></span>
                                        </div>
                                    <?php endif; ?>
                                </div>
                                
                                <div class="mb-3">
                                    <label class="form-label">Photo</label>
                                    <input type="file" 
                                           class="form-control form-control-sm <?= isset(session('errors')['profile_image']) ? 'is-invalid' : '' ?>" 
                                           id="profile_image" 
                                           name="profile_image" 
                                           accept="image/*">
                                    <small class="text-muted">Max 2MB</small>
                                    <?php if (isset(session('errors')['profile_image'])): ?>
                                        <div class="invalid-feedback"><?= session('errors')['profile_image'] ?></div>
                                    <?php endif; ?>
                                </div>
                            </div>

                            <!-- Form Fields -->
                            <div class="col-md-8">
                                <h5 class="border-bottom pb-2 mb-3">Basic Info</h5>
                                
                                <div class="mb-3">
                                    <label class="form-label">Full Name *</label>
                                    <input type="text" 
                                           class="form-control <?= isset(session('errors')['name']) ? 'is-invalid' : '' ?>" 
                                           name="name" 
                                           value="<?= old('name', esc((string)$user['name'])) ?>" 
                                           required>
                                    <?php if (isset(session('errors')['name'])): ?>
                                        <div class="invalid-feedback"><?= session('errors')['name'] ?></div>
                                    <?php endif; ?>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">Email *</label>
                                    <input type="email" 
                                           class="form-control <?= isset(session('errors')['email']) ? 'is-invalid' : '' ?>" 
                                           name="email" 
                                           value="<?= old('email', esc((string)$user['email'])) ?>" 
                                           required>
                                    <?php if (isset(session('errors')['email'])): ?>
                                        <div class="invalid-feedback"><?= session('errors')['email'] ?></div>
                                    <?php endif; ?>
                                </div>

                                <h5 class="border-bottom pb-2 mb-3 mt-4">Academic Info</h5>
                                
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Student ID</label>
                                        <input type="text" 
                                               class="form-control" 
                                               name="student_id" 
                                               value="<?= old('student_id', esc((string)($user['student_id'] ?? ''))) ?>"
                                               placeholder="2021-00123">
                                    </div>

                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Course</label>
                                        <input type="text" 
                                               class="form-control" 
                                               name="course" 
                                               value="<?= old('course', esc((string)($user['course'] ?? ''))) ?>"
                                               placeholder="BSIT">
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Year Level</label>
                                        <select class="form-select" name="year_level">
                                            <option value="">Select</option>
                                            <?php for($i = 1; $i <= 5; $i++): ?>
                                                <option value="<?= $i ?>" <?= old('year_level', $user['year_level'] ?? '') == $i ? 'selected' : '' ?>>
                                                    Year <?= $i ?>
                                                </option>
                                            <?php endfor; ?>
                                        </select>
                                    </div>

                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Section</label>
                                        <input type="text" 
                                               class="form-control" 
                                               name="section" 
                                               value="<?= old('section', esc((string)($user['section'] ?? ''))) ?>"
                                               placeholder="IT3A">
                                    </div>
                                </div>

                                <h5 class="border-bottom pb-2 mb-3 mt-4">Contact Info</h5>
                                
                                <div class="mb-3">
                                    <label class="form-label">Phone</label>
                                    <input type="text" 
                                           class="form-control" 
                                           name="phone" 
                                           value="<?= old('phone', esc((string)($user['phone'] ?? ''))) ?>"
                                           placeholder="09XX-XXX-XXXX">
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">Address</label>
                                    <textarea class="form-control" name="address" rows="3"><?= old('address', esc((string)($user['address'] ?? ''))) ?></textarea>
                                </div>
                            </div>
                        </div>

                        <hr>
                        
                        <div class="d-flex justify-content-between">
                            <a href="<?= base_url('profile') ?>" class="btn btn-outline-secondary">Cancel</a>
                            <button type="submit" class="btn btn-primary">Save Changes</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
                        <script>
                        document.getElementById('profile_image').addEventListener('change', function(event) {
                            const file = event.target.files[0];
                            if (file) {
                                const reader = new FileReader();
                                reader.onload = function(e) {
                                    const preview = document.getElementById('preview');
                                    const placeholder = document.getElementById('placeholder');
                                    
                                    preview.src = e.target.result;
                                    preview.classList.remove('d-none');
                                    
                                    if (placeholder) placeholder.classList.add('d-none');
                                };
                                reader.readAsDataURL(file);
                            }
                        });
                        </script>
                        <?= $this->endSection() ?>