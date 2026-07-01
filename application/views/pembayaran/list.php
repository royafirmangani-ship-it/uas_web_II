<div class="card">
    <div class="card-header">
        <h3 class="card-title">Data Pembayaran</h3>
        <div class="card-tools">
            <a href="<?= site_url('pembayaran/create') ?>" class="btn btn-primary btn-sm">
                <i class="fas fa-plus"></i> Tambah Pembayaran
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

        <form method="get" action="<?= site_url('pembayaran/index') ?>" class="mb-3">
            <div class="row">
                <div class="col-md-4">
                    <div class="input-group">
                        <input type="text" name="search" class="form-control" placeholder="Cari pasien..." value="<?= set_value('search', $search) ?>">
                        <div class="input-group-append">
                            <button class="btn btn-default" type="submit"><i class="fas fa-search"></i></button>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <select name="status" class="form-control" onchange="this.form.submit()">
                        <option value="">-- Semua Status --</option>
                        <option value="lunas" <?= set_value('status', $status_filter) == 'lunas' ? 'selected' : '' ?>>Lunas</option>
                        <option value="belum" <?= set_value('status', $status_filter) == 'belum' ? 'selected' : '' ?>>Belum</option>
                        <option value="batal" <?= set_value('status', $status_filter) == 'batal' ? 'selected' : '' ?>>Batal</option>
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
                        <th>Biaya</th>
                        <th width="10%">Status</th>
                        <th>Tanggal</th>
                        <th width="25%">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if ($pembayaran): ?>
                        <?php $no = $this->uri->segment(3) ? (int)$this->uri->segment(3) + 1 : 1; ?>
                        <?php foreach ($pembayaran as $p): ?>
                        <tr>
                            <td><?= $no++ ?></td>
                            <td><?= $p['no_rm'] ?></td>
                            <td><?= $p['nama_pasien'] ?></td>
                            <td><?= $p['nama_dokter'] ?></td>
                            <td>Rp <?= number_format($p['biaya'], 0, ',', '.') ?></td>
                            <td>
                                <?php if ($p['status'] == 'lunas'): ?>
                                    <span class="badge badge-success">Lunas</span>
                                <?php elseif ($p['status'] == 'belum'): ?>
                                    <span class="badge badge-warning">Belum</span>
                                <?php else: ?>
                                    <span class="badge badge-danger">Batal</span>
                                <?php endif; ?>
                            </td>
                            <td><?= date('d-m-Y', strtotime($p['tanggal'])) ?></td>
                            <td>
                                <a href="<?= site_url('pembayaran/detail/' . $p['id_bayar']) ?>" class="btn btn-info btn-sm" title="Detail">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <a href="<?= site_url('pembayaran/nota/' . $p['id_bayar']) ?>" class="btn btn-secondary btn-sm" title="Nota" target="_blank">
                                    <i class="fas fa-print"></i>
                                </a>
                                <a href="<?= site_url('pembayaran/edit/' . $p['id_bayar']) ?>" class="btn btn-warning btn-sm" title="Edit">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <a href="<?= site_url('pembayaran/delete/' . $p['id_bayar']) ?>" class="btn btn-danger btn-sm" title="Hapus" onclick="return confirm('Yakin ingin menghapus pembayaran ini?')">
                                    <i class="fas fa-trash"></i>
                                </a>
                                <?php if ($p['status'] == 'belum'): ?>
                                    <a href="<?= site_url('pembayaran/lunas/' . $p['id_bayar']) ?>" class="btn btn-success btn-sm" title="Lunas" onclick="return confirm('Tandai sebagai LUNAS?')">
                                        <i class="fas fa-check"></i>
                                    </a>
                                    <a href="<?= site_url('pembayaran/batal/' . $p['id_bayar']) ?>" class="btn btn-danger btn-sm" title="Batal" onclick="return confirm('Batalkan pembayaran ini?')">
                                        <i class="fas fa-times"></i>
                                    </a>
                                <?php endif; ?>
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
