<?php
include 'Koneksi.php';

$id = $_GET['id'];
$conn->query("DELETE FROM produk WHERE id_produk = $id");

header('Location: index.php');
exit();
?>