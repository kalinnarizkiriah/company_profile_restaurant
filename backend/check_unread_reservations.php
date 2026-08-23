<?php
include "connection.php";

// Pastikan nama tabel (misal: reservations) dan nama kolom (status_dibaca) sesuai dengan database kamu
$query_reservation  = "SELECT COUNT(*) AS total_reservations FROM reservations WHERE status_dibaca = 0";
$result_reservation = mysqli_query($connection, $query_reservation);

if ($result_reservation) {
    $row_reservation = mysqli_fetch_assoc($result_reservation);
    echo $row_reservation['total_reservations'] ?? 0;
} else {
    echo 0;
}
?>