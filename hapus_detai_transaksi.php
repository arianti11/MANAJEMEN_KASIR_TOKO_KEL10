<?php
include 'Koneksi.php';

$id = $_GET['id'];
$conn->query("DELETE FROM detail_transaksi WHERE id_detail_transaksi = $id");

header('Location: index.php');
exit();
?>