<?php
include 'Koneksi.php';

$id = $_GET['id'];
$produk = $conn->query("SELECT * FROM produk");
$transaksi = $conn->query("SELECT * FROM transaksi");
$detail = $conn->query("SELECT * FROM detail_transaksi WHERE id_detail_transaksi = $id")->fetch_assoc();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id_produk = $_POST['id_produk'];
    $id_transaksi = $_POST['id_transaksi'];
    $jumlah = $_POST['jumlah'];
    $subtotal = $_POST['subtotal'];

    $stmt = $conn->prepare("UPDATE detail_transaksi SET id_produk=?, id_transaksi=?, jumlah=?, subtotal=? WHERE id_detail_transaksi=?");
    $stmt->bind_param("iiidi", $id_produk, $id_transaksi, $jumlah, $subtotal, $id);
    $stmt->execute();

    header('Location: index.php');
    exit();
}
?>
<!DOCTYPE html>
<html>
<head><title>Edit Detail Transaksi</title></head>
<body>
<h2>Edit Detail Transaksi</h2>
<form method="post">
    Produk: <select name="id_produk">
        <?php while ($p = $produk->fetch_assoc()): ?>
            <option value="<?= $p['id_produk'] ?>" <?= $p['id_produk'] == $detail['id_produk'] ? 'selected' : '' ?>><?= $p['nama_produk'] ?></option>
        <?php endwhile; ?>
    </select><br>
    Transaksi: <select name="id_transaksi">
        <?php while ($t = $transaksi->fetch_assoc()): ?>
            <option value="<?= $t['id_transaksi'] ?>" <?= $t['id_transaksi'] == $detail['id_transaksi'] ? 'selected' : '' ?>><?= $t['tanggal'] ?></option>
        <?php endwhile; ?>
    </select><br>
    Jumlah: <input type="number" name="jumlah" value="<?= $detail['jumlah'] ?>" required><br>
    Subtotal: <input type="number" step="0.01" name="subtotal" value="<?= $detail['subtotal'] ?>" required><br>
    <button type="submit">Update</button>
</form>
<a href="index.php">Kembali</a>
</body>
</html>
