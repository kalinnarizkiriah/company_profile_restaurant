<?php
include "connection.php";

// Ambil ID dari URL (menggunakan key 'id')
if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Query untuk menghapus data berdasarkan ID
    $delete = mysqli_query($connection, "DELETE FROM menu WHERE id = '$id'");

    if ($delete) {
        // Jika berhasil, kembali ke tabel menu
        header("Location: tabel_menu.php");
        exit();
    } else {
        echo "Gagal menghapus data: " . mysqli_error($connection);
    }
} else {
    // Jika tidak ada ID di URL, kembalikan ke tabel menu
    header("Location: tabel_menu.php");
    exit();
}
?>