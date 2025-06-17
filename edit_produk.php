<?php
include 'Koneksi.php';

$id = $_GET['id'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nama = $_POST['nama_produk'];
    $harga = $_POST['harga'];

    $stmt = $conn->prepare("UPDATE produk SET nama_produk=?, harga=? WHERE id_produk=?");
    $stmt->bind_param("sdi", $nama, $harga, $id);
    $stmt->execute();

    header('Location: index.php');
    exit();
}

$result = $conn->query("SELECT * FROM produk WHERE id_produk = $id");
$data = $result->fetch_assoc();
?>
<!DOCTYPE html>
<html>
<head><title>Edit Produk</title></head>
<body>
<h2>Edit Produk</h2>
<form method="post">
    Nama Produk: <input type="text" name="nama_produk" value="<?= $data['nama_produk'] ?>" required><br>
    Harga: <input type="number" step="0.01" name="harga" value="<?= $data['harga'] ?>" required><br>
    <button type="submit">Update</button>
</form>
<a href="index.php">Kembali</a>
</body>
</html>