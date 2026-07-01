<!DOCTYPE html>
<html>
<head>
    <title>Nota Pembayaran</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
    <style>
        @media print {
            .no-print { display: none !important; }
            body { font-size: 12pt; }
        }
        body { font-family: 'Courier New', monospace; }
        .nota-container { max-width: 400px; margin: 20px auto; padding: 20px; border: 1px solid #ddd; }
        .nota-header { text-align: center; border-bottom: 2px solid #333; padding-bottom: 10px; margin-bottom: 15px; }
        .nota-title { font-size: 18pt; font-weight: bold; }
        .nota-info { margin-bottom: 15px; }
        .nota-info table { width: 100%; }
        .nota-info td { padding: 2px 0; }
        .nota-total { border-top: 2px solid #333; padding-top: 10px; margin-top: 10px; text-align: right; font-size: 14pt; font-weight: bold; }
        .nota-footer { text-align: center; margin-top: 20px; font-size: 9pt; color: #666; }
    </style>
</head>
<body>
    <div class="nota-container">
        <div class="nota-header">
            <div class="nota-title">SISTEM KLINIK</div>
            <div>Jl. Kesehatan No. 123</div>
            <div>Telp: (021) 12345678</div>
        </div>

        <div class="nota-info">
            <table>
                <tr><td><strong>No. Nota</strong></td><td>: INV-<?= str_pad($pembayaran['id_bayar'], 4, '0', STR_PAD_LEFT) ?></td></tr>
                <tr><td><strong>Tanggal</strong></td><td>: <?= date('d/m/Y H:i', strtotime($pembayaran['tanggal'])) ?></td></tr>
                <tr><td><strong>No RM</strong></td><td>: <?= $pembayaran['no_rm'] ?></td></tr>
                <tr><td><strong>Pasien</strong></td><td>: <?= $pembayaran['nama_pasien'] ?></td></tr>
                <tr><td><strong>Dokter</strong></td><td>: <?= $pembayaran['nama_dokter'] ?></td></tr>
                <tr><td><strong>Poli</strong></td><td>: <?= $pembayaran['nama_poli'] ?></td></tr>
                <tr><td><strong>Diagnosa</strong></td><td>: <?= $pembayaran['diagnosa'] ?: '-' ?></td></tr>
            </table>
        </div>

        <div class="nota-total">
            Biaya: Rp <?= number_format($pembayaran['biaya'], 0, ',', '.') ?>
        </div>

        <div style="text-align: center; margin-top: 10px;">
            <?php if ($pembayaran['status'] == 'lunas'): ?>
                <span class="badge badge-success" style="font-size: 12pt;">LUNAS</span>
            <?php elseif ($pembayaran['status'] == 'belum'): ?>
                <span class="badge badge-warning" style="font-size: 12pt;">BELUM LUNAS</span>
            <?php else: ?>
                <span class="badge badge-danger" style="font-size: 12pt;">BATAL</span>
            <?php endif; ?>
        </div>

        <div class="nota-footer">
            Terima kasih atas kunjungan Anda<br>
            Barang yang sudah dibeli tidak dapat dikembalikan
        </div>
    </div>

    <div class="text-center no-print mt-3">
        <button class="btn btn-primary" onclick="window.print()"><i class="fas fa-print"></i> Cetak</button>
        <a href="<?= site_url('pembayaran') ?>" class="btn btn-secondary">Kembali</a>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/js/all.min.js"></script>
    <script>
        window.onload = function() {
            // Auto print
        };
    </script>
</body>
</html>
