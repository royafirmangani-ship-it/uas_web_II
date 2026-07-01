<div class="card">
    <div class="card-header">
        <h3 class="card-title">Data Pemeriksaan</h3>
        <div class="card-tools">
            <a href="<?= site_url('pemeriksaan/create') ?>" class="btn btn-primary btn-sm">
                <i class="fas fa-plus"></i> Tambah Pemeriksaan
            </a>
        </div>
    </div>
    <div class="card-body">
        <?php if ($this->session->flashdata('success')): ?>
            <div class="alert alert-success alert-dismissible fade show">
                <?= $this->session->flashdata('success') ?>
                <button type="button" class="close" data-dismiss="alert">&times;</button>
            </div>
        <?php endif; ?>
        <?php if ($this->session->flashdata('error')): ?>
            <div class="alert alert-danger alert-dismissible fade show">
                <?= $this->session->flashdata('error') ?>
                <button type="button" class="close" data-dismiss="alert">&times;</button>
            </div>
        <?php endif; ?>

        <form method="get" action="<?= site_url('pemeriksaan/index') ?>" class="mb-3">
            <div class="input-group" style="max-width: 300px;">
                <input type="text" name="search" class="form-control" placeholder="Cari pasien..." value="<?= set_value('search', $search) ?>">
                <div class="input-group-append">
                    <button class="btn btn-default" type="submit"><i class="fas fa-search"></i></button>
                </div>
            </div>
        </form>

        <div class="table-responsive">
            <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th width="5%">No</th>
                        <th>No RM</th>
                        <th>Pasien</th>
                        <th>Dokter</th>
                        <th>Poli</th>
                        <th>Tanggal Daftar</th>
                        <th>Diagnosa</th>
                        <th width="20%">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if ($pemeriksaan): ?>
                        <?php $no = $this->uri->segment(3) ? (int)$this->uri->segment(3) + 1 : 1; ?>
                        <?php foreach ($pemeriksaan as $p): ?>
                        <tr>
                            <td><?= $no++ ?></td>
                            <td><?= $p['no_rm'] ?></td>
                            <td><?= $p['nama_pasien'] ?></td>
                            <td><?= $p['nama_dokter'] ?></td>
                            <td><?= $p['nama_poli'] ?></td>
                            <td><?= date('d/m/Y H:i', strtotime($p['tgl_daftar'])) ?></td>
                            <td><?= character_limiter($p['diagnosa'], 30) ?></td>
                            <td>
                                <a href="<?= site_url('pemeriksaan/detail/' . $p['id_periksa']) ?>" class="btn btn-info btn-sm" title="Detail">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <a href="<?= site_url('pemeriksaan/edit/' . $p['id_periksa']) ?>" class="btn btn-warning btn-sm" title="Edit">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <a href="<?= site_url('pemeriksaan/delete/' . $p['id_periksa']) ?>" class="btn btn-danger btn-sm" title="Hapus" onclick="return confirm('Yakin ingin menghapus pemeriksaan ini?')">
                                    <i class="fas fa-trash"></i>
                                </a>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="8" class="text-center">Tidak ada data</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>

        <div class="mt-3">
            <?= $pagination ?>
        </div>
    </div>
</div>
