<?php
include 'Koneksi.php';

$produk = $conn->query("SELECT * FROM produk");
$transaksi = $conn->query("SELECT * FROM transaksi");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id_produk = $_POST['id_produk'];
    $id_transaksi = $_POST['id_transaksi'];
    $jumlah = $_POST['jumlah'];
    $subtotal = $_POST['subtotal'];

    $stmt = $conn->prepare("INSERT INTO detail_transaksi (id_produk, id_transaksi, jumlah, subtotal) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("iiid", $id_produk, $id_transaksi, $jumlah, $subtotal);
    $stmt->execute();

    header('Location: index.php');
    exit();
}
?>
<!DOCTYPE html>
<html>
<head><title>Tambah Detail Transaksi</title></head>
<body>
<h2>Tambah Detail Transaksi</h2>
<form method="post">
    Produk: <select name="id_produk">
        <?php while ($p = $produk->fetch_assoc()): ?>
            <option value="<?= $p['id_produk'] ?>"><?= $p['nama_produk'] ?></option>
        <?php endwhile; ?>
    </select><br>
    Transaksi: <select name="id_transaksi">
        <?php while ($t = $transaksi->fetch_assoc()): ?>
            <option value="<?= $t['id_transaksi'] ?>"><?= $t['tanggal'] ?></option>
        <?php endwhile; ?>
    </select><br>
    Jumlah: <input type="number" name="jumlah" required><br>
    Subtotal: <input type="number" step="0.01" name="subtotal" required><br>
    <button type="submit">Simpan</button>
</form>
<a href="index.php">Kembali</a>


</body>
</html>