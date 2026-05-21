<?php
require_once 'config/koneksi.php';

$db = new Database();
$conn = $db->conn;

$result = $conn->query("SELECT * FROM perangkat ORDER BY id DESC");
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Data Perangkat</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 30px; }
        table { border-collapse: collapse; width: 100%; }
        th, td { border: 1px solid #ccc; padding: 10px; text-align: left; }
        th { background-color: #4CAF50; color: white; }
        tr:nth-child(even) { background-color: #f2f2f2; }
        a { text-decoration: none; }
        .btn { padding: 6px 12px; border-radius: 4px; color: white; }
        .btn-tambah { background-color: #4CAF50; }
        .btn-edit { background-color: #2196F3; }
        .btn-hapus { background-color: #f44336; }
    </style>
</head>
<body>

<h2>Data Perangkat</h2>
<a href="create.php" class="btn btn-tambah">+ Tambah Data</a>
<br><br>

<table>
    <thead>
        <tr>
            <th>No</th>
            <th>Type</th>
            <th>Serial Number</th>
            <th>Jenis</th>
            <th>Aksi</th>
        </tr>
    </thead>
    <tbody>
        <?php if ($result->num_rows > 0): ?>
            <?php $no = 1; while ($row = $result->fetch_assoc()): ?>
            <tr>
                <td><?= $no++ ?></td>
                <td><?= htmlspecialchars($row['type']) ?></td>
                <td><?= htmlspecialchars($row['sn']) ?></td>
                <td><?= htmlspecialchars($row['jenis']) ?></td>
                <td>
                    <a href="edit.php?id=<?= $row['id'] ?>" class="btn btn-edit">Edit</a>
                    <a href="delete.php?id=<?= $row['id'] ?>" class="btn btn-hapus"
                       onclick="return confirm('Yakin hapus data ini?')">Hapus</a>
                </td>
            </tr>
            <?php endwhile; ?>
        <?php else: ?>
            <tr>
                <td colspan="5" style="text-align:center">Belum ada data</td>
            </tr>
        <?php endif; ?>
    </tbody>
</table>

</body>
</html>