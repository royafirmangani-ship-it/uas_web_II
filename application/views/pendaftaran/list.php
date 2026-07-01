<div class="card">
    <div class="card-header">
        <h3 class="card-title">Data Pendaftaran</h3>
        <div class="card-tools">
            <a href="<?= site_url('pendaftaran/create') ?>" class="btn btn-primary btn-sm">
                <i class="fas fa-plus"></i> Tambah Pendaftaran
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

        <form method="get" action="<?= site_url('pendaftaran/index') ?>" class="mb-3">
            <div class="row">
                <div class="col-md-4">
                    <div class="input-group">
                        <input type="text" name="search" class="form-control" placeholder="Cari pasien atau dokter..." value="<?= set_value('search', $search) ?>">
                        <div class="input-group-append">
                            <button class="btn btn-default" type="submit"><i class="fas fa-search"></i></button>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <select name="status" class="form-control" onchange="this.form.submit()">
                        <option value="">Semua Status</option>
                        <option value="Menunggu" <?= set_value('status', $status) == 'Menunggu' ? 'selected' : '' ?>>Menunggu</option>
                        <option value="Diperiksa" <?= set_value('status', $status) == 'Diperiksa' ? 'selected' : '' ?>>Diperiksa</option>
                        <option value="Selesai" <?= set_value('status', $status) == 'Selesai' ? 'selected' : '' ?>>Selesai</option>
                    </select>
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
                        <th>Tanggal</th>
                        <th>Keluhan</th>
                        <th width="12%">Status</th>
                        <th width="20%">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if ($pendaftaran): ?>
                        <?php $no = $this->uri->segment(3) ? (int)$this->uri->segment(3) + 1 : 1; ?>
                        <?php foreach ($pendaftaran as $p): ?>
                        <tr>
                            <td><?= $no++ ?></td>
                            <td><?= $p['no_rm'] ?></td>
                            <td><?= $p['nama_pasien'] ?></td>
                            <td><?= $p['nama_dokter'] ?></td>
                            <td><?= $p['nama_poli'] ?></td>
                            <td><?= date('d/m/Y H:i', strtotime($p['tanggal'])) ?></td>
                            <td><?= character_limiter($p['keluhan'], 30) ?></td>
                            <td>
                                <?php if ($p['status'] == 'Menunggu'): ?>
                                    <span class="badge badge-warning">Menunggu</span>
                                <?php elseif ($p['status'] == 'Diperiksa'): ?>
                                    <span class="badge badge-info">Diperiksa</span>
                                <?php else: ?>
                                    <span class="badge badge-success">Selesai</span>
                                <?php endif; ?>
                            </td>
                            <td>
                                <a href="<?= site_url('pendaftaran/detail/' . $p['id_daftar']) ?>" class="btn btn-info btn-sm" title="Detail">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <a href="<?= site_url('pendaftaran/edit/' . $p['id_daftar']) ?>" class="btn btn-warning btn-sm" title="Edit">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <a href="<?= site_url('pendaftaran/delete/' . $p['id_daftar']) ?>" class="btn btn-danger btn-sm" title="Hapus" onclick="return confirm('Yakin ingin menghapus pendaftaran ini?')">
                                    <i class="fas fa-trash"></i>
                                </a>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="9" class="text-center">Tidak ada data</td>
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
