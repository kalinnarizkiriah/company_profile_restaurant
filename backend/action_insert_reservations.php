<?php
// Koneksi ke database
include "connection.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    // Ambil dan amankan data dari form
    $full_name = mysqli_real_escape_string($connection, $_POST['full_name']);
    $phone     = mysqli_real_escape_string($connection, $_POST['phone']);
    $email     = mysqli_real_escape_string($connection, $_POST['email']);
    $guests    = mysqli_real_escape_string($connection, $_POST['guests']);
    $date      = mysqli_real_escape_string($connection, $_POST['date']);
    $time      = mysqli_real_escape_string($connection, $_POST['time']);

    // Insert data ke tabel reservations
    $query = "INSERT INTO reservations (full_name, phone, email, guests, date, time) 
              VALUES ('$full_name', '$phone', '$email', '$guests', '$date', '$time')";

    if (mysqli_query($connection, $query)) {
        echo "<script>
                alert('Reservasi Anda berhasil dikirim!');
                window.location.href = '../frontend/index.php#reservation';
              </script>";
    } else {
        echo "<script>
                alert('Gagal mengirim reservasi. Silakan coba lagi.');
                window.history.back();
              </script>";
    }
}
?>