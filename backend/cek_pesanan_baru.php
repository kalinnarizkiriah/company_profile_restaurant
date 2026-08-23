<?php
session_start();
if (!isset($_SESSION['login_backend'])) {
    exit;
}

include "connection.php";

$query = mysqli_query($connection, "SELECT COUNT(*) as total FROM pesanan");
$data = mysqli_fetch_object($query);

echo json_encode(['total' => $data->total]);
?>