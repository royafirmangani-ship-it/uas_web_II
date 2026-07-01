<div class="card">
    <div class="card-header">
        <h3 class="card-title"><?= $resep ? 'Edit Resep' : 'Tambah Resep' ?></h3>
    </div>
    <div class="card-body">
        <?= form_open($resep ? 'resep/edit/' . $resep['id_resep'] : 'resep/create') ?>

            <?php if ($resep): ?>
            <div class="alert alert-info">
                <strong>Pasien:</strong> <?= $resep['no_rm'] ?> - <?= $resep['nama_pasien'] ?> |
                <strong>Dokter:</strong> <?= $resep['nama_dokter'] ?> |
                <strong>Poli:</strong> <?= $resep['nama_poli'] ?> |
                <strong>Tanggal Periksa:</strong> <?= date('d-m-Y', strtotime($resep['tgl_periksa'])) ?>
            </div>
            <input type="hidden" name="id_periksa" value="<?= $resep['id_periksa'] ?>">
            <?php endif; ?>

            <div class="form-group">
                <label>Pemeriksaan <span class="text-danger">*</span></label>
                <?php if ($resep): ?>
                    <input type="text" class="form-control" value="<?= $resep['no_rm'] ?> - <?= $resep['nama_pasien'] ?> - <?= $resep['nama_dokter'] ?> (<?= date('d-m-Y', strtotime($resep['tgl_periksa'])) ?>)" readonly>
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

            <hr>
            <h5>Detail Resep</h5>
            <div class="table-responsive">
                <table class="table table-bordered" id="detail-table">
                    <thead>
                        <tr>
                            <th>Obat</th>
                            <th>Jumlah</th>
                            <th>Aturan Pakai</th>
                            <th width="10%">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (isset($detail) && $detail): ?>
                            <?php foreach ($detail as $d): ?>
                            <tr class="detail-row">
                                <td>
                                    <select name="id_obat[]" class="form-control">
                                        <option value="">-- Pilih Obat --</option>
                                        <?php foreach ($obat as $o): ?>
                                        <option value="<?= $o['id_obat'] ?>" <?= $d['id_obat'] == $o['id_obat'] ? 'selected' : '' ?>>
                                            <?= $o['nama_obat'] ?> (Stok: <?= $o['stok'] ?>)
                                        </option>
                                        <?php endforeach; ?>
                                    </select>
                                </td>
                                <td>
                                    <input type="number" name="jumlah[]" class="form-control" value="<?= $d['jumlah'] ?>" min="1">
                                </td>
                                <td>
                                    <input type="text" name="aturan_pakai[]" class="form-control" value="<?= $d['aturan_pakai'] ?>">
                                </td>
                                <td>
                                    <button type="button" class="btn btn-danger btn-sm hapus-row">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                        <tr class="detail-row">
                            <td>
                                <select name="id_obat[]" class="form-control">
                                    <option value="">-- Pilih Obat --</option>
                                    <?php foreach ($obat as $o): ?>
                                    <option value="<?= $o['id_obat'] ?>"><?= $o['nama_obat'] ?> (Stok: <?= $o['stok'] ?>)</option>
                                    <?php endforeach; ?>
                                </select>
                            </td>
                            <td>
                                <input type="number" name="jumlah[]" class="form-control" value="1" min="1">
                            </td>
                            <td>
                                <input type="text" name="aturan_pakai[]" class="form-control" placeholder="cth: 3x1">
                            </td>
                            <td>
                                <button type="button" class="btn btn-danger btn-sm hapus-row">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </td>
                        </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>

            <button type="button" class="btn btn-success btn-sm mb-3" id="tambah-obat">
                <i class="fas fa-plus"></i> Tambah Obat
            </button>

            <div id="template-row" style="display:none;">
                <table>
                    <tr class="detail-row">
                        <td>
                            <select name="id_obat[]" class="form-control">
                                <option value="">-- Pilih Obat --</option>
                                <?php foreach ($obat as $o): ?>
                                <option value="<?= $o['id_obat'] ?>"><?= $o['nama_obat'] ?> (Stok: <?= $o['stok'] ?>)</option>
                                <?php endforeach; ?>
                            </select>
                        </td>
                        <td>
                            <input type="number" name="jumlah[]" class="form-control" value="1" min="1">
                        </td>
                        <td>
                            <input type="text" name="aturan_pakai[]" class="form-control" placeholder="cth: 3x1">
                        </td>
                        <td>
                            <button type="button" class="btn btn-danger btn-sm hapus-row">
                                <i class="fas fa-trash"></i>
                            </button>
                        </td>
                    </tr>
                </table>
            </div>

            <div class="form-group">
                <a href="<?= site_url('resep') ?>" class="btn btn-secondary">Batal</a>
                <button type="submit" class="btn btn-primary">Simpan</button>
            </div>

        <?= form_close() ?>
    </div>
</div>

<script>
$(document).ready(function() {
    $('#tambah-obat').click(function() {
        var row = $('#template-row table tr').clone();
        $('#detail-table tbody').append(row);
    });

    $(document).on('click', '.hapus-row', function() {
        if ($('#detail-table tbody tr').length > 1) {
            $(this).closest('tr').remove();
        } else {
            alert('Minimal satu obat harus diisi.');
        }
    });
});
</script>
