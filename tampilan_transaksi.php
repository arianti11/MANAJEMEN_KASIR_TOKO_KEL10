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
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background:rgb(210, 183, 202);
            margin: 0;
            padding: 20px;
        }
        h1 {
            color: #333;
            text-align: center;
        }
        nav {
            text-align: center;
            margin-bottom: 30px;
        }
        nav a {
            display: inline-block;
            margin: 5px;
            padding: 10px 20px;
            background-color: #007bff;
            color: white;
            text-decoration: none;
            border-radius: 8px;
            transition: 0.3s;
        }
        nav a:hover {
            background-color: #0056b3;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
            background-color: white;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
        }
        th, td {
            padding: 12px 15px;
            border-bottom: 1px solid #eaeaea;
            text-align: left;
        }
        th {
            background-color: #007bff;
            color: white;
        }
        tr:hover {
            background-color: #f1f1f1;
        }
        h2 {
            margin-top: 40px;
            color: #444;
        }
        .aksi a {
            margin-right: 10px;
            color: #007bff;
            text-decoration: none;
        }
        .aksi a:hover {
            text-decoration: underline;
        }
    </style>
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
        .btn { padding: 4px 8px; background-color: #5cb85c; color: white; text-decoration: none; border-radius: 4px; }
        .btn:hover { background-color: #4cae4c; }
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

