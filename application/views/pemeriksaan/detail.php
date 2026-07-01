<div class="card">
    <div class="card-header">
        <h3 class="card-title">Detail Pemeriksaan</h3>
        <div class="card-tools">
            <a href="<?= site_url('pemeriksaan/edit/' . $p['id_periksa']) ?>" class="btn btn-warning btn-sm">
                <i class="fas fa-edit"></i> Edit
            </a>
            <a href="<?= site_url('pemeriksaan') ?>" class="btn btn-secondary btn-sm">
                <i class="fas fa-arrow-left"></i> Kembali
            </a>
        </div>
    </div>
    <div class="card-body">
        <h5 class="text-primary mb-3">Informasi Pendaftaran</h5>
        <table class="table table-bordered">
            <tr>
                <th width="30%">No RM</th>
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
                <th>Tanggal Daftar</th>
                <td><?= date('d/m/Y H:i', strtotime($p['tgl_daftar'])) ?></td>
            </tr>
            <tr>
                <th>Keluhan</th>
                <td><?= nl2br($p['keluhan']) ?></td>
            </tr>
        </table>

        <h5 class="text-primary mb-3 mt-4">Hasil Pemeriksaan</h5>
        <table class="table table-bordered">
            <tr>
                <th width="30%">Diagnosa</th>
                <td><?= nl2br($p['diagnosa']) ?></td>
            </tr>
            <tr>
                <th>Tindakan</th>
                <td><?= nl2br($p['tindakan']) ?></td>
            </tr>
            <tr>
                <th>Berat Badan</th>
                <td><?= $p['berat'] ? $p['berat'] . ' kg' : '-' ?></td>
            </tr>
            <tr>
                <th>Tinggi Badan</th>
                <td><?= $p['tinggi'] ? $p['tinggi'] . ' cm' : '-' ?></td>
            </tr>
            <tr>
                <th>Tekanan Darah</th>
                <td><?= $p['tekanan_darah'] ?: '-' ?></td>
            </tr>
            <tr>
                <th>Catatan</th>
                <td><?= nl2br($p['catatan'] ?? '-') ?></td>
            </tr>
            <tr>
                <th>Tanggal Periksa</th>
                <td><?= $p['tgl_periksa'] ? date('d/m/Y H:i', strtotime($p['tgl_periksa'])) : '-' ?></td>
            </tr>
        </table>
    </div>
</div>
