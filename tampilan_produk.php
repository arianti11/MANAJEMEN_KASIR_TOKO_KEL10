<?php
include 'Koneksi.php';

// Ambil data produk
$produk = $conn->query("SELECT * FROM produk");

// Ambil data transaksi
$transaksi = $conn->query("SELECT * FROM transaksi");

// Ambil data detail transaksi (join produk dan transaksi)
$detail = $conn->query("
    SELECT dt.id_detail_transaksi, p.nama_produk, t.tanggal, dt.jumlah, dt.subtotal
    FROM detail_transaksi dt
    JOIN produk p ON dt.id_produk = p.id_produk
    JOIN transaksi t ON dt.id_transaksi = t.id_transaksi
");

// Agregat
$agregat = $conn->query("
    SELECT 
        SUM(total_bayar) AS total_sum,
        MIN(total_bayar) AS total_min,
        MAX(total_bayar) AS total_max,
        AVG(total_bayar) AS total_avg
    FROM transaksi
");
$agg = $agregat->fetch_assoc();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Dashboard Kasir Toko</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;500;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="style1.css">
</head>
<body>

    <h1>Dashboard Kasir Toko</h1>

    <nav>
        <a href="tampilan_produk.php">Produk</a>
        <a href="tampilan_transaksi.php">Transaksi</a>
        <a href="tampilan_detail.php">Detail Transaksi</a>
        <a href="tampilan_agregat.php">Agregat</a>
    </nav>
    <h2 id="produk">Daftar Produk</h2>
    <a class="btn" href="tambah_produk.php">+ Tambah Produk</a>
    <table>
        <tr>
            <th>ID</th>
            <th>Nama Produk</th>
            <th>Harga</th>
            <th class="action">Aksi</th>
        </tr>
        <?php while ($row = $produk->fetch_assoc()): ?>
        <tr>
            <td><?= $row['id_produk'] ?></td>
            <td><?= $row['nama_produk'] ?></td>
            <td><?= number_format($row['harga'], 0, ',', '.') ?></td>
            <td class="action">
                <a href="edit_produk.php?id=<?= $row['id_produk'] ?>" class="btn">Edit</a>
                <a href="hapus_produk.php?id=<?= $row['id_produk'] ?>" class="btn" style="background-color: #d9534f;">Hapus</a>
            </td>
        </tr>
        <?php endwhile; ?>
    </table>
</body>
</html>
