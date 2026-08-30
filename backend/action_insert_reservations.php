<?php
session_start();
include "connection.php";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $full_name = mysqli_real_escape_string($connection, $_POST['full_name']);
    $phone     = mysqli_real_escape_string($connection, $_POST['phone'] ?? ''); 
    $email     = mysqli_real_escape_string($connection, $_POST['email']);
    $no_meja   = mysqli_real_escape_string($connection, $_POST['no_meja']);
    $date      = mysqli_real_escape_string($connection, $_POST['date']);
    $time      = mysqli_real_escape_string($connection, $_POST['time']);

    // Cek kuota meja/slot waktu yang sama
    $query_check  = "SELECT COUNT(*) AS total FROM reservations WHERE `date` = '$date' AND `time` = '$time'";
    $result_check = mysqli_query($connection, $query_check);
    $data_check   = mysqli_fetch_assoc($result_check);

    $total_booking = $data_check['total'];
    $max_kuota     = 5; 

    if ($total_booking >= $max_kuota) {
        $jam_asal       = strtotime($time);
        $jam_pilihan    = date('H.i', $jam_asal);
        $jam_alternatif = date('H.i', strtotime('+90 minutes', $jam_asal));
        $pesan_error    = "Meja untuk jam $jam_pilihan sudah dipesan. Slot terdekat yang tersedia adalah jam $jam_alternatif.";

        echo $pesan_error; // Kirim teks error ke fetch JavaScript
        exit();
    } else {
        // Simpan data lengkap termasuk phone dan no_meja ke database
        $query_insert = "INSERT INTO reservations (full_name, phone, email, no_meja, `date`, `time`, status_dibaca) 
                         VALUES ('$full_name', '$phone', '$email', '$no_meja', '$date', '$time', 0)";

        if (mysqli_query($connection, $query_insert)) {
            echo "success"; // Beri respon sukses ke fetch JavaScript
        } else {
            echo "Gagal: " . mysqli_error($connection);
        }
    }
}
?>