<?php
include 'Koneksi.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $tanggal = $_POST['tanggal'];
    $total_bayar = $_POST['total_bayar'];

    $stmt = $conn->prepare("INSERT INTO transaksi (tanggal, total_bayar) VALUES (?, ?)");
    $stmt->bind_param("sd", $tanggal, $total_bayar);
    $stmt->execute();

    header('Location: index.php');
    exit();
}
?>
<!DOCTYPE html>
<html>
<head><title>Tambah Transaksi</title></head>
<body>
<h2>Tambah Transaksi</h2>
<form method="post">
    Tanggal: <input type="date" name="tanggal" required><br>
    Total Bayar: <input type="number" step="0.01" name="total_bayar" required><br>
    <button type="submit">Simpan</button>
</form>
<a href="index.php">Kembali</a>
</body>
</html>
