<?php
include "connection.php";

$id = $_GET['id'];
$query = "DELETE FROM tabel_login WHERE id = '$id'";

if (mysqli_query($connection, $query)) {
    header("Location: tabel_login.php");
} else {
    echo "Gagal menghapus data: " . mysqli_error($connection);
}
?>