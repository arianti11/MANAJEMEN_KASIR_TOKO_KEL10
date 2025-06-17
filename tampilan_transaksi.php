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
    <style>
        body { font-family: sans-serif; padding: 20px; }
        nav a {
            margin-right: 20px;
            text-decoration: none;
            font-weight: bold;
            color: #333;
        }
        table { border-collapse: collapse; width: 100%; margin-bottom: 40px; }
        th, td { border: 1px solid #ccc; padding: 8px; }
        th { background-color: #eee; }
        h2 { margin-top: 40px; }
        .action { text-align: center; }
        .btn { padding: 4px 8px; background-color:rgb(237, 180, 213); color: white; text-decoration: none; border-radius: 4px; }
        .btn:hover { background-color:rgb(222, 147, 172); }
    </style>
</head>
<body>

    <h1>Dashboard Kasir Toko</h1>

   <nav>
        <a href="tampilan_produk.php">Produk</a>
        <a href="tampilan_transaksi.php">Transaksi</a>
        <a href="tampilan_detail.php">Detail Transaksi</a>
        <a href="tampilan_agregat.php">Agregat</a>
    </nav>

    <h2 id="transaksi">Daftar Transaksi</h2>
    <a class="btn" href="tambah_transaksi.php">+ Tambah Transaksi</a>
    <table>
        <tr>
            <th>ID</th>
            <th>Tanggal</th>
            <th>Total Bayar</th>
            <th class="action">Aksi</th>
        </tr>
        <?php while ($row = $transaksi->fetch_assoc()): ?>
        <tr>
            <td><?= $row['id_transaksi'] ?></td>
            <td><?= $row['tanggal'] ?></td>
            <td><?= number_format($row['total_bayar'], 0, ',', '.') ?></td>
            <td class="action">
                <a href="edit_transaksi.php?id=<?= $row['id_transaksi'] ?>" class="btn">Edit</a>
                <a href="hapus_transaksi.php?id=<?= $row['id_transaksi'] ?>" class="btn" style="background-color: #d9534f;">Hapus</a>
            </td>
        </tr>
        <?php endwhile; ?>
    </table>
</body>
</html>

