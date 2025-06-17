<?php
include 'Koneksi.php';

$id = $_GET['id'];
$conn->query("DELETE FROM transaksi WHERE id_transaksi = $id");

header('Location: index.php');
exit();
?>