<?php
header('Content-Type: application/json');

// Panggil file connection.php dari folder backend
include '../../backend/connection.php';

if (!$connection) {
    echo json_encode(['status' => 'error', 'status_pesanan' => '']);
    exit;
}

$no_pesanan = isset($_GET['no_pesanan']) ? $_GET['no_pesanan'] : '';

if (empty($no_pesanan)) {
    echo json_encode(['status' => 'error', 'status_pesanan' => '']);
    exit;
}

$query = "SELECT status_pesanan FROM pesanan WHERE no_pesanan = ?";
$stmt = $connection->prepare($query);
$stmt->bind_param("s", $no_pesanan);
$stmt->execute();
$result = $stmt->get_result();

if ($row = $result->fetch_assoc()) {
    echo json_encode([
        'status' => 'success',
        'status_pesanan' => $row['status_pesanan']
    ]);
} else {
    echo json_encode(['status' => 'error', 'status_pesanan' => '']);
}

$stmt->close();
$connection->close();
?>