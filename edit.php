<?php
require_once 'config/koneksi.php';

$db = new Database();
$conn = $db->conn;

$pesan = "";

// Ambil data berdasarkan ID
if (!isset($_GET['id'])) {
    header("Location: index.php");
    exit();
}

$id = $_GET['id'];

$stmt = $conn->prepare("SELECT * FROM perangkat WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$data = $result->fetch_assoc();

if (!$data) {
    header("Location: index.php");
    exit();
}

// Proses update
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $type  = $_POST['type'];
    $sn    = $_POST['sn'];
    $jenis = $_POST['jenis'];

    // Cek SN sudah dipakai perangkat LAIN
    $cek = $conn->prepare("SELECT id FROM perangkat WHERE sn = ? AND id != ?");
    $cek->bind_param("si", $sn, $id);
    $cek->execute();
    $cek->store_result();

    if ($cek->num_rows > 0) {
        $pesan = "Serial Number '$sn' sudah digunakan perangkat lain!";
    } else {
        $stmt = $conn->prepare("UPDATE perangkat SET type=?, sn=?, jenis=? WHERE id=?");
        $stmt->bind_param("sssi", $type, $sn, $jenis, $id);

        if ($stmt->execute()) {
            header("Location: index.php");
            exit();
        } else {
            $pesan = "Gagal mengupdate data: " . $conn->error;
        }
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Edit Perangkat</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 30px; }
        input { width: 100%; padding: 8px; margin: 6px 0 16px 0; box-sizing: border-box; }
        label { font-weight: bold; }
        .btn { padding: 8px 16px; color: white; border: none; cursor: pointer; border-radius: 4px; }
        .btn-simpan { background-color: #2196F3; }
        .btn-batal { background-color: #9E9E9E; text-decoration: none; }
        .error { color: red; }
    </style>
</head>
<body>

<h2>Edit Data Perangkat</h2>

<?php if ($pesan): ?>
    <p class="error"><?= $pesan ?></p>
<?php endif; ?>

<form method="POST">
    <label>Type</label>
    <input type="text" name="type" value="<?= htmlspecialchars($data['type']) ?>" required>

    <label>Serial Number (SN)</label>
    <input type="text" name="sn" value="<?= htmlspecialchars($data['sn']) ?>" required>

    <label>Jenis</label>
    <input type="text" name="jenis" value="<?= htmlspecialchars($data['jenis']) ?>" required>

    <button type="submit" class="btn btn-simpan">Update</button>
    <a href="index.php" class="btn btn-batal">Batal</a>
</form>

</body>
</htm