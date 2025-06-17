<?php
include 'Koneksi.php';

// Ambil data produk dan transaksi untuk dropdown
$produk = $conn->query("SELECT * FROM produk");
$transaksi = $conn->query("SELECT * FROM transaksi");

// Saat form disubmit
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id_produk = $_POST['id_produk'];
    $id_transaksi = $_POST['id_transaksi'];
    $jumlah = $_POST['jumlah'];

    // Ambil harga produk dari database
    $stmt = $conn->prepare("SELECT harga FROM produk WHERE id_produk = ?");
    $stmt->bind_param("i", $id_produk);
    $stmt->execute();
    $stmt->bind_result($harga);
    $stmt->fetch();
    $stmt->close();

    // Hitung subtotal
    $subtotal = $jumlah * $harga;

    // Simpan ke detail_transaksi
    $stmt = $conn->prepare("INSERT INTO detail_transaksi (id_produk, id_transaksi, jumlah, subtotal) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("iiid", $id_produk, $id_transaksi, $jumlah, $subtotal);
    $stmt->execute();

    // Redirect ke tampilan detail
    header('Location: tampilan_detail.php');
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Tambah Detail Transaksi</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <h2>Tambah Detail Transaksi</h2>
    <form method="post">
        <label>Produk:</label>
        <select name="id_produk" required>
            <?php while ($p = $produk->fetch_assoc()): ?>
                <option value="<?= $p['id_produk'] ?>"><?= $p['nama_produk'] ?></option>
            <?php endwhile; ?>
        </select><br><br>

        <label>Transaksi:</label>
        <select name="id_transaksi" required>
            <?php while ($t = $transaksi->fetch_assoc()): ?>
                <option value="<?= $t['id_transaksi'] ?>"><?= $t['tanggal'] ?></option>
            <?php endwhile; ?>
        </select><br><br>

        <label>Jumlah:</label>
        <input type="number" name="jumlah" min="1" required><br><br>

        <button type="submit">Simpan</button>
    </form>

    <br>
    <a href="tampilan_detail.php">Kembali</a>
</body>
</html>
