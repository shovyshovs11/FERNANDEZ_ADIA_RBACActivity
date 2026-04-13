<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2 class="fw-bold mb-0 text-dark"><i class="bi bi-shield-lock text-primary me-2"></i>Manage Roles</h2>
    <a href="<?= base_url('admin/roles/create') ?>" class="btn btn-brand btn-modern shadow-sm">
        <i class="bi bi-plus-circle me-1"></i> Create New Role
    </a>
</div>

<div class="card glass-card border-0 overflow-hidden">
    <div class="card-body p-0">
        <table class="table table-hover table-borderless align-middle mb-0">
            <thead class="bg-light bg-opacity-50 text-secondary" style="border-bottom: 2px solid rgba(0,0,0,0.05);">
                <tr>
                    <th class="ps-4">ID</th>
                    <th>Name (Slug)</th>
                    <th>Label</th>
                    <th>Description</th>
                    <th>Users</th>
                    <th class="text-end pe-4">Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($roles as $r): ?>
                <tr style="border-bottom: 1px solid rgba(0,0,0,0.03); transition: background 0.2s;">
                    <td class="ps-4 text-muted">#<?= $r['id'] ?></td>
                    <td><span class="badge rounded-pill bg-light text-dark border px-3 py-2"><?= esc($r['name']) ?></span></td>
                    <td><h6 class="mb-0 fw-bold"><?= esc($r['label']) ?></h6></td>
                    <td class="text-secondary"><?= esc($r['description']) ?></td>
                    <td>
                        <span class="badge rounded-pill bg-primary bg-opacity-10 text-primary px-3 py-2 font-monospace">
                            <i class="bi bi-people-fill me-1"></i> <?= isset($counts[$r['id']]) ? $counts[$r['id']] : 0 ?>
                        </span>
                    </td>
                    <td class="text-end pe-4">
                        <a href="<?= base_url("admin/roles/edit/{$r['id']}") ?>" class="btn btn-sm btn-outline-primary rounded-pill px-3">Edit</a>
                        <?php if ($r['name'] !== 'admin'): ?>
                            <a href="<?= base_url("admin/roles/delete/{$r['id']}") ?>" class="btn btn-sm btn-outline-danger rounded-pill px-3 ms-1" onclick="return confirm('Delete this role?')">Delete</a>
                        <?php endif; ?>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>
<?= $this->endSection() ?>
