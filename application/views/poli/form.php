<div class="card">
    <div class="card-header">
        <h3 class="card-title"><?= isset($poli) ? 'Edit' : 'Tambah' ?> Poli</h3>
    </div>
    <div class="card-body">
        <?= form_open() ?>
            <?php if (isset($poli)): ?>
                <input type="hidden" name="id_poli" value="<?= $poli['id_poli'] ?>">
            <?php endif; ?>

            <div class="form-group">
                <label for="nama_poli">Nama Poli</label>
                <input type="text" name="nama_poli" id="nama_poli" class="form-control <?= form_error('nama_poli') ? 'is-invalid' : '' ?>" value="<?= set_value('nama_poli', isset($poli) ? $poli['nama_poli'] : '') ?>">
                <div class="invalid-feedback"><?= form_error('nama_poli') ?></div>
            </div>

            <div class="form-group">
                <a href="<?= site_url('poli') ?>" class="btn btn-secondary">Batal</a>
                <button type="submit" class="btn btn-primary">Simpan</button>
            </div>
        <?= form_close() ?>
    </div>
</div>
