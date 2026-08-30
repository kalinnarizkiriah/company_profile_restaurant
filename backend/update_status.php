<?php
session_start();
include "connection.php";

if (isset($_GET['id']) && isset($_GET['status'])) {
    $id = intval($_GET['id']);
    $status_baru = mysqli_real_escape_string($connection, $_GET['status']);

    // Update berdasarkan ID
    $query = "UPDATE pesanan SET status_pesanan = '$status_baru' WHERE id = $id";
    $execute = mysqli_query($connection, $query);

    if ($execute) {
        header("Location: pesanan.php");
        exit;
    } else {
        echo "Gagal mengubah status: " . mysqli_error($connection);
    }
} else {
    header("Location: pesanan.php");
    exit;
}
?>