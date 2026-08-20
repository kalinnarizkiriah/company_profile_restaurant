<?php
include "connection.php";

// 1. Ambil & bersihkan data dari form HTML
$nama    = mysqli_real_escape_string($connection, $_POST['nama']);
$bintang = mysqli_real_escape_string($connection, $_POST['bintang']);
$ulasan  = mysqli_real_escape_string($connection, $_POST['ulasan']);

// 2. Query Insert sesuai kolom tabel 'reviews'
$query = "INSERT INTO reviews (
            nama, 
            bintang, 
            ulasan
          ) VALUES (
            '$nama', 
            '$bintang', 
            '$ulasan'
          )";

$sql_insert = mysqli_query($connection, $query);

if ($sql_insert) {
    // Berhasil simpan, kembalikan ke halaman tabel reviews
    header("Location: tabel_reviews.php");
    exit();
} else {
    // Tampilkan error jika gagal
    echo "Gagal menyimpan data ulasan: " . mysqli_error($connection);
}
?>