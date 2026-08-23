<?php
include_once __DIR__ . '/connection.php';

// Query hitung ulasan yang belum dibaca
$query_review  = "SELECT COUNT(*) AS total_reviews FROM reviews WHERE status_dibaca = 0";
$result_review = mysqli_query($connection, $query_review);
$row_review    = mysqli_fetch_assoc($result_review);

echo $row_review['total_reviews'] ?? 0;
?>