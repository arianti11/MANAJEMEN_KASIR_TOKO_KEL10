<?php
include 'Koneksi.php';

$id = $_GET['id'];
$conn->query("DELETE FROM produk WHERE id_produk = $id");

header('Location: tampilan_produk.php');
exit();
?>