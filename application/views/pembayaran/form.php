<div class="card">
    <div class="card-header">
        <h3 class="card-title"><?= $pembayaran ? 'Edit Pembayaran' : 'Tambah Pembayaran' ?></h3>
    </div>
    <div class="card-body">
        <?= form_open($pembayaran ? 'pembayaran/edit/' . $pembayaran['id_bayar'] : 'pembayaran/create') ?>

            <?php if ($pembayaran): ?>
            <div class="alert alert-info">
                <strong>Pasien:</strong> <?= $pembayaran['no_rm'] ?> - <?= $pembayaran['nama_pasien'] ?> |
                <strong>Dokter:</strong> <?= $pembayaran['nama_dokter'] ?> |
                <strong>Poli:</strong> <?= $pembayaran['nama_poli'] ?>
            </div>
            <input type="hidden" name="id_periksa" value="<?= $pembayaran['id_periksa'] ?>">
            <?php endif; ?>

            <div class="form-group">
                <label>Pemeriksaan <span class="text-danger">*</span></label>
                <?php if ($pembayaran): ?>
                    <input type="text" class="form-control" value="<?= $pembayaran['no_rm'] ?> - <?= $pembayaran['nama_pasien'] ?> - <?= $pembayaran['nama_dokter'] ?> (<?= date('d-m-Y', strtotime($pembayaran['tgl_periksa'])) ?>)" readonly>
                <?php else: ?>
                    <select name="id_periksa" class="form-control <?= form_error('id_periksa') ? 'is-invalid' : '' ?>">
                        <option value="">-- Pilih Pemeriksaan --</option>
                        <?php foreach ($pemeriksaan as $p): ?>
                        <option value="<?= $p['id_periksa'] ?>" <?= set_value('id_periksa') == $p['id_periksa'] ? 'selected' : '' ?>>
                            <?= $p['no_rm'] ?> - <?= $p['nama_pasien'] ?> - <?= $p['nama_dokter'] ?> (<?= date('d-m-Y', strtotime($p['tanggal'])) ?>)
                        </option>
                        <?php endforeach; ?>
                    </select>
                    <div class="invalid-feedback"><?= form_error('id_periksa') ?></div>
                <?php endif; ?>
            </div>

            <div class="form-group">
                <label>Biaya <span class="text-danger">*</span></label>
                <input type="number" name="biaya" class="form-control <?= form_error('biaya') ? 'is-invalid' : '' ?>" value="<?= set_value('biaya', $pembayaran ? $pembayaran['biaya'] : '') ?>">
                <div class="invalid-feedback"><?= form_error('biaya') ?></div>
            </div>

            <div class="form-group">
                <label>Status <span class="text-danger">*</span></label>
                <select name="status" class="form-control <?= form_error('status') ? 'is-invalid' : '' ?>">
                    <option value="">-- Pilih Status --</option>
                    <option value="lunas" <?= set_value('status', $pembayaran ? $pembayaran['status'] : '') == 'lunas' ? 'selected' : '' ?>>Lunas</option>
                    <option value="belum" <?= set_value('status', $pembayaran ? $pembayaran['status'] : '') == 'belum' ? 'selected' : '' ?>>Belum</option>
                    <option value="batal" <?= set_value('status', $pembayaran ? $pembayaran['status'] : '') == 'batal' ? 'selected' : '' ?>>Batal</option>
                </select>
                <div class="invalid-feedback"><?= form_error('status') ?></div>
            </div>

            <div class="form-group">
                <label>Tanggal</label>
                <input type="datetime-local" name="tanggal" class="form-control" value="<?= set_value('tanggal', $pembayaran ? date('Y-m-d\TH:i', strtotime($pembayaran['tanggal'])) : date('Y-m-d\TH:i')) ?>">
            </div>

            <div class="form-group">
                <a href="<?= site_url('pembayaran') ?>" class="btn btn-secondary">Batal</a>
                <button type="submit" class="btn btn-primary">Simpan</button>
            </div>

        <?= form_close() ?>
    </div>
</div>
