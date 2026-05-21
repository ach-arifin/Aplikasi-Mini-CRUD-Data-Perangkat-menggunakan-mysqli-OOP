<?php
require_once 'config/koneksi.php';

$db = new Database();
$conn = $db->conn;

$pesan = "";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $type  = $_POST['type'];
    $sn    = $_POST['sn'];
    $jenis = $_POST['jenis'];

    // Cek apakah SN sudah ada
    $cek = $conn->prepare("SELECT id FROM perangkat WHERE sn = ?");
    $cek->bind_param("s", $sn);
    $cek->execute();
    $cek->store_result();

    if ($cek->num_rows > 0) {
        $pesan = "Serial Number '$sn' sudah digunakan, gunakan SN lain!";
    } else {
        $stmt = $conn->prepare("INSERT INTO perangkat (type, sn, jenis) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $type, $sn, $jenis);

        if ($stmt->execute()) {
            header("Location: index.php");
            exit();
        } else {
            $pesan = "Gagal menambahkan data: " . $conn->error;
        }
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Tambah Perangkat</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 30px; }
        input { width: 100%; padding: 8px; margin: 6px 0 16px 0; box-sizing: border-box; }
        label { font-weight: bold; }
        .btn { padding: 8px 16px; color: white; border: none; cursor: pointer; border-radius: 4px; }
        .btn-simpan { background-color: #4CAF50; }
        .btn-batal { background-color: #9E9E9E; text-decoration: none; }
        .error { color: red; }
    </style>
</head>
<body>

<h2>Tambah Data Perangkat</h2>

<?php if ($pesan): ?>
    <p class="error"><?= $pesan ?></p>
<?php endif; ?>

<form method="POST">
    <label>Type</label>
    <input type="text" name="type" placeholder="contoh: Laptop" required>

    <label>Serial Number (SN)</label>
    <input type="text" name="sn" placeholder="contoh: SN-LPT-004" required>

    <label>Jenis</label>
    <input type="text" name="jenis" placeholder="contoh: Hardware" required>

    <button type="submit" class="btn btn-simpan">Simpan</button>
    <a href="index.php" class="btn btn-batal">Batal</a>
</form>

</body>
</html>