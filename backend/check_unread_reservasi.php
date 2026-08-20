<?php
header('Content-Type: application/json');

if (file_exists("connection.php")) {
    include "connection.php";
} elseif (file_exists("../backend/connection.php")) {
    include "../backend/connection.php";
} else {
    $connection = mysqli_connect("localhost", "root", "", "restaurant");
}

if (!$connection) {
    echo json_encode(["status" => "error", "unread" => 0]);
    exit;
}

// Menghitung total data dari tabel reservasi
// (Sesuaikan nama tabel 'reservasi' jika di database kamu bernama lain, misal: 'reservations')
$query = mysqli_query($connection, "SELECT COUNT(*) as total FROM reservasi"); 
$data  = mysqli_fetch_assoc($query);

echo json_encode([
    "status" => "success",
    "unread" => (int)($data['total'] ?? 0)
]);
?>