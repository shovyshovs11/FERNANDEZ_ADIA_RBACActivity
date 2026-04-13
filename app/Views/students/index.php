<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
<div class="card glass-card border-0 mb-4 p-4">
    <h2 class="mb-4"><i class="bi bi-people-fill text-primary me-2"></i>Student Accounts</h2>
    <div class="table-responsive">
        <table class="table table-hover align-middle">
            <thead class="bg-light">
                <tr>
                    <th>Target ID</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th class="text-end">Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php if(!empty($students)): ?>
                    <?php foreach($students as $s): ?>
                        <tr>
                            <td class="text-muted">#<?= $s['id'] ?></td>
                            <td class="fw-bold"><?= esc($s['name']) ?></td>
                            <td><?= esc($s['email']) ?></td>
                            <td class="text-end">
                                <a href="<?= base_url('students/show/' . $s['id']) ?>" class="btn btn-sm btn-outline-primary rounded-pill px-3">View Profile</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr><td colspan="4" class="text-center py-4">No student records found.</td></tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>
<?= $this->endSection() ?>
