<div class="card">
    <div class="card-header">
        <h3 class="card-title">Data Resep</h3>
        <div class="card-tools">
            <a href="<?= site_url('resep/create') ?>" class="btn btn-primary btn-sm">
                <i class="fas fa-plus"></i> Tambah Resep
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

        <form method="get" action="<?= site_url('resep/index') ?>" class="mb-3">
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
                        <th>Tanggal Periksa</th>
                        <th>Tanggal Resep</th>
                        <th width="10%">Jumlah Obat</th>
                        <th width="20%">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if ($resep): ?>
                        <?php $no = $this->uri->segment(3) ? (int)$this->uri->segment(3) + 1 : 1; ?>
                        <?php foreach ($resep as $r): ?>
                        <tr>
                            <td><?= $no++ ?></td>
                            <td><?= $r['no_rm'] ?></td>
                            <td><?= $r['nama_pasien'] ?></td>
                            <td><?= date('d-m-Y', strtotime($r['tgl_periksa'])) ?></td>
                            <td><?= date('d-m-Y H:i', strtotime($r['tanggal'])) ?></td>
                            <td class="text-center"><?= $r['jumlah_obat'] ?></td>
                            <td>
                                <a href="<?= site_url('resep/detail/' . $r['id_resep']) ?>" class="btn btn-info btn-sm" title="Detail">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <a href="<?= site_url('resep/edit/' . $r['id_resep']) ?>" class="btn btn-warning btn-sm" title="Edit">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <a href="<?= site_url('resep/delete/' . $r['id_resep']) ?>" class="btn btn-danger btn-sm" title="Hapus" onclick="return confirm('Yakin ingin menghapus resep ini?')">
                                    <i class="fas fa-trash"></i>
                                </a>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="7" class="text-center">Tidak ada data</td>
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
