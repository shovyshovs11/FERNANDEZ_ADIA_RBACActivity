<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
<div class="container py-5 h-100">
    <div class="row d-flex justify-content-center align-items-center h-100">
        <div class="col-xl-9 col-lg-10">
            <div class="card glass-card border-0 overflow-hidden" style="border-radius: 1.5rem;">
                <div class="row g-0">
                    <div class="col-md-6 col-lg-5 d-none d-md-block" style="background: var(--brand-gradient);">
                        <!-- Decorator gradient block or image -->
                        <div class="d-flex align-items-center justify-content-center h-100 p-5 text-center text-white">
                            <div>
                                <h2 class="fw-bolder mb-4">Welcome Back</h2>
                                <p class="lead">Access your student portal, check class schedules, track assignments, and manage your courses effortlessly.</p>
                                <i class="bi bi-shield-lock text-white-50 mt-4" style="font-size: 5rem;"></i>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-7 d-flex align-items-center">
                        <div class="card-body p-4 p-lg-5 text-black">
                            <form action="<?= base_url('login') ?>" method="post">
                                <?= csrf_field() ?>
                                
                                <div class="d-flex align-items-center mb-5 pb-1">
                                    <span class="h2 fw-bold mb-0">Sign into your account</span>
                                </div>

                                <div class="form-outline mb-4">
                                    <label class="form-label" for="email">Email address</label>
                                    <input type="email" id="email" class="form-control form-control-lg bg-light border-0 <?= isset($validation) && $validation->hasError('email') ? 'is-invalid' : '' ?>" 
                                           name="email" value="<?= old('email') ?>" placeholder="name@example.com" required />
                                    <?php if (isset($validation) && $validation->hasError('email')): ?>
                                        <div class="invalid-feedback"><?= $validation->getError('email') ?></div>
                                    <?php endif; ?>
                                </div>

                                <div class="form-outline mb-4">
                                    <label class="form-label" for="password">Password</label>
                                    <input type="password" id="password" class="form-control form-control-lg bg-light border-0 <?= isset($validation) && $validation->hasError('password') ? 'is-invalid' : '' ?>" 
                                           name="password" placeholder="••••••••" required />
                                    <?php if (isset($validation) && $validation->hasError('password')): ?>
                                        <div class="invalid-feedback"><?= $validation->getError('password') ?></div>
                                    <?php endif; ?>
                                </div>

                                <div class="pt-1 mb-4">
                                    <button class="btn btn-brand btn-modern btn-lg w-100" type="submit">Sign In</button>
                                </div>

                                <p class="mb-5 pb-lg-2 text-muted" style="color: #393f81;">Don't have an account? <a href="<?= base_url('register') ?>" style="color: #4f46e5; text-decoration: none; font-weight: 600;">Register here</a></p>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>