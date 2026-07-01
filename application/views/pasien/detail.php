<div class="card">
    <div class="card-header">
        <h3 class="card-title">Detail Pasien</h3>
        <div class="card-tools">
            <a href="<?= site_url('pasien') ?>" class="btn btn-secondary btn-sm"><i class="fas fa-arrow-left"></i> Kembali</a>
        </div>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-md-3 text-center">
                <?php if ($pasien['foto']): ?>
                    <img src="<?= base_url('uploads/pasien/' . $pasien['foto']) ?>" alt="Foto" width="200" height="200" style="object-fit:cover" class="img-thumbnail mb-3">
                <?php else: ?>
                    <div class="bg-secondary d-inline-block p-5 rounded mb-3">
                        <i class="fas fa-user fa-5x text-white"></i>
                    </div>
                <?php endif; ?>
            </div>
            <div class="col-md-9">
                <table class="table table-bordered">
                    <tr>
                        <th width="200">No RM</th>
                        <td><?= $pasien['no_rm'] ?></td>
                    </tr>
                    <tr>
                        <th>Nama</th>
                        <td><?= $pasien['nama'] ?></td>
                    </tr>
                    <tr>
                        <th>Jenis Kelamin</th>
                        <td><?= $pasien['jenis_kelamin'] == 'L' ? 'Laki-laki' : 'Perempuan' ?></td>
                    </tr>
                    <tr>
                        <th>Tanggal Lahir</th>
                        <td><?= date('d/m/Y', strtotime($pasien['tanggal_lahir'])) ?></td>
                    </tr>
                    <tr>
                        <th>Telepon</th>
                        <td><?= $pasien['telepon'] ?></td>
                    </tr>
                    <tr>
                        <th>Alamat</th>
                        <td><?= $pasien['alamat'] ?: '-' ?></td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
</div>
