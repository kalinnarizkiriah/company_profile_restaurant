<?php
session_start();
if (!isset($_SESSION['login_backend'])) {
    header("Location: login.php");
    exit;
}

include "connection.php";

if (isset($_GET['id'])) {
    $id = intval($_GET['id']);

    // Ambil data no_pesanan terlebih dahulu untuk menghapus detail pesanannya
    $query_cek = mysqli_query($connection, "SELECT no_pesanan FROM pesanan WHERE id = $id");
    if ($query_cek && mysqli_num_rows($query_cek) > 0) {
        $data = mysqli_fetch_object($query_cek);
        $no_pesanan = $data->no_pesanan;

        // 1. Hapus data di tabel detail_pesanan terlebih dahulu (mengikuti relasi)
        mysqli_query($connection, "DELETE FROM pesanan WHERE no_pesanan = '$no_pesanan'");

        // 2. Hapus data utama di tabel pesanan
        $query_delete = mysqli_query($connection, "DELETE FROM pesanan WHERE id = $id");

        if ($query_delete) {
            header("Location: pesanan.php?pesan=dihapus");
            exit;
        } else {
            echo "Gagal menghapus pesanan: " . mysqli_error($connection);
        }
    } else {
        header("Location: pesanan.php");
        exit;
    }
} else {
    header("Location: pesanan.php");
    exit;
}
?>