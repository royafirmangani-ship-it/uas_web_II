<div class="card">
    <div class="card-header">
        <h3 class="card-title">Detail Pembayaran</h3>
        <div class="card-tools">
            <a href="<?= site_url('pembayaran/nota/' . $pembayaran['id_bayar']) ?>" class="btn btn-secondary btn-sm" target="_blank">
                <i class="fas fa-print"></i> Nota
            </a>
            <a href="<?= site_url('pembayaran') ?>" class="btn btn-secondary btn-sm">
                <i class="fas fa-arrow-left"></i> Kembali
            </a>
        </div>
    </div>
    <div class="card-body">
        <table class="table table-bordered">
            <tr>
                <th width="20%">No Invoice</th>
                <td>INV-<?= str_pad($pembayaran['id_bayar'], 4, '0', STR_PAD_LEFT) ?></td>
                <th width="20%">Status</th>
                <td>
                    <?php if ($pembayaran['status'] == 'lunas'): ?>
                        <span class="badge badge-success">Lunas</span>
                    <?php elseif ($pembayaran['status'] == 'belum'): ?>
                        <span class="badge badge-warning">Belum</span>
                    <?php else: ?>
                        <span class="badge badge-danger">Batal</span>
                    <?php endif; ?>
                </td>
            </tr>
            <tr>
                <th>No RM</th>
                <td><?= $pembayaran['no_rm'] ?></td>
                <th>Pasien</th>
                <td><?= $pembayaran['nama_pasien'] ?></td>
            </tr>
            <tr>
                <th>Alamat</th>
                <td colspan="3"><?= $pembayaran['alamat'] ?: '-' ?></td>
            </tr>
            <tr>
                <th>Telepon</th>
                <td><?= $pembayaran['telp'] ?: '-' ?></td>
                <th>Dokter</th>
                <td><?= $pembayaran['nama_dokter'] ?></td>
            </tr>
            <tr>
                <th>Poli</th>
                <td><?= $pembayaran['nama_poli'] ?></td>
                <th>Tanggal Periksa</th>
                <td><?= date('d-m-Y', strtotime($pembayaran['tgl_periksa'])) ?></td>
            </tr>
            <tr>
                <th>Keluhan</th>
                <td colspan="3"><?= $pembayaran['keluhan'] ?: '-' ?></td>
            </tr>
            <tr>
                <th>Diagnosa</th>
                <td colspan="3"><?= $pembayaran['diagnosa'] ?: '-' ?></td>
            </tr>
            <tr>
                <th>Tindakan</th>
                <td colspan="3"><?= $pembayaran['tindakan'] ?: '-' ?></td>
            </tr>
            <tr>
                <th>Biaya</th>
                <td colspan="3">Rp <?= number_format($pembayaran['biaya'], 0, ',', '.') ?></td>
            </tr>
            <tr>
                <th>Tanggal Pembayaran</th>
                <td colspan="3"><?= date('d-m-Y H:i', strtotime($pembayaran['tanggal'])) ?></td>
            </tr>
        </table>
    </div>
</div>
