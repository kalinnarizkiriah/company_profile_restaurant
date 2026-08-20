<?php
include "connection.php";

// Ambil ID reservasi dari URL
$id = $_GET['id'];

// Query hapus data berdasarkan ID dari tabel reservations
$query = "DELETE FROM reservations WHERE id = '$id'";
$delete = mysqli_query($connection, $query);

if ($delete) {
    header("Location: tabel_reservations.php");
} else {
    echo "Gagal menghapus data reservasi: " . mysqli_error($connection);
}
?>