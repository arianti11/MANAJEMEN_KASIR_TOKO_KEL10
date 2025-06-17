<?php
include 'Koneksi.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nama = $_POST['nama_produk'];
    $harga = $_POST['harga'];

    $stmt = $conn->prepare("INSERT INTO produk (nama_produk, harga) VALUES (?, ?)");
    $stmt->bind_param("sd", $nama, $harga);
    $stmt->execute();

    header('Location: index.php');
    exit();
}
?>
<!DOCTYPE html>
<html>
<head><title>Tambah Produk</title></head>
<link rel="stylesheet" href="style.css">
<body>
<h2>Tambah Produk</h2>
<form method="post">
    Nama Produk: <input type="text" name="nama_produk" required><br>
    Harga: <input type="number" step="0.01" name="harga" required><br>
    <button type="submit">Simpan</button>
</form>
<a href="index.php">Kembali</a>
</body>
</html>