<?php
require_once '../../backend/koneksi.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = json_decode(file_get_contents('php://input'), true);
    $no_pesanan = $data['no_pesanan'];

    // Menggunakan variabel $connection
    $query = "UPDATE pesanan SET status_pesanan = 'Sudah Dibayar (Menunggu Diproses)' WHERE no_pesanan = ?";
    $stmt = mysqli_prepare($connection, $query);
    mysqli_stmt_bind_param($stmt, 's', $no_pesanan);
    
    if (mysqli_stmt_execute($stmt)) {
        echo json_encode(['status' => 'success']);
    } else {
        echo json_encode(['status' => 'error']);
    }
    exit;
}
?>