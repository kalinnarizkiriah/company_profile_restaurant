<?php
include "connection.php";

// Ambil ID dari URL
$id = $_GET['id'];

// Query hapus data berdasarkan ID dari tabel chefs
$query = "DELETE FROM chefs WHERE id = '$id'";
$delete = mysqli_query($connection, $query);

if ($delete) {
    header("Location: tabel_chefs.php");
} else {
    echo "Gagal menghapus data chef: " . mysqli_error($connection);
}
?>