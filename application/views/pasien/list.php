<div class="card">
    <div class="card-header">
        <h3 class="card-title">Data Pasien</h3>
        <div class="card-tools">
            <a href="<?= site_url('pasien/create') ?>" class="btn btn-primary btn-sm">
                <i class="fas fa-plus"></i> Tambah Pasien
            </a>
        </div>
    </div>
    <div class="card-body">
        <?php if ($this->session->flashdata('success')): ?>
            <div class="alert alert-success alert-dismissible">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                <?= $this->session->flashdata('success') ?>
            </div>
        <?php endif; ?>
        <?php if ($this->session->flashdata('error')): ?>
            <div class="alert alert-danger alert-dismissible">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                <?= $this->session->flashdata('error') ?>
            </div>
        <?php endif; ?>

        <form action="<?= site_url('pasien') ?>" method="GET" class="form-inline mb-3">
            <div class="input-group input-group-sm">
                <input type="text" name="search" class="form-control" placeholder="Cari nama / no RM / telepon..." value="<?= set_value('search', $search) ?>">
                <div class="input-group-append">
                    <button type="submit" class="btn btn-secondary"><i class="fas fa-search"></i></button>
                </div>
            </div>
        </form>

        <div class="table-responsive">
            <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>No RM</th>
                        <th>Nama</th>
                        <th>Jenis Kelamin</th>
                        <th>Tanggal Lahir</th>
                        <th>Telepon</th>
                        <th>Foto</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $no = $this->input->get('per_page') ? (int)$this->input->get('per_page') + 1 : 1; ?>
                    <?php foreach ($pasien as $p): ?>
                    <tr>
                        <td><?= $no++ ?></td>
                        <td><?= $p['no_rm'] ?></td>
                        <td><?= $p['nama'] ?></td>
                        <td><?= $p['jenis_kelamin'] == 'L' ? 'Laki-laki' : 'Perempuan' ?></td>
                        <td><?= date('d/m/Y', strtotime($p['tanggal_lahir'])) ?></td>
                        <td><?= $p['telepon'] ?></td>
                        <td>
                            <?php if ($p['foto']): ?>
                                <img src="<?= base_url('uploads/pasien/' . $p['foto']) ?>" alt="Foto" width="50" height="50" style="object-fit:cover" class="img-thumbnail">
                            <?php else: ?>
                                <span class="text-muted">-</span>
                            <?php endif; ?>
                        </td>
                        <td>
                            <a href="<?= site_url('pasien/detail/' . $p['id_pasien']) ?>" class="btn btn-info btn-sm" title="Detail"><i class="fas fa-eye"></i></a>
                            <a href="<?= site_url('pasien/edit/' . $p['id_pasien']) ?>" class="btn btn-warning btn-sm" title="Edit"><i class="fas fa-edit"></i></a>
                            <a href="<?= site_url('pasien/delete/' . $p['id_pasien']) ?>" class="btn btn-danger btn-sm" onclick="return confirm('Yakin ingin menghapus data ini?')" title="Hapus"><i class="fas fa-trash"></i></a>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                    <?php if (empty($pasien)): ?>
                    <tr>
                        <td colspan="8" class="text-center">Data tidak ditemukan.</td>
                    </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>

        <?= $pagination ?>
    </div>
</div>
