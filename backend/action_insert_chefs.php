<?php
include "connection.php";

$name       = $_POST['name'];
$role       = $_POST['role'];
$experience = $_POST['experience'];
$social     = $_POST['social'];

if (isset($_FILES['photo']) && $_FILES['photo']['error'] === 0) {
    $target_dir = "img/chefs/";

    if (!is_dir($target_dir)) {
        mkdir($target_dir, 0777, true);
    }

    $filename   = time() . '_' . basename($_FILES['photo']['name']);
    $photo_path = $target_dir . $filename;

    if (move_uploaded_file($_FILES['photo']['tmp_name'], $photo_path)) {
        $sql_insert = mysqli_query($connection, "INSERT INTO chefs (name, role, experience, photo, social) VALUES ('$name', '$role', '$experience', '$photo_path', '$social')");

        if ($sql_insert) {
            header("Location: tabel_chefs.php");
            exit();
        } else {
            echo "Gagal menyimpan ke database: " . mysqli_error($connection);
        }
    } else {
        echo "Gagal mengunggah gambar.";
    }
} else {
    echo "Pilih foto terlebih dahulu.";
}
?>