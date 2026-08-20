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

// Menghitung total pesan dari tabel pesan
$query = mysqli_query($connection, "SELECT COUNT(*) as total FROM pesan"); 
$data  = mysqli_fetch_assoc($query);

echo json_encode([
    "status" => "success",
    "unread" => (int)($data['total'] ?? 0)
]);
?>