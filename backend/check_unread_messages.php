<?php
include_once __DIR__ . '/connection.php';

// Hitung pesan yang belum dibaca
$query_message  = "SELECT COUNT(*) AS total_messages FROM contacts WHERE status_dibaca = 0";
$result_message = mysqli_query($connection, $query_message);
$row_message    = mysqli_fetch_assoc($result_message);

echo $row_message['total_messages'] ?? 0;
?>