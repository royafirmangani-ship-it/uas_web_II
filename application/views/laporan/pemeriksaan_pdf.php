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
    </div>
    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>No RM</th>
                <th>Pasien</th>
                <th>Dokter</th>
                <th>Poli</th>
                <th>Tanggal Daftar</th>
                <th>Diagnosa</th>
                <th>Tindakan</th>
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
                    <td><?= $r['nama_poli'] ?></td>
                    <td><?= date('d/m/Y H:i', strtotime($r['tgl_daftar'])) ?></td>
                    <td><?= $r['diagnosa'] ?></td>
                    <td><?= $r['tindakan'] ?></td>
                </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr><td colspan="8" style="text-align:center">Tidak ada data.</td></tr>
            <?php endif; ?>
        </tbody>
    </table>
    <div class="footer">Dicetak pada: <?= date('d/m/Y H:i:s') ?></div>
</body>
</html>
