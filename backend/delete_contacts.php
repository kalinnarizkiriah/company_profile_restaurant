<?php
include "connection.php";

// Ambil ID contact dari URL & amankan nilainya
$id = mysqli_real_escape_string($connection, $_GET['id']);

// Query hapus data berdasarkan ID dari tabel contacts
$query = "DELETE FROM contacts WHERE id = '$id'";
$delete = mysqli_query($connection, $query);

if ($delete) {
    // Berhasil menghapus, alihkan kembali ke tabel contacts
    header("Location: tabel_contacts.php");
    exit();
} else {
    // Gagal menghapus, tampilkan pesan error
    echo "Gagal menghapus data kontak: " . mysqli_error($connection);
} 
?>