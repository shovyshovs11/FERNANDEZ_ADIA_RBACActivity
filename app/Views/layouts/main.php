<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?? 'CI4 Exam App' ?></title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <style>
        :root {
            --primary-bg: #f8fafc;
            --glass-bg: rgba(255, 255, 255, 0.75);
            --glass-border: rgba(255, 255, 255, 0.4);
            --glass-shadow: 0 8px 32px 0 rgba(31, 38, 135, 0.07);
            --brand-gradient: linear-gradient(135deg, #4f46e5 0%, #7c3aed 100%);
            --text-dark: #0f172a;
        }

        body {
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            font-family: 'Inter', sans-serif;
            background-color: #f1f5f9;
            background-image:
                radial-gradient(at 0% 0%, hsla(253,16%,7%,1) 0, transparent 50%),
                radial-gradient(at 50% 0%, hsla(225,39%,30%,1) 0, transparent 50%),
                radial-gradient(at 100% 0%, hsla(339,49%,30%,1) 0, transparent 50%);
            background-attachment: fixed;
            color: var(--text-dark);
            animation: gradient-bg 15s ease infinite alternate;
        }

        @keyframes gradient-bg {
            0%   { background-position: 0% 50%; }
            50%  { background-position: 100% 50%; }
            100% { background-position: 0% 50%; }
        }

        .navbar.dynamic-nav {
            border-bottom: 1px solid var(--glass-border);
            box-shadow: var(--glass-shadow);
            padding: 1rem 0;
            z-index: 1030;
            transition: background-color 0.3s ease;
        }

        .navbar-brand {
            font-weight: 700;
            font-size: 1.5rem;
            letter-spacing: -0.5px;
            color: #ffffff !important;
        }

        .nav-link {
            font-weight: 500;
            color: rgba(255, 255, 255, 0.85) !important;
            transition: all 0.3s ease;
        }

        .nav-link:hover {
            color: #ffffff !important;
            transform: translateY(-1px);
        }

        .glass-card {
            background: rgba(255, 255, 255, 0.85);
            backdrop-filter: blur(16px);
            border: 1px solid rgba(255,255,255,0.6);
            border-radius: 1rem;
            box-shadow: 0 10px 40px rgba(0,0,0,0.05);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .glass-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 15px 50px rgba(0,0,0,0.08);
        }

        .content {
            flex: 1;
            position: relative;
            z-index: 1;
            animation: fadeIn 0.6s cubic-bezier(0.16, 1, 0.3, 1) forwards;
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(10px); }
            to   { opacity: 1; transform: translateY(0); }
        }

        .dropdown-menu {
            border: none;
            border-radius: 0.75rem;
            box-shadow: 0 10px 40px rgba(0,0,0,0.1);
            animation: dropdownFade 0.2s ease;
        }

        @keyframes dropdownFade {
            from { opacity: 0; transform: translateY(5px); }
            to   { opacity: 1; transform: translateY(0); }
        }

        .btn-modern {
            border-radius: 0.5rem;
            font-weight: 500;
            letter-spacing: 0.3px;
            padding: 0.5rem 1.25rem;
            transition: all 0.3s ease;
        }

        .btn-brand {
            background: var(--brand-gradient);
            border: none;
            color: white;
            box-shadow: 0 4px 15px rgba(79, 70, 229, 0.3);
        }

        .btn-brand:hover {
            box-shadow: 0 6px 20px rgba(79, 70, 229, 0.4);
            transform: translateY(-2px);
            color: white;
        }
    </style>
</head>
<body class="bg-light">

    <?php if (session()->has('user')): ?>
    <?php
        $role     = session('user')['role'] ?? '';
        $navColor = match($role) {
            'admin'   => 'bg-danger',
            'teacher' => 'bg-success',
            default   => 'bg-primary',   // student, coordinator, guest
        };
    ?>
    <nav class="navbar navbar-expand-lg navbar-dark dynamic-nav <?= $navColor ?> sticky-top mb-4">
        <div class="container">
            <a class="navbar-brand d-flex align-items-center" href="#">
                CI4 Exam App
                <span class="badge bg-light text-dark ms-3 shadow-sm" style="font-size: 0.75rem; vertical-align: middle;">
                    <?= strtoupper((string) esc($role)) ?> ROLE
                </span>
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto ps-3">
                    <?php if ($role === 'admin'): ?>
                        <li class="nav-item"><a class="nav-link" href="<?= base_url('dashboard') ?>">Dashboard</a></li>
                        <li class="nav-item"><a class="nav-link" href="<?= base_url('admin/roles') ?>">Manage Roles</a></li>
                        <li class="nav-item"><a class="nav-link" href="<?= base_url('admin/users') ?>">Assign Roles</a></li>
                        <li class="nav-item"><a class="nav-link" href="<?= base_url('students') ?>">Students</a></li>
                    <?php elseif ($role === 'teacher'): ?>
                        <li class="nav-item"><a class="nav-link" href="<?= base_url('dashboard') ?>">Dashboard</a></li>
                        <li class="nav-item"><a class="nav-link" href="<?= base_url('records') ?>">Records</a></li>
                        <li class="nav-item"><a class="nav-link" href="<?= base_url('students') ?>">Students</a></li>
                    <?php elseif ($role === 'coordinator'): ?>
                        <li class="nav-item"><a class="nav-link" href="<?= base_url('dashboard') ?>">Dashboard</a></li>
                        <li class="nav-item"><a class="nav-link" href="<?= base_url('records') ?>">Records</a></li>
                    <?php else: ?>
                        <!-- student (default) -->
                        <li class="nav-item"><a class="nav-link" href="<?= base_url('student/dashboard') ?>">Dashboard</a></li>
                        <li class="nav-item"><a class="nav-link" href="<?= base_url('profile') ?>"><i class="bi bi-person-circle"></i> Profile</a></li>
                    <?php endif; ?>
                </ul>
                <ul class="navbar-nav">
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-bs-toggle="dropdown">
                            <?= esc(explode(' ', session('user')['name'] ?? '')[0]) ?>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end">
                            <?php if ($role === 'student'): ?>
                                <li><a class="dropdown-item" href="<?= base_url('profile') ?>">My Profile</a></li>
                                <li><hr class="dropdown-divider"></li>
                            <?php endif; ?>
                            <li><a class="dropdown-item" href="<?= base_url('logout') ?>">Logout</a></li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    <?php endif; ?>

    <div class="content container my-4">
        <?php if (session()->getFlashdata('success')): ?>
            <div class="alert alert-success alert-dismissible fade show shadow-sm border-0 rounded-3" role="alert">
                <?= session()->getFlashdata('success') ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        <?php endif; ?>

        <?php if (session()->getFlashdata('error')): ?>
            <div class="alert alert-danger alert-dismissible fade show shadow-sm border-0 rounded-3" role="alert">
                <?= session()->getFlashdata('error') ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        <?php endif; ?>

        <?= $this->renderSection('content') ?>
    </div>

    <footer class="bg-light text-center py-3 mt-auto">
        <div class="container">
            <small class="text-muted">Student Name: [YOUR NAME] | ID: [YOUR ID] | Web Systems & Technologies</small>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>