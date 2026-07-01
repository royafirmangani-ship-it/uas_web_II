<div class="card">
    <div class="card-header">
        <h3 class="card-title">Data Poli</h3>
        <div class="card-tools">
            <a href="<?= site_url('poli/create') ?>" class="btn btn-primary btn-sm">
                <i class="fas fa-plus"></i> Tambah Poli
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

        <form method="get" action="<?= site_url('poli/index') ?>" class="mb-3">
            <div class="input-group">
                <input type="text" name="search" class="form-control" placeholder="Cari nama poli..." value="<?= set_value('search', isset($search) ? $search : '') ?>">
                <div class="input-group-append">
                    <button class="btn btn-default" type="submit">
                        <i class="fas fa-search"></i> Cari
                    </button>
                </div>
            </div>
        </form>

        <div class="table-responsive">
            <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th width="50">No</th>
                        <th>Nama Poli</th>
                        <th width="150">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($poli)): ?>
                        <?php $no = $this->input->get('per_page') ? (int)$this->input->get('per_page') + 1 : 1; ?>
                        <?php foreach ($poli as $row): ?>
                            <tr>
                                <td><?= $no++ ?></td>
                                <td><?= $row['nama_poli'] ?></td>
                                <td>
                                    <a href="<?= site_url('poli/edit/' . $row['id_poli']) ?>" class="btn btn-warning btn-sm">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <a href="<?= site_url('poli/delete/' . $row['id_poli']) ?>" class="btn btn-danger btn-sm" onclick="return confirm('Yakin ingin menghapus data ini?')">
                                        <i class="fas fa-trash"></i>
                                    </a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="3" class="text-center">Tidak ada data</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>

        <?php if (isset($pagination)): ?>
            <?= $pagination ?>
        <?php endif; ?>
    </div>
</div>
