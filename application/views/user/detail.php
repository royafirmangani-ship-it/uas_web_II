<div class="card">
    <div class="card-header">
        <h3 class="card-title">Detail User</h3>
        <div class="card-tools">
            <a href="<?= site_url('user/edit/' . $user['id_user']) ?>" class="btn btn-warning btn-sm">
                <i class="fas fa-edit"></i> Edit
            </a>
            <a href="<?= site_url('user') ?>" class="btn btn-secondary btn-sm">
                <i class="fas fa-arrow-left"></i> Kembali
            </a>
        </div>
    </div>
    <div class="card-body">
        <table class="table table-bordered">
            <tr>
                <th width="30%">ID User</th>
                <td><?= $user['id_user'] ?></td>
            </tr>
            <tr>
                <th>Nama</th>
                <td><?= $user['nama'] ?></td>
            </tr>
            <tr>
                <th>Username</th>
                <td><?= $user['username'] ?></td>
            </tr>
            <tr>
                <th>Role</th>
                <td>
                    <?php if ($user['role'] == 'admin'): ?>
                        <span class="badge badge-danger">Admin</span>
                    <?php else: ?>
                        <span class="badge badge-info">Petugas</span>
                    <?php endif; ?>
                </td>
            </tr>
            <tr>
                <th>Tanggal Dibuat</th>
                <td><?= date('d-m-Y H:i:s', strtotime($user['created_at'])) ?></td>
            </tr>
            <tr>
                <th>Terakhir Diupdate</th>
                <td><?= $user['updated_at'] ? date('d-m-Y H:i:s', strtotime($user['updated_at'])) : '-' ?></td>
            </tr>
        </table>
    </div>
</div>
