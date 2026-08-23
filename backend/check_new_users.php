<?php
session_start();
include 'connection.php'; // Sesuaikan jika nama file koneksi beda

header('Content-Type: application/json');

// Menghitung customer yang is_read = 0
$query = mysqli_query($connection, "SELECT COUNT(*) as total FROM tabel_login WHERE role='Customer' AND is_read = 0");

if ($query) {
    $data = mysqli_fetch_assoc($query);
    echo json_encode([
        'status' => 'success',
        'total'  => (int)$data['total']
    ]);
} else {
    echo json_encode([
        'status' => 'error',
        'total'  => 0,
        'message' => mysqli_error($connection)
    ]);
}
?>