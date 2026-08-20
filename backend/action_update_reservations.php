<?php
include "connection.php";

// Mengambil data dari form update
$id        = $_POST['id'];
$full_name = $_POST['full_name'];
$phone     = $_POST['phone'];
$email     = $_POST['email'];
$guests    = $_POST['guests'];
$date      = $_POST['date'];
$time      = $_POST['time'];

// Query Update data berdasarkan ID
$sql_update = mysqli_query($connection, "UPDATE reservations SET 
    full_name = '$full_name',
    phone     = '$phone',
    email     = '$email',
    guests    = '$guests',
    date      = '$date',
    time      = '$time'
    WHERE id  = '$id'");

// Cek apakah update berhasil
if ($sql_update) {
    header("Location: tabel_reservations.php");
} else {
    echo "Gagal memperbarui data: " . mysqli_error($connection);
}
?>