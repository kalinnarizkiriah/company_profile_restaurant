<?php
include "connection.php";

// Ambil data dari form update contacts
$id      = mysqli_real_escape_string($connection, $_POST['id']);
$name    = mysqli_real_escape_string($connection, $_POST['name']);
$email   = mysqli_real_escape_string($connection, $_POST['email']);
$phone   = mysqli_real_escape_string($connection, $_POST['phone']);
$subject = mysqli_real_escape_string($connection, $_POST['subject']);
$message = mysqli_real_escape_string($connection, $_POST['message']);

// Query Update data ke tabel contacts
$query = "UPDATE contacts SET 
            name    = '$name',
            email   = '$email',
            phone   = '$phone',
            subject = '$subject',
            message = '$message'
          WHERE id = '$id'";

$sql_update = mysqli_query($connection, $query);

if ($sql_update) {
    // Jika berhasil memperbarui, alihkan ke tabel contacts
    header("Location: tabel_contacts.php");
    exit();
} else {
    // Jika gagal memperbarui, tampilkan pesan error
    echo "Gagal memperbarui data kontak: " . mysqli_error($connection);
}
?>