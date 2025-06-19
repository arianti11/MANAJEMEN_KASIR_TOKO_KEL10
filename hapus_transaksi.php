<?php
include 'Koneksi.php';

$id = $_GET['id'];
$conn->query("DELETE FROM transaksi WHERE id_transaksi = $id");

header('Location: tampilan_transaksi.php');
exit();
?>