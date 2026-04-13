<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
<div class="mb-4">
    <h2 class="fw-bold text-dark"><i class="bi bi-people text-primary me-2"></i>Manage Users & Roles</h2>
</div>

<div class="card glass-card border-0 overflow-hidden">
    <div class="card-body p-0">
        <table class="table table-hover table-borderless align-middle mb-0">
            <thead class="bg-light bg-opacity-50 text-secondary" style="border-bottom: 2px solid rgba(0,0,0,0.05);">
                <tr>
                    <th class="ps-4">ID</th>
                    <th>User</th>
                    <th>Email</th>
                    <th>Current Role</th>
                    <th class="text-end pe-4">Assign Role</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($users as $u): ?>
                <tr style="border-bottom: 1px solid rgba(0,0,0,0.03); transition: background 0.2s;">
                    <td class="ps-4 text-muted">#<?= $u['id'] ?></td>
                    <td>
                        <div class="d-flex align-items-center">
                            <div class="bg-primary bg-opacity-10 text-primary rounded-circle d-flex align-items-center justify-content-center me-3" style="width:40px;height:40px;">
                                <i class="bi bi-person-fill fs-5"></i>
                            </div>
                            <h6 class="mb-0 fw-bold"><?= esc($u['name']) ?></h6>
                        </div>
                    </td>
                    <td class="text-secondary"><?= esc($u['email']) ?></td>
                    <td>
                        <span class="badge rounded-pill bg-dark bg-opacity-10 text-dark border px-3 py-2">
                            <?= esc($u['role_label'] ?? 'Unassigned') ?>
                        </span>
                    </td>
                    <td class="text-end pe-4">
                        <form action="<?= base_url("admin/users/assign-role/{$u['id']}") ?>" method="post" class="d-flex justify-content-end align-items-center mb-0">
                            <?= csrf_field() ?>
                            <?php $currentUserId = session('user')['id'] ?? session('user_id'); ?>
                            
                            <select name="role_id" class="form-select form-select-sm me-2 bg-light border-0 shadow-none" style="width: auto; border-radius: 0.5rem;" <?= ($u['id'] == $currentUserId) ? 'disabled' : '' ?>>
                                <option value="">Select Role</option>
                                <?php foreach($roles as $r): ?>
                                    <option value="<?= $r['id'] ?>" <?= ($u['role_id'] == $r['id']) ? 'selected' : '' ?>>
                                        <?= esc($r['label']) ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                            
                            <button type="submit" class="btn btn-sm btn-brand rounded-pill px-3" <?= ($u['id'] == $currentUserId) ? 'disabled' : '' ?>>
                                Apply
                            </button>
                        </form>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>
<?= $this->endSection() ?>
