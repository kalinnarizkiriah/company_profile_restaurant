<?php
include "connection.php";

if (isset($_POST['update'])) {
    $id               = intval($_POST['id']);
    $nama             = mysqli_real_escape_string($connection, $_POST['nama'] ?? '');
    $deskripsi        = mysqli_real_escape_string($connection, $_POST['deskripsi'] ?? '');
    $badge_text       = mysqli_real_escape_string($connection, $_POST['badge_text'] ?? '');
    $teks_promo       = mysqli_real_escape_string($connection, $_POST['teks_promo'] ?? '');
    $waktu_pengiriman = mysqli_real_escape_string($connection, $_POST['waktu_pengiriman'] ?? '');
    $teks_rating       = mysqli_real_escape_string($connection, $_POST['teks_rating'] ?? '');
    $gambar_lama      = $_POST['gambar_lama'] ?? '';

    // Logika Upload Foto
    $nama_gambar = $gambar_lama; // Default gunakan nama gambar lama

    if (isset($_FILES['gambar_hero']) && $_FILES['gambar_hero']['error'] === UPLOAD_ERR_OK) {
        $file_tmp  = $_FILES['gambar_hero']['tmp_name'];
        $file_name = $_FILES['gambar_hero']['name'];
        $ext       = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));

        // Ekstensi yang diperbolehkan
        $allowed_ext = array('jpg', 'jpeg', 'png', 'webp');

        if (in_array($ext, $allowed_ext)) {
            // Buat nama file baru yang unik
            $nama_gambar_baru = time() . '_' . rand(100, 999) . '.' . $ext;
            
            // Tentukan folder tujuan penyimpanan (Ke folder assets frontend)
            $folder_tujuan = "img/category/" . $nama_gambar_baru;
            if (move_uploaded_file($file_tmp, $folder_tujuan)) {
                $nama_gambar = $nama_gambar_baru;

                // Hapus foto lama jika ada
                if (!empty($gambar_lama) && file_exists("img/category/" . $gambar_lama)) {
    @unlink("img/category/" . $gambar_lama);
}
            }
        }
    }

    // Query UPDATE (Koma berlebih sebelum WHERE sudah dihapus)
    $query = "UPDATE tb_profile SET 
                nama = '$nama',
                deskripsi = '$deskripsi',
                badge_text = '$badge_text',
                gambar_hero = '$nama_gambar',
                teks_promo = '$teks_promo',
                waktu_pengiriman = '$waktu_pengiriman',
                teks_rating = '$teks_rating'
              WHERE id = $id";

    $update = mysqli_query($connection, $query);

    if ($update) {
        echo "<script>
                alert('Data Profile berhasil diperbarui!');
                window.location.href = 'tabel_profile.php';
              </script>";
    } else {
        $error_msg = addslashes(mysqli_error($connection));
        echo "<script>
                alert('Gagal memperbarui data: $error_msg');
                window.location.href = 'update_form_profile.php?id=$id';
              </script>";
    }
} else {
    header("Location: tabel_profile.php");
    exit();
}
?>