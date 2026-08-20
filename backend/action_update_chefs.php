<?php
include "connection.php";

$id         = $_POST['id'];
$name       = $_POST['name'];
$role       = $_POST['role'];
$experience = $_POST['experience'];
$social     = $_POST['social'];
$old_photo  = $_POST['old_photo'];

// Cek apakah ada file foto baru yang diunggah
if (isset($_FILES['photo']) && $_FILES['photo']['error'] === 0) {
    $target_dir = "img/chefs/";

    // Buat folder img/chefs/ otomatis jika belum ada
    if (!is_dir($target_dir)) {
        mkdir($target_dir, 0777, true);
    }

    // Nama file unik menggunakan timestamp
    $filename   = time() . '_' . basename($_FILES['photo']['name']);
    $photo_path = $target_dir . $filename;

    // Pindahkan file ke folder target
    move_uploaded_file($_FILES['photo']['tmp_name'], $photo_path);
} else {
    // Jika tidak upload foto baru, pakai foto lama
    $photo_path = $old_photo;
}

// Query Update
$sql_update = mysqli_query($connection, "UPDATE chefs SET name = '$name', role = '$role', experience = '$experience', photo = '$photo_path', social = '$social' WHERE id = '$id'");

if ($sql_update) {
    header("Location: tabel_chefs.php");
} else {
    echo "Gagal memperbarui data: " . mysqli_error($connection);
}
?>