<?php
include_once __DIR__ . '/../connection.php';

$query = "SELECT COUNT(*) AS total FROM pesanan WHERE status_pesanan = 'Menunggu Konfirmasi' OR status_pesanan = 'Menunggu Pembayaran di Kasir'";
$result = mysqli_query($connection, $query);
$row = mysqli_fetch_assoc($result);
$total = $row['total'] ?? 0;

header('Content-Type: application/json');
echo json_encode([
    'status' => 'success',
    'total' => (int)$total
]);
?>