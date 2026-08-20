<?php
// Pastikan tidak ada output HTML sebelum header JSON
header('Content-Type: application/json');

// Koneksi Database
if (file_exists("connection.php")) {
    include "connection.php";
} elseif (file_exists("../backend/connection.php")) {
    include "../backend/connection.php";
} else {
    $connection = mysqli_connect("localhost", "root", "", "restaurant");
}

if (!$connection) {
    echo json_encode(["status" => "error", "message" => "Koneksi database gagal"]);
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nama    = mysqli_real_escape_string($connection, trim($_POST['nama'] ?? ''));
    $bintang = (int)($_POST['bintang'] ?? 5);
    $ulasan  = mysqli_real_escape_string($connection, trim($_POST['ulasan'] ?? ''));

    if (!empty($nama) && !empty($ulasan)) {
        // Query Insert ke Database
        $query = "INSERT INTO reviews (nama, bintang, ulasan) VALUES ('$nama', '$bintang', '$ulasan')";
        
        if (mysqli_query($connection, $query)) {
            // Jika request via AJAX (Modal Frontend)
            if (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
                echo json_encode(["status" => "success", "message" => "Ulasan berhasil ditambahkan"]);
            } else {
                // Jika dari Form Admin biasa
                header("Location: tabel_reviews.php?status=success");
                exit;
            }
        } else {
            echo json_encode(["status" => "error", "message" => mysqli_error($connection)]);
        }
    } else {
        echo json_encode(["status" => "error", "message" => "Nama dan ulasan tidak boleh kosong"]);
    }
    exit;
}
?>