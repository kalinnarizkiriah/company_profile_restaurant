<?php
// 1. Hubungkan ke database (karena satu folder di dalam backend)
include "connection.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // 2. Ambil data dari form HTML
    $name    = mysqli_real_escape_string($connection, $_POST['name']);
    $email   = mysqli_real_escape_string($connection, $_POST['email']);
    $subject = mysqli_real_escape_string($connection, $_POST['subject']);
    $message = mysqli_real_escape_string($connection, $_POST['message']);

    // 3. Simpan ke database
    $query = "INSERT INTO contacts (name, email, subject, message) 
              VALUES ('$name', '$email', '$subject', '$message')";

    // 4. Tampilkan alert popup dan kembalikan ke halaman form
    if (mysqli_query($connection, $query)) {
        echo "<script>
                alert('Pesan Anda berhasil dikirim!');
                window.location.href = '../frontend/index.php#contact-section';
              </script>";
    } else {
        echo "<script>
                alert('Gagal mengirim pesan: " . mysqli_error($connection) . "');
                window.location.href = '../frontend/index.php#contact-section';
              </script>";
    }
}
?>