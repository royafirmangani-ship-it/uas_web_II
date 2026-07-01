<div class="card">
    <div class="card-header">
        <h3 class="card-title"><?= $pemeriksaan ? 'Edit Pemeriksaan' : 'Tambah Pemeriksaan' ?></h3>
    </div>
    <div class="card-body">
        <?= form_open($pemeriksaan ? 'pemeriksaan/edit/' . $pemeriksaan['id_periksa'] : 'pemeriksaan/create') ?>

            <?php if ($pemeriksaan): ?>
                <input type="hidden" name="id_daftar" value="<?= $pemeriksaan['id_daftar'] ?>">

                <div class="card bg-light mb-3">
                    <div class="card-body">
                        <h6 class="card-title text-primary">Informasi Pendaftaran</h6>
                        <table class="table table-sm table-borderless mb-0">
                            <tr>
                                <td width="120"><strong>No RM</strong></td>
                                <td>: <?= $pemeriksaan['no_rm'] ?></td>
                            </tr>
                            <tr>
                                <td><strong>Pasien</strong></td>
                                <td>: <?= $pemeriksaan['nama_pasien'] ?></td>
                            </tr>
                            <tr>
                                <td><strong>Dokter</strong></td>
                                <td>: <?= $pemeriksaan['nama_dokter'] ?> (<?= $pemeriksaan['spesialis'] ?>)</td>
                            </tr>
                            <tr>
                                <td><strong>Poli</strong></td>
                                <td>: <?= $pemeriksaan['nama_poli'] ?></td>
                            </tr>
                            <tr>
                                <td><strong>Keluhan</strong></td>
                                <td>: <?= $pemeriksaan['keluhan'] ?></td>
                            </tr>
                        </table>
                    </div>
                </div>
            <?php else: ?>
                <div class="form-group">
                    <label>Pendaftaran <span class="text-danger">*</span></label>
                    <select name="id_daftar" class="form-control <?= form_error('id_daftar') ? 'is-invalid' : '' ?>">
                        <option value="">-- Pilih Pendaftaran --</option>
                        <?php foreach ($pendaftaran_list as $pl): ?>
                            <option value="<?= $pl['id_daftar'] ?>" <?= set_value('id_daftar') == $pl['id_daftar'] ? 'selected' : '' ?>>
                                <?= $pl['no_rm'] ?> - <?= $pl['nama_pasien'] ?> - <?= $pl['nama_dokter'] ?> - <?= $pl['nama_poli'] ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                    <div class="invalid-feedback"><?= form_error('id_daftar') ?></div>
                </div>
            <?php endif; ?>

            <div class="form-group">
                <label>Diagnosa <span class="text-danger">*</span></label>
                <textarea name="diagnosa" class="form-control <?= form_error('diagnosa') ? 'is-invalid' : '' ?>" rows="4"><?= set_value('diagnosa', $pemeriksaan ? $pemeriksaan['diagnosa'] : '') ?></textarea>
                <div class="invalid-feedback"><?= form_error('diagnosa') ?></div>
            </div>

            <div class="form-group">
                <label>Tindakan</label>
                <textarea name="tindakan" class="form-control" rows="3"><?= set_value('tindakan', $pemeriksaan ? $pemeriksaan['tindakan'] : '') ?></textarea>
            </div>

            <div class="row">
                <div class="col-md-4">
                    <div class="form-group">
                        <label>Berat Badan (kg)</label>
                        <input type="number" name="berat" step="0.01" class="form-control" value="<?= set_value('berat', $pemeriksaan ? $pemeriksaan['berat'] : '') ?>">
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label>Tinggi Badan (cm)</label>
                        <input type="number" name="tinggi" step="0.01" class="form-control" value="<?= set_value('tinggi', $pemeriksaan ? $pemeriksaan['tinggi'] : '') ?>">
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label>Tekanan Darah</label>
                        <input type="text" name="tekanan_darah" class="form-control" placeholder="cth: 120/80" value="<?= set_value('tekanan_darah', $pemeriksaan ? $pemeriksaan['tekanan_darah'] : '') ?>">
                    </div>
                </div>
            </div>

            <div class="form-group">
                <label>Catatan</label>
                <textarea name="catatan" class="form-control" rows="3"><?= set_value('catatan', $pemeriksaan ? $pemeriksaan['catatan'] : '') ?></textarea>
            </div>

            <div class="form-group">
                <a href="<?= site_url('pemeriksaan') ?>" class="btn btn-secondary">Batal</a>
                <button type="submit" class="btn btn-primary">Simpan</button>
            </div>

        <?= form_close() ?>
    </div>
</div>
