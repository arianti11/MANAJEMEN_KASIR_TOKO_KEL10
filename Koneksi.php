<?php
$host = "localhost";
$user = "root";
$pass = "";
$db = "kasir_toko_baru";

$conn = new mysqli($host, $user, $pass, $db);
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}
?>
