<div class="card">
    <div class="card-header">
        <h3 class="card-title">Detail Resep</h3>
        <div class="card-tools">
            <a href="<?= site_url('resep') ?>" class="btn btn-secondary btn-sm">
                <i class="fas fa-arrow-left"></i> Kembali
            </a>
        </div>
    </div>
    <div class="card-body">
        <table class="table table-bordered mb-4">
            <tr>
                <th width="20%">No RM</th>
                <td><?= $resep['no_rm'] ?></td>
                <th width="20%">Pasien</th>
                <td><?= $resep['nama_pasien'] ?></td>
            </tr>
            <tr>
                <th>Dokter</th>
                <td><?= $resep['nama_dokter'] ?></td>
                <th>Poli</th>
                <td><?= $resep['nama_poli'] ?></td>
            </tr>
            <tr>
                <th>Diagnosa</th>
                <td colspan="3"><?= $resep['diagnosa'] ?: '-' ?></td>
            </tr>
            <tr>
                <th>Tindakan</th>
                <td colspan="3"><?= $resep['tindakan'] ?: '-' ?></td>
            </tr>
            <tr>
                <th>Tanggal Periksa</th>
                <td><?= date('d-m-Y', strtotime($resep['tgl_periksa'])) ?></td>
                <th>Tanggal Resep</th>
                <td><?= date('d-m-Y H:i', strtotime($resep['tanggal'])) ?></td>
            </tr>
        </table>

        <h5>Daftar Obat</h5>
        <div class="table-responsive">
            <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th width="5%">No</th>
                        <th>Nama Obat</th>
                        <th>Jumlah</th>
                        <th>Satuan</th>
                        <th>Aturan Pakai</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if ($detail): ?>
                        <?php $no = 1; ?>
                        <?php foreach ($detail as $d): ?>
                        <tr>
                            <td><?= $no++ ?></td>
                            <td><?= $d['nama_obat'] ?></td>
                            <td><?= $d['jumlah'] ?></td>
                            <td><?= $d['satuan'] ?></td>
                            <td><?= $d['aturan_pakai'] ?: '-' ?></td>
                        </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="5" class="text-center">Tidak ada data obat</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
