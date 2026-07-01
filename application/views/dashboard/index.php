<div class="row">
    <div class="col-lg-4 col-6">
        <div class="small-box bg-info">
            <div class="inner">
                <h3><?= $count_pasien ?></h3>
                <p>Pasien</p>
            </div>
            <div class="icon">
                <i class="fas fa-user-injured"></i>
            </div>
            <a href="<?= site_url('pasien') ?>" class="small-box-footer">Selengkapnya <i class="fas fa-arrow-circle-right"></i></a>
        </div>
    </div>
    <div class="col-lg-4 col-6">
        <div class="small-box bg-success">
            <div class="inner">
                <h3><?= $count_dokter ?></h3>
                <p>Dokter</p>
            </div>
            <div class="icon">
                <i class="fas fa-user-md"></i>
            </div>
            <a href="<?= site_url('dokter') ?>" class="small-box-footer">Selengkapnya <i class="fas fa-arrow-circle-right"></i></a>
        </div>
    </div>
    <div class="col-lg-4 col-6">
        <div class="small-box bg-warning">
            <div class="inner">
                <h3><?= $count_poli ?></h3>
                <p>Poli</p>
            </div>
            <div class="icon">
                <i class="fas fa-hospital"></i>
            </div>
            <a href="<?= site_url('poli') ?>" class="small-box-footer">Selengkapnya <i class="fas fa-arrow-circle-right"></i></a>
        </div>
    </div>
    <div class="col-lg-4 col-6">
        <div class="small-box bg-danger">
            <div class="inner">
                <h3><?= $count_obat ?></h3>
                <p>Obat</p>
            </div>
            <div class="icon">
                <i class="fas fa-capsules"></i>
            </div>
            <a href="<?= site_url('obat') ?>" class="small-box-footer">Selengkapnya <i class="fas fa-arrow-circle-right"></i></a>
        </div>
    </div>
    <div class="col-lg-4 col-6">
        <div class="small-box bg-primary">
            <div class="inner">
                <h3><?= $count_pemeriksaan ?></h3>
                <p>Pemeriksaan</p>
            </div>
            <div class="icon">
                <i class="fas fa-stethoscope"></i>
            </div>
            <a href="<?= site_url('pemeriksaan') ?>" class="small-box-footer">Selengkapnya <i class="fas fa-arrow-circle-right"></i></a>
        </div>
    </div>
    <div class="col-lg-4 col-6">
        <div class="small-box bg-secondary">
            <div class="inner">
                <h3><?= $count_pembayaran ?></h3>
                <p>Pembayaran</p>
            </div>
            <div class="icon">
                <i class="fas fa-money-bill-wave"></i>
            </div>
            <a href="<?= site_url('pembayaran') ?>" class="small-box-footer">Selengkapnya <i class="fas fa-arrow-circle-right"></i></a>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-lg-8">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Grafik Pendaftaran Tahun <?= date('Y') ?></h3>
            </div>
            <div class="card-body">
                <canvas id="chartPendaftaran" style="height: 300px;"></canvas>
            </div>
        </div>
    </div>
    <div class="col-lg-4">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Pendaftaran Terbaru</h3>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-striped table-sm m-0">
                        <thead>
                            <tr>
                                <th>No RM</th>
                                <th>Pasien</th>
                                <th>Dokter</th>
                                <th>Poli</th>
                                <th>Tanggal</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if ($recent_pendaftaran): ?>
                                <?php foreach ($recent_pendaftaran as $p): ?>
                                <tr>
                                    <td><?= $p['no_rm'] ?></td>
                                    <td><?= $p['nama_pasien'] ?></td>
                                    <td><?= $p['nama_dokter'] ?></td>
                                    <td><?= $p['nama_poli'] ?></td>
                                    <td><?= date('d-m-Y', strtotime($p['tanggal'])) ?></td>
                                    <td>
                                        <?php if ($p['status'] == 'selesai'): ?>
                                            <span class="badge badge-success">Selesai</span>
                                        <?php elseif ($p['status'] == 'batal'): ?>
                                            <span class="badge badge-danger">Batal</span>
                                        <?php else: ?>
                                            <span class="badge badge-warning">Menunggu</span>
                                        <?php endif; ?>
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
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
const ctx = document.getElementById('chartPendaftaran').getContext('2d');
new Chart(ctx, {
    type: 'line',
    data: {
        labels: <?= $chart_labels ?>,
        datasets: [{
            label: 'Pendaftaran',
            data: <?= $chart_data ?>,
            borderColor: 'rgb(23, 162, 184)',
            backgroundColor: 'rgba(23, 162, 184, 0.1)',
            tension: 0.3,
            fill: true
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
            legend: { display: false }
        },
        scales: {
            y: {
                beginAtZero: true,
                ticks: { stepSize: 1 }
            }
        }
    }
});
</script>
