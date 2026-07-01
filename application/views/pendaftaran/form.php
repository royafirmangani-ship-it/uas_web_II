<div class="card">
    <div class="card-header">
        <h3 class="card-title"><?= $pendaftaran ? 'Edit Pendaftaran' : 'Tambah Pendaftaran' ?></h3>
    </div>
    <div class="card-body">
        <?= form_open($pendaftaran ? 'pendaftaran/edit/' . $pendaftaran['id_daftar'] : 'pendaftaran/create') ?>

            <?php if ($pendaftaran): ?>
                <input type="hidden" name="id_daftar" value="<?= $pendaftaran['id_daftar'] ?>">
            <?php endif; ?>

            <div class="form-group">
                <label>Pasien <span class="text-danger">*</span></label>
                <select name="id_pasien" class="form-control <?= form_error('id_pasien') ? 'is-invalid' : '' ?>">
                    <option value="">-- Pilih Pasien --</option>
                    <?php foreach ($pasien as $id => $nama): ?>
                        <option value="<?= $id ?>" <?= set_value('id_pasien', $pendaftaran ? $pendaftaran['id_pasien'] : '') == $id ? 'selected' : '' ?>><?= $nama ?></option>
                    <?php endforeach; ?>
                </select>
                <div class="invalid-feedback"><?= form_error('id_pasien') ?></div>
            </div>

            <div class="form-group">
                <label>Dokter <span class="text-danger">*</span></label>
                <select name="id_dokter" id="id_dokter" class="form-control <?= form_error('id_dokter') ? 'is-invalid' : '' ?>">
                    <option value="">-- Pilih Dokter --</option>
                    <?php foreach ($dokter as $id => $nama): ?>
                        <option value="<?= $id ?>" <?= set_value('id_dokter', $pendaftaran ? $pendaftaran['id_dokter'] : '') == $id ? 'selected' : '' ?>><?= $nama ?></option>
                    <?php endforeach; ?>
                </select>
                <div class="invalid-feedback"><?= form_error('id_dokter') ?></div>
            </div>

            <div class="form-group">
                <label>Poli <span class="text-danger">*</span></label>
                <select name="id_poli" id="id_poli" class="form-control <?= form_error('id_poli') ? 'is-invalid' : '' ?>">
                    <option value="">-- Pilih Poli --</option>
                    <?php foreach ($poli as $id => $nama): ?>
                        <option value="<?= $id ?>" <?= set_value('id_poli', $pendaftaran ? $pendaftaran['id_poli'] : '') == $id ? 'selected' : '' ?>><?= $nama ?></option>
                    <?php endforeach; ?>
                </select>
                <div class="invalid-feedback"><?= form_error('id_poli') ?></div>
            </div>

            <div class="form-group">
                <label>Keluhan <span class="text-danger">*</span></label>
                <textarea name="keluhan" class="form-control <?= form_error('keluhan') ? 'is-invalid' : '' ?>" rows="4"><?= set_value('keluhan', $pendaftaran ? $pendaftaran['keluhan'] : '') ?></textarea>
                <div class="invalid-feedback"><?= form_error('keluhan') ?></div>
            </div>

            <?php if ($pendaftaran): ?>
            <div class="form-group">
                <label>Status</label>
                <select name="status" class="form-control">
                    <option value="Menunggu" <?= $pendaftaran['status'] == 'Menunggu' ? 'selected' : '' ?>>Menunggu</option>
                    <option value="Diperiksa" <?= $pendaftaran['status'] == 'Diperiksa' ? 'selected' : '' ?>>Diperiksa</option>
                    <option value="Selesai" <?= $pendaftaran['status'] == 'Selesai' ? 'selected' : '' ?>>Selesai</option>
                </select>
            </div>
            <?php endif; ?>

            <div class="form-group">
                <a href="<?= site_url('pendaftaran') ?>" class="btn btn-secondary">Batal</a>
                <button type="submit" class="btn btn-primary">Simpan</button>
            </div>

        <?= form_close() ?>
    </div>
</div>
