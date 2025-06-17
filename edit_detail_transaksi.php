<?php
include 'Koneksi.php';

$id = $_GET['id'];

// Ambil data produk dan transaksi untuk dropdown
$produk = $conn->query("SELECT * FROM produk");
$transaksi = $conn->query("SELECT * FROM transaksi");

// Ambil data detail_transaksi yang akan diedit
$stmt = $conn->prepare("
    SELECT id_produk, id_transaksi, jumlah 
    FROM detail_transaksi 
    WHERE id_detail_transaksi = ?
");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$data = $result->fetch_assoc();
$stmt->close();

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

    // Hitung ulang subtotal
    $subtotal = $jumlah * $harga;

    // Update data
    $stmt = $conn->prepare("
        UPDATE detail_transaksi 
        SET id_produk = ?, id_transaksi = ?, jumlah = ?, subtotal = ?
        WHERE id_detail_transaksi = ?
    ");
    $stmt->bind_param("iiidi", $id_produk, $id_transaksi, $jumlah, $subtotal, $id);
    $stmt->execute();

    // Redirect kembali ke tampilan detail
    header('Location: tampilan_detail.php');
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Detail Transaksi</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <h2>Edit Detail Transaksi</h2>
    <form method="post">
        <label>Produk:</label>
        <select name="id_produk" required>
            <?php while ($p = $produk->fetch_assoc()): ?>
                <option value="<?= $p['id_produk'] ?>" <?= $p['id_produk'] == $data['id_produk'] ? 'selected' : '' ?>>
                    <?= $p['nama_produk'] ?>
                </option>
            <?php endwhile; ?>
        </select><br><br>

        <label>Transaksi:</label>
        <select name="id_transaksi" required>
            <?php while ($t = $transaksi->fetch_assoc()): ?>
                <option value="<?= $t['id_transaksi'] ?>" <?= $t['id_transaksi'] == $data['id_transaksi'] ? 'selected' : '' ?>>
                    <?= $t['tanggal'] ?>
                </option>
            <?php endwhile; ?>
        </select><br><br>

        <label>Jumlah:</label>
        <input type="number" name="jumlah" value="<?= $data['jumlah'] ?>" min="1" required><br><br>

        <button type="submit">Simpan Perubahan</button>
    </form>

    <br>
    <a href="tampilan_detail.php">Kembali</a>
</body>
</html>
