<?php
include "connection.php";

// Ambil ID ulasan dari URL & amankan nilainya
$id = mysqli_real_escape_string($connection, $_GET['id']);

// Query hapus data berdasarkan ID dari tabel reviews
$query = "DELETE FROM reviews WHERE id = '$id'";
$delete = mysqli_query($connection, $query);

if ($delete) {
    // Berhasil menghapus, alihkan kembali ke tabel reviews
    header("Location: tabel_reviews.php");
    exit();
} else {
    // Gagal menghapus, tampilkan pesan error
    echo "Gagal menghapus data ulasan: " . mysqli_error($connection);
}
?>