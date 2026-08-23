<?php
include "connection.php"; // Pastikan file koneksi sudah benar

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Mengambil data dari form HTML
    $full_name = mysqli_real_escape_string($connection, $_POST['full_name']);
    $phone     = mysqli_real_escape_string($connection, $_POST['phone']);
    $email     = mysqli_real_escape_string($connection, $_POST['email']);
    $guests    = mysqli_real_escape_string($connection, $_POST['guests']);
    $date      = mysqli_real_escape_string($connection, $_POST['date']);
    $time      = mysqli_real_escape_string($connection, $_POST['time']); // Format: HH:MM

    // 1. Cek jumlah reservasi pada tanggal dan jam yang sama (menggunakan nama kolom date & time)
    $query_check  = "SELECT COUNT(*) AS total FROM reservations WHERE `date` = '$date' AND `time` = '$time'";
    $result_check = mysqli_query($connection, $query_check);
    $data_check   = mysqli_fetch_assoc($result_check);

    $total_booking = $data_check['total'];
    $max_kuota     = 5; // Batas maksimal reservasi per slot jam

    if ($total_booking >= $max_kuota) {
        // 2. Hitung slot jam terdekat (otomatis ditambah 1.5 jam / 90 menit)
        $jam_asal       = strtotime($time);
        $jam_pilihan    = date('H.i', $jam_asal);
        $jam_alternatif = date('H.i', strtotime('+90 minutes', $jam_asal));

        // Pesan Peringatan
        $pesan_error = "Meja untuk jam $jam_pilihan sudah dipesan. Slot terdekat yang tersedia adalah jam $jam_alternatif.";

        echo "<script>
                alert('$pesan_error');
                window.history.back();
              </script>";
        exit();
    } else {
        // 3. Simpan data reservasi jika kuota masih tersedia (< 5)
        $query_insert = "INSERT INTO reservations (full_name, phone, email, guests, `date`, `time`, status_dibaca) 
                         VALUES ('$full_name', '$phone', '$email', '$guests', '$date', '$time', 0)";

        if (mysqli_query($connection, $query_insert)) {
            echo "<script>
                    alert('Reservasi berhasil dibuat!');
                    window.location.href = '../frontend/index.php#reservation';
                  </script>";
        } else {
            echo "<script>
                    alert('Gagal membuat reservasi: " . mysqli_error($connection) . "');
                    window.history.back();
                  </script>";
        }
    }
}
?>