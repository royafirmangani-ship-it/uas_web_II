<div class="card">
    <div class="card-header">
        <h3 class="card-title"><?= isset($obat) ? 'Edit' : 'Tambah' ?> Obat</h3>
    </div>
    <div class="card-body">
        <?= form_open() ?>
            <?php if (isset($obat)): ?>
                <input type="hidden" name="id_obat" value="<?= $obat['id_obat'] ?>">
            <?php endif; ?>

            <div class="form-group">
                <label for="nama_obat">Nama Obat</label>
                <input type="text" name="nama_obat" id="nama_obat" class="form-control <?= form_error('nama_obat') ? 'is-invalid' : '' ?>" value="<?= set_value('nama_obat', isset($obat) ? $obat['nama_obat'] : '') ?>">
                <div class="invalid-feedback"><?= form_error('nama_obat') ?></div>
            </div>

            <div class="form-group">
                <label for="stok">Stok</label>
                <input type="number" name="stok" id="stok" class="form-control <?= form_error('stok') ? 'is-invalid' : '' ?>" value="<?= set_value('stok', isset($obat) ? $obat['stok'] : '') ?>">
                <div class="invalid-feedback"><?= form_error('stok') ?></div>
            </div>

            <div class="form-group">
                <label for="harga">Harga</label>
                <input type="number" name="harga" id="harga" class="form-control <?= form_error('harga') ? 'is-invalid' : '' ?>" value="<?= set_value('harga', isset($obat) ? $obat['harga'] : '') ?>" step="0.01">
                <div class="invalid-feedback"><?= form_error('harga') ?></div>
            </div>

            <div class="form-group">
                <label for="satuan">Satuan</label>
                <input type="text" name="satuan" id="satuan" class="form-control <?= form_error('satuan') ? 'is-invalid' : '' ?>" value="<?= set_value('satuan', isset($obat) ? $obat['satuan'] : '') ?>">
                <div class="invalid-feedback"><?= form_error('satuan') ?></div>
            </div>

            <div class="form-group">
                <a href="<?= site_url('obat') ?>" class="btn btn-secondary">Batal</a>
                <button type="submit" class="btn btn-primary">Simpan</button>
            </div>
        <?= form_close() ?>
    </div>
</div>
