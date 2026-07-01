<div class="card card-outline card-primary">
    <div class="card-header">
        <h3 class="card-title">Laporan Data Pembayaran</h3>
        <div class="card-tools">
            <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
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

        <form method="get" action="<?= site_url('laporan/pembayaran') ?>" class="mb-3">
            <div class="form-row">
                <div class="col-md-2 mb-2">
                    <label>Dari Tanggal</label>
                    <input type="date" name="dari_tanggal" class="form-control" value="<?= set_value('dari_tanggal', $dari_tanggal) ?>">
                </div>
                <div class="col-md-2 mb-2">
                    <label>Sampai Tanggal</label>
                    <input type="date" name="sampai_tanggal" class="form-control" value="<?= set_value('sampai_tanggal', $sampai_tanggal) ?>">
                </div>
                <div class="col-md-3 mb-2">
                    <label>Cari Pasien</label>
                    <input type="text" name="search" class="form-control" placeholder="Cari..." value="<?= set_value('search', $search) ?>">
                </div>
                <div class="col-md-2 mb-2">
                    <label>Status</label>
                    <select name="status" class="form-control">
                        <option value="">-- Semua --</option>
                        <option value="lunas" <?= set_value('status', $status) == 'lunas' ? 'selected' : '' ?>>Lunas</option>
                        <option value="belum" <?= set_value('status', $status) == 'belum' ? 'selected' : '' ?>>Belum</option>
                        <option value="batal" <?= set_value('status', $status) == 'batal' ? 'selected' : '' ?>>Batal</option>
                    </select>
                </div>
                <div class="col-md-2 mb-2 d-flex align-items-end">
                    <button type="submit" class="btn btn-primary btn-block"><i class="fas fa-filter"></i> Filter</button>
                </div>
            </div>
        </form>

        <form method="post" action="<?= site_url('laporan/pembayaran') ?>" class="mb-3">
            <input type="hidden" name="dari_tanggal" value="<?= $dari_tanggal ?>">
            <input type="hidden" name="sampai_tanggal" value="<?= $sampai_tanggal ?>">
            <input type="hidden" name="search" value="<?= $search ?>">
            <input type="hidden" name="status" value="<?= $status ?>">
            <div class="btn-group">
                <button type="submit" name="export_pdf" value="1" class="btn btn-danger btn-sm"><i class="fas fa-file-pdf"></i> PDF</button>
                <button type="submit" name="export_excel" value="1" class="btn btn-success btn-sm"><i class="fas fa-file-excel"></i> Excel</button>
                <button type="submit" name="print" value="1" class="btn btn-info btn-sm"><i class="fas fa-print"></i> Print</button>
            </div>
        </form>

        <div class="table-responsive">
            <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>No RM</th>
                        <th>Pasien</th>
                        <th>Dokter</th>
                        <th>Biaya</th>
                        <th>Status</th>
                        <th>Tanggal Bayar</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $no = $this->input->get('per_page') ? (int)$this->input->get('per_page') + 1 : 1; ?>
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
                        <td><?= date('d/m/Y H:i', strtotime($p['tanggal'])) ?></td>
                    </tr>
                    <?php endforeach; ?>
                    <?php if (empty($pembayaran)): ?>
                    <tr>
                        <td colspan="7" class="text-center">Data tidak ditemukan.</td>
                    </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>

        <?= $pagination ?>
    </div>
</div>
