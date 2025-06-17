<?php
include 'Koneksi.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Hapus data dari detail_transaksi
    $stmt = $conn->prepare("DELETE FROM detail_transaksi WHERE id_detail_transaksi = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();

    // Redirect dengan notifikasi
    header('Location: tampilan_detail.php?status=deleted');
    exit();
} else {
    // Jika tidak ada ID, kembali tanpa aksi
    header('Location: tampilan_detail.php');
    exit();
}
