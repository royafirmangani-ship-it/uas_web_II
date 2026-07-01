<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title><?= $judul ?></title>
    <style>
        body { font-family: Arial, sans-serif; font-size: 11px; margin: 20px; }
        h2 { text-align: center; margin-bottom: 5px; }
        .filter-info { text-align: center; font-size: 11px; margin-bottom: 15px; color: #555; }
        table { width: 100%; border-collapse: collapse; }
        th { background-color: #007bff; color: #fff; padding: 8px 6px; text-align: left; font-size: 10px; }
        td { padding: 6px; border: 1px solid #ddd; font-size: 10px; }
        tr:nth-child(even) { background-color: #f9f9f9; }
        .footer { margin-top: 20px; font-size: 10px; text-align: right; color: #777; }
        .total-row td { font-weight: bold; background-color: #e9ecef; }
    </style>
</head>
<body>
    <h2><?= $judul ?></h2>
    <div class="filter-info">
        <?php if ($dari && $sampai): ?>
            Periode: <?= date('d/m/Y', strtotime($dari)) ?> s/d <?= date('d/m/Y', strtotime($sampai)) ?>
        <?php else: ?>
            Periode: Semua Tanggal
        <?php endif; ?>
        <?php if ($search): ?> | Pencarian: <?= $search ?><?php endif; ?>
        <?php if ($status !== ''): ?> | Status: <?= ucfirst($status) ?><?php endif; ?>
    </div>
    <table>
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
            <?php if ($rows): ?>
                <?php $no = 1; ?>
                <?php foreach ($rows as $r): ?>
                <tr>
                    <td><?= $no++ ?></td>
                    <td><?= $r['no_rm'] ?></td>
                    <td><?= $r['nama_pasien'] ?></td>
                    <td><?= $r['nama_dokter'] ?></td>
                    <td style="text-align:right">Rp <?= number_format($r['biaya'], 0, ',', '.') ?></td>
                    <td><?= ucfirst($r['status']) ?></td>
                    <td><?= date('d/m/Y H:i', strtotime($r['tanggal'])) ?></td>
                </tr>
                <?php endforeach; ?>
                <tr class="total-row">
                    <td colspan="4" style="text-align:right"><strong>TOTAL</strong></td>
                    <td style="text-align:right"><strong>Rp <?= number_format($total, 0, ',', '.') ?></strong></td>
                    <td colspan="2"></td>
                </tr>
            <?php else: ?>
                <tr><td colspan="7" style="text-align:center">Tidak ada data.</td></tr>
            <?php endif; ?>
        </tbody>
    </table>
    <div class="footer">Dicetak pada: <?= date('d/m/Y H:i:s') ?></div>
</body>
</html>
