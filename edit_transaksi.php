<?php
include 'Koneksi.php';

$id = $_GET['id'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $tanggal = $_POST['tanggal'];
    $total_bayar = $_POST['total_bayar'];

    $stmt = $conn->prepare("UPDATE transaksi SET tanggal=?, total_bayar=? WHERE id_transaksi=?");
    $stmt->bind_param("sdi", $tanggal, $total_bayar, $id);
    $stmt->execute();

    header('Location: index.php');
    exit();
}

$result = $conn->query("SELECT * FROM transaksi WHERE id_transaksi = $id");
$data = $result->fetch_assoc();
?>
<!DOCTYPE html>
<html>
<head><title>Edit Transaksi</title></head>
<body>
<h2>Edit Transaksi</h2>
<form method="post">
    Tanggal: <input type="date" name="tanggal" value="<?= $data['tanggal'] ?>" required><br>
    Total Bayar: <input type="number" step="0.01" name="total_bayar" value="<?= $data['total_bayar'] ?>" required><br>
    <button type="submit">Update</button>
</form>
<a href="index.php">Kembali</a>
</body>
</html>