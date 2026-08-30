<?php
session_start();
include 'connection.php'; 

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $no_pesanan = mysqli_real_escape_string($connection, $_POST['no_pesanan']);
    $bintang    = mysqli_real_escape_string($connection, $_POST['bintang']);
    $ulasan     = mysqli_real_escape_string($connection, $_POST['ulasan']);

    // 1. Ambil nama pemesan asli dari tabel pesanan berdasarkan no_pesanan
    $nama_pelanggan = "Pelanggan";
    $q_pesanan = mysqli_query($connection, "SELECT nama_pemesan FROM pesanan WHERE no_pesanan = '$no_pesanan' LIMIT 1");
    if ($q_pesanan && mysqli_num_rows($q_pesanan) > 0) {
        $data_p = mysqli_fetch_assoc($q_pesanan);
        if (!empty($data_p['nama_pemesan'])) {
            $nama_pelanggan = $data_p['nama_pemesan'];
        }
    }

    // 2. Simpan ulasan ke database dengan WAJIB menyertakan no_pesanan
    // (Pastikan tabel 'reviews' di database Anda memiliki kolom: id, no_pesanan, nama, bintang, ulasan, balasan)
    $query_insert = "INSERT INTO reviews (no_pesanan, nama, bintang, ulasan) VALUES ('$no_pesanan', '$nama_pelanggan', '$bintang', '$ulasan')";
    $execute = mysqli_query($connection, $query_insert);

    // Redirect kembali ke halaman riwayat pesanan dengan membawa status sukses
    header("Location: ../frontend/partials/riwayat-pesanan.php?status=sukses_ulasan");
    exit;
} else {
    header("Location: ../frontend/partials/riwayat-pesanan.php");
    exit;
}
?>