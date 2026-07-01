<div class="card">
    <div class="card-header">
        <h3 class="card-title">Data User</h3>
        <div class="card-tools">
            <a href="<?= site_url('user/create') ?>" class="btn btn-primary btn-sm">
                <i class="fas fa-plus"></i> Tambah User
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

        <form method="get" action="<?= site_url('user/index') ?>" class="mb-3">
            <div class="input-group" style="max-width: 300px;">
                <input type="text" name="search" class="form-control" placeholder="Cari nama atau username..." value="<?= set_value('search', $search) ?>">
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
                        <th>Nama</th>
                        <th>Username</th>
                        <th width="15%">Role</th>
                        <th width="15%">Tanggal Dibuat</th>
                        <th width="20%">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if ($users): ?>
                        <?php $no = $this->uri->segment(3) ? (int)$this->uri->segment(3) + 1 : 1; ?>
                        <?php foreach ($users as $u): ?>
                        <tr>
                            <td><?= $no++ ?></td>
                            <td><?= $u['nama'] ?></td>
                            <td><?= $u['username'] ?></td>
                            <td>
                                <?php if ($u['role'] == 'admin'): ?>
                                    <span class="badge badge-danger">Admin</span>
                                <?php else: ?>
                                    <span class="badge badge-info">Petugas</span>
                                <?php endif; ?>
                            </td>
                            <td><?= date('d-m-Y H:i', strtotime($u['created_at'])) ?></td>
                            <td>
                                <a href="<?= site_url('user/detail/' . $u['id_user']) ?>" class="btn btn-info btn-sm" title="Detail">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <a href="<?= site_url('user/edit/' . $u['id_user']) ?>" class="btn btn-warning btn-sm" title="Edit">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <a href="<?= site_url('user/delete/' . $u['id_user']) ?>" class="btn btn-danger btn-sm" title="Hapus" onclick="return confirm('Yakin ingin menghapus user ini?')">
                                    <i class="fas fa-trash"></i>
                                </a>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="6" class="text-center">Tidak ada data</td>
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
