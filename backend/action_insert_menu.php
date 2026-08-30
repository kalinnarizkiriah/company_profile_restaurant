<?php
include "connection.php";

if (isset($_POST['submit'])) {

    $title       = mysqli_real_escape_string($connection, $_POST['title']);
    $kategori    = mysqli_real_escape_string($connection, $_POST['kategori']);
    $price       = mysqli_real_escape_string($connection, $_POST['price']);
    // Menangkap input harga diskon (jika kosong, diset NULL)
    $harga_diskon = !empty($_POST['harga_diskon']) ? mysqli_real_escape_string($connection, $_POST['harga_diskon']) : NULL;
    $rating      = mysqli_real_escape_string($connection, $_POST['rating']);
    $deskripsi   = mysqli_real_escape_string($connection, $_POST['deskripsi']);

    // Cek upload gambar
    if (isset($_FILES['gambar']) && $_FILES['gambar']['error'] === 0) {
        
        $filename = $_FILES['gambar']['name'];
        $tmp_name = $_FILES['gambar']['tmp_name'];
        $file_ext = strtolower(pathinfo($filename, PATHINFO_EXTENSION));
        $allowed  = array('jpg', 'jpeg', 'png', 'webp');

        if (in_array($file_ext, $allowed)) {

            // Generate nama file unik
            $new_filename = time() . '_' . rand(100, 999) . '.' . $file_ext;

            // Jalur target simpan folder (Cek folder img/category di dalam project)
            if (is_dir("img/category")) {
                $target_dir = "img/category/";
            } elseif (is_dir("../img/category")) {
                $target_dir = "../img/category/";
            } else {
                // Buat folder jika belum ada
                mkdir("img/category", 0777, true);
                $target_dir = "img/category/";
            }

            // Pindahkan file gambar ke folder tujuan
            if (move_uploaded_file($tmp_name, $target_dir . $new_filename)) {

                // Query Insert ke Database (ditambah kolom harga_diskon)
                if ($harga_diskon !== NULL) {
                    $query = "INSERT INTO menu (kategori, title, price, harga_diskon, rating, gambar, deskripsi) 
                              VALUES ('$kategori', '$title', '$price', '$harga_diskon', '$rating', '$new_filename', '$deskripsi')";
                } else {
                    $query = "INSERT INTO menu (kategori, title, price, harga_diskon, rating, gambar, deskripsi) 
                              VALUES ('$kategori', '$title', '$price', NULL, '$rating', '$new_filename', '$deskripsi')";
                }

                $insert = mysqli_query($connection, $query);

                if ($insert) {
                    echo "<script>
                            alert('Data menu berhasil ditambahkan!');
                            window.location.href = 'tabel_menu.php';
                          </script>";
                } else {
                    echo "Gagal insert ke database: " . mysqli_error($connection);
                }

            } else {
                echo "<script>
                        alert('Gagal memindahkan file foto ke server.');
                        window.history.back();
                      </script>";
            }

        } else {
            echo "<script>
                    alert('Format foto harus JPG, JPEG, PNG, atau WEBP.');
                    window.history.back();
                  </script>";
        }

    } else {
        echo "<script>
                alert('Silakan pilih foto makanan!');
                window.history.back();
              </script>";
    }

} else {
    header("Location: form_menu.php");
    exit();
}
?>