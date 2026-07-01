<div class="card">
    <div class="card-header">
        <h3 class="card-title"><?= $pasien ? 'Edit Pasien' : 'Tambah Pasien' ?></h3>
    </div>
    <div class="card-body">
        <?= form_open_multipart('', ['class' => 'form-horizontal']) ?>
        <?php if ($pasien): ?>
            <input type="hidden" name="id_pasien" value="<?= $pasien['id_pasien'] ?>">
        <?php endif; ?>

        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label>No RM</label>
                    <input type="text" name="no_rm" class="form-control <?= form_error('no_rm') ? 'is-invalid' : '' ?>" value="<?= set_value('no_rm', $pasien['no_rm'] ?? '') ?>" <?= $pasien ? 'readonly' : '' ?>>
                    <small class="text-danger"><?= form_error('no_rm') ?></small>
                </div>
                <div class="form-group">
                    <label>Nama</label>
                    <input type="text" name="nama" class="form-control <?= form_error('nama') ? 'is-invalid' : '' ?>" value="<?= set_value('nama', $pasien['nama'] ?? '') ?>">
                    <small class="text-danger"><?= form_error('nama') ?></small>
                </div>
                <div class="form-group">
                    <label>Jenis Kelamin</label>
                    <div class="d-flex">
                        <div class="custom-control custom-radio mr-3">
                            <input type="radio" id="jk_l" name="jenis_kelamin" class="custom-control-input <?= form_error('jenis_kelamin') ? 'is-invalid' : '' ?>" value="L" <?= set_radio('jenis_kelamin', 'L', ($pasien['jenis_kelamin'] ?? '') == 'L') ?>>
                            <label class="custom-control-label" for="jk_l">Laki-laki</label>
                        </div>
                        <div class="custom-control custom-radio">
                            <input type="radio" id="jk_p" name="jenis_kelamin" class="custom-control-input <?= form_error('jenis_kelamin') ? 'is-invalid' : '' ?>" value="P" <?= set_radio('jenis_kelamin', 'P', ($pasien['jenis_kelamin'] ?? '') == 'P') ?>>
                            <label class="custom-control-label" for="jk_p">Perempuan</label>
                        </div>
                    </div>
                    <small class="text-danger"><?= form_error('jenis_kelamin') ?></small>
                </div>
                <div class="form-group">
                    <label>Tanggal Lahir</label>
                    <input type="date" name="tanggal_lahir" class="form-control <?= form_error('tanggal_lahir') ? 'is-invalid' : '' ?>" value="<?= set_value('tanggal_lahir', $pasien['tanggal_lahir'] ?? '') ?>">
                    <small class="text-danger"><?= form_error('tanggal_lahir') ?></small>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label>Telepon</label>
                    <input type="text" name="telepon" class="form-control <?= form_error('telepon') ? 'is-invalid' : '' ?>" value="<?= set_value('telepon', $pasien['telepon'] ?? '') ?>">
                    <small class="text-danger"><?= form_error('telepon') ?></small>
                </div>
                <div class="form-group">
                    <label>Alamat</label>
                    <textarea name="alamat" class="form-control" rows="3"><?= set_value('alamat', $pasien['alamat'] ?? '') ?></textarea>
                </div>
                <div class="form-group">
                    <label>Foto</label>
                    <div class="custom-file">
                        <input type="file" name="foto" class="custom-file-input <?= form_error('foto') ? 'is-invalid' : '' ?>" id="foto">
                        <label class="custom-file-label" for="foto">Pilih file...</label>
                    </div>
                    <small class="text-danger"><?= form_error('foto') ?></small>
                    <?php if ($pasien && $pasien['foto']): ?>
                        <div class="mt-2">
                            <img src="<?= base_url('uploads/pasien/' . $pasien['foto']) ?>" width="100" class="img-thumbnail">
                            <small class="d-block text-muted">Foto saat ini</small>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <div class="form-group mt-3">
            <a href="<?= site_url('pasien') ?>" class="btn btn-secondary">Batal</a>
            <button type="submit" class="btn btn-primary"><?= $pasien ? 'Simpan' : 'Tambah' ?></button>
        </div>
        <?= form_close() ?>
    </div>
</div>
