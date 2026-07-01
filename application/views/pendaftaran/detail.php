<div class="card">
    <div class="card-header">
        <h3 class="card-title">Detail Pendaftaran</h3>
        <div class="card-tools">
            <a href="<?= site_url('pendaftaran/edit/' . $p['id_daftar']) ?>" class="btn btn-warning btn-sm">
                <i class="fas fa-edit"></i> Edit
            </a>
            <a href="<?= site_url('pendaftaran') ?>" class="btn btn-secondary btn-sm">
                <i class="fas fa-arrow-left"></i> Kembali
            </a>
        </div>
    </div>
    <div class="card-body">
        <table class="table table-bordered">
            <tr>
                <th width="30%">ID Pendaftaran</th>
                <td><?= $p['id_daftar'] ?></td>
            </tr>
            <tr>
                <th>No RM</th>
                <td><?= $p['no_rm'] ?></td>
            </tr>
            <tr>
                <th>Pasien</th>
                <td><?= $p['nama_pasien'] ?></td>
            </tr>
            <tr>
                <th>Dokter</th>
                <td><?= $p['nama_dokter'] ?> (<?= $p['spesialis'] ?>)</td>
            </tr>
            <tr>
                <th>Poli</th>
                <td><?= $p['nama_poli'] ?></td>
            </tr>
            <tr>
                <th>Tanggal</th>
                <td><?= date('d/m/Y H:i', strtotime($p['tanggal'])) ?></td>
            </tr>
            <tr>
                <th>Keluhan</th>
                <td><?= nl2br($p['keluhan']) ?></td>
            </tr>
            <tr>
                <th>Status</th>
                <td>
                    <?php if ($p['status'] == 'Menunggu'): ?>
                        <span class="badge badge-warning">Menunggu</span>
                    <?php elseif ($p['status'] == 'Diperiksa'): ?>
                        <span class="badge badge-info">Diperiksa</span>
                    <?php else: ?>
                        <span class="badge badge-success">Selesai</span>
                    <?php endif; ?>
                </td>
            </tr>
        </table>
    </div>
</div>
