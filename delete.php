<?php
require_once 'config/koneksi.php';

$db = new Database();
$conn = $db->conn;

if (!isset($_GET['id'])) {
    header("Location: index.php");
    exit();
}

$id = $_GET['id'];

// Cek data ada atau tidak
$cek = $conn->prepare("SELECT id FROM perangkat WHERE id = ?");
$cek->bind_param("i", $id);
$cek->execute();
$cek->store_result();

if ($cek->num_rows == 0) {
    header("Location: index.php");
    exit();
}

// Hapus data
$stmt = $conn->prepare("DELETE FROM perangkat WHERE id = ?");
$stmt->bind_param("i", $id);

if ($stmt->execute()) {
    header("Location: index.php");
    exit();
} else {
    die("Gagal menghapus data: " . $conn->error);
}
?>