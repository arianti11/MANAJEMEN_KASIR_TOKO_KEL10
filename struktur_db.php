<?php
include 'Koneksi.php';

// Membuat View
$conn->query("CREATE OR REPLACE VIEW v_detail_transaksi AS
    SELECT dt.id_detail_transaksi, p.nama_produk, t.tanggal, dt.jumlah, dt.subtotal
    FROM detail_transaksi dt
    JOIN produk p ON dt.id_produk = p.id_produk
    JOIN transaksi t ON dt.id_transaksi = t.id_transaksi");

// Membuat Synonym (jika DB mendukungnya, umumnya Oracle. Untuk MySQL, ini tidak tersedia. Diabaikan atau dibuat alias pada query saja.)
// Jadi sebagai gantinya, gunakan alias dalam query: SELECT * FROM v_detail_transaksi AS syn_detail

// Membuat Trigger untuk menghitung subtotal otomatis saat insert detail_transaksi
$conn->query("DROP TRIGGER IF EXISTS before_insert_detail");
$conn->query("CREATE TRIGGER before_insert_detail
BEFORE INSERT ON detail_transaksi
FOR EACH ROW
BEGIN
    DECLARE harga_produk INT;
    SELECT harga INTO harga_produk FROM produk WHERE id_produk = NEW.id_produk;
    SET NEW.subtotal = harga_produk * NEW.jumlah;
END;");

// Membuat Trigger untuk menghitung total_bayar otomatis saat insert detail_transaksi
$conn->query("DROP TRIGGER IF EXISTS after_insert_detail");
$conn->query("CREATE TRIGGER after_insert_detail
AFTER INSERT ON detail_transaksi
FOR EACH ROW
BEGIN
    UPDATE transaksi
    SET total_bayar = (
        SELECT SUM(subtotal) FROM detail_transaksi WHERE id_transaksi = NEW.id_transaksi
    )
    WHERE id_transaksi = NEW.id_transaksi;
END;");

echo "View, Trigger berhasil dibuat. (Synonym tidak didukung di MySQL.)";
?>
