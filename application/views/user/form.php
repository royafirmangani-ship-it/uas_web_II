<div class="card">
    <div class="card-header">
        <h3 class="card-title"><?= $user ? 'Edit User' : 'Tambah User' ?></h3>
    </div>
    <div class="card-body">
        <?= form_open($user ? 'user/edit/' . $user['id_user'] : 'user/create') ?>

            <div class="form-group">
                <label>Nama <span class="text-danger">*</span></label>
                <input type="text" name="nama" class="form-control <?= form_error('nama') ? 'is-invalid' : '' ?>" value="<?= set_value('nama', $user ? $user['nama'] : '') ?>">
                <div class="invalid-feedback"><?= form_error('nama') ?></div>
            </div>

            <div class="form-group">
                <label>Username <span class="text-danger">*</span></label>
                <input type="text" name="username" class="form-control <?= form_error('username') ? 'is-invalid' : '' ?>" value="<?= set_value('username', $user ? $user['username'] : '') ?>">
                <div class="invalid-feedback"><?= form_error('username') ?></div>
            </div>

            <div class="form-group">
                <label>Password <?= $user ? '<small class="text-muted">(kosongkan jika tidak diubah)</small>' : '<span class="text-danger">*</span>' ?></label>
                <input type="password" name="password" class="form-control <?= form_error('password') ? 'is-invalid' : '' ?>">
                <div class="invalid-feedback"><?= form_error('password') ?></div>
            </div>

            <div class="form-group">
                <label>Role <span class="text-danger">*</span></label>
                <select name="role" class="form-control <?= form_error('role') ? 'is-invalid' : '' ?>">
                    <option value="">-- Pilih Role --</option>
                    <option value="admin" <?= set_value('role', $user ? $user['role'] : '') == 'admin' ? 'selected' : '' ?>>Admin</option>
                    <option value="petugas" <?= set_value('role', $user ? $user['role'] : '') == 'petugas' ? 'selected' : '' ?>>Petugas</option>
                </select>
                <div class="invalid-feedback"><?= form_error('role') ?></div>
            </div>

            <div class="form-group">
                <a href="<?= site_url('user') ?>" class="btn btn-secondary">Batal</a>
                <button type="submit" class="btn btn-primary">Simpan</button>
            </div>

        <?= form_close() ?>
    </div>
</div>
