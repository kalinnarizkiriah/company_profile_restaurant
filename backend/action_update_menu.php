<?php
include "connection.php";

$id          = $_POST['id'] ?? '';
$title       = mysqli_real_escape_string($connection, $_POST['title'] ?? '');
$kategori    = mysqli_real_escape_string($connection, $_POST['kategori'] ?? '');
$price       = mysqli_real_escape_string($connection, $_POST['price'] ?? '');
$rating      = mysqli_real_escape_string($connection, $_POST['rating'] ?? '');
$deskripsi   = mysqli_real_escape_string($connection, $_POST['deskripsi'] ?? '');
$gambar_lama = $_POST['gambar_lama'] ?? '';

// 1. Tentukan direktori penyimpanan
$target_dir = "img/category/"; 

// Buat folder jika belum ada
if (!file_exists($target_dir)) {
    mkdir($target_dir, 0777, true);
}

// 2. Cek apakah ada file foto baru yang diunggah
if (isset($_FILES['gambar']['name']) && $_FILES['gambar']['name'] != "") {
    $nama_file = $_FILES['gambar']['name'];
    $tmp_file  = $_FILES['gambar']['tmp_name'];
    
    // Ambil ekstensi file & cegah titik kosong di akhir
    $ext = strtolower(pathinfo($nama_file, PATHINFO_EXTENSION));
    if (empty($ext)) {
        $ext = "jpg"; // Cadangan ekstensi jika tidak terbaca
    }

    $gambar_baru = time() . '_' . uniqid() . '.' . $ext;
    $target_file = $target_dir . $gambar_baru;

    // Upload file baru
    if (move_uploaded_file($tmp_file, $target_file)) {
        // Hapus foto lama jika ada
        if (!empty($gambar_lama) && file_exists($target_dir . $gambar_lama)) {
            unlink($target_dir . $gambar_lama);
        }
        $gambar = $gambar_baru;
    } else {
        $gambar = $gambar_lama;
    }
} else {
    // Jika tidak upload foto baru, tetap gunakan foto lama
    $gambar = $gambar_lama;
}

// 3. Perbarui data di database (Nama tabel yang benar: menu)
$query = "UPDATE menu SET 
            title = '$title',
            gambar = '$gambar',
            kategori = '$kategori',
            price = '$price',
            rating = '$rating',
            deskripsi = '$deskripsi'
          WHERE id = '$id'";

$update = mysqli_query($connection, $query);

if ($update) {
    echo "<script>
            alert('Menu berhasil diperbarui!');
            window.location.href = 'tabel_menu.php';
          </script>";
    exit;
} else {
    echo "Gagal memperbarui data: " . mysqli_error($connection);
}
?>