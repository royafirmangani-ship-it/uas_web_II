<div class="card">
    <div class="card-header">
        <h3 class="card-title"><?= $dokter ? 'Edit Dokter' : 'Tambah Dokter' ?></h3>
    </div>
    <div class="card-body">
        <?= form_open('', ['class' => 'form-horizontal']) ?>
        <?php if ($dokter): ?>
            <input type="hidden" name="id_dokter" value="<?= $dokter['id_dokter'] ?>">
        <?php endif; ?>

        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label>Nama <span class="text-danger">*</span></label>
                    <input type="text" name="nama" class="form-control <?= form_error('nama') ? 'is-invalid' : '' ?>" value="<?= set_value('nama', $dokter['nama'] ?? '') ?>">
                    <small class="text-danger"><?= form_error('nama') ?></small>
                </div>
                <div class="form-group">
                    <label>Spesialis</label>
                    <input type="text" name="spesialis" class="form-control" value="<?= set_value('spesialis', $dokter['spesialis'] ?? '') ?>">
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label>Telepon</label>
                    <input type="text" name="telepon" class="form-control" value="<?= set_value('telepon', $dokter['telepon'] ?? '') ?>">
                </div>
                <div class="form-group">
                    <label>Alamat</label>
                    <textarea name="alamat" class="form-control" rows="3"><?= set_value('alamat', $dokter['alamat'] ?? '') ?></textarea>
                </div>
            </div>
        </div>

        <div class="form-group mt-3">
            <a href="<?= site_url('dokter') ?>" class="btn btn-secondary">Batal</a>
            <button type="submit" class="btn btn-primary"><?= $dokter ? 'Simpan' : 'Tambah' ?></button>
        </div>
        <?= form_close() ?>
    </div>
</div>
