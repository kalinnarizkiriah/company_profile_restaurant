<?php
session_start();
if (!isset($_SESSION['login_backend'])) {
    header("Location: login.php");
    exit;
}

include "connection.php";

if (isset($_GET['id']) && isset($_GET['status'])) {
    $id = intval($_GET['id']);
    $status_baru = mysqli_real_escape_string($connection, $_GET['status']);

    $query = "UPDATE pesanan SET status_pesanan = '$status_baru' WHERE id = $id";
    if (mysqli_query($connection, $query)) {
        header("Location: pesanan.php?pesan=sukses");
        exit;
    } else {
        echo "Gagal mengubah status: " . mysqli_error($connection);
    }
} else {
    header("Location: pesanan.php");
    exit;
}
?>