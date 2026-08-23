<?php
session_start();

// Hapus semua variabel session
session_unset();

// Hancurkan session
session_destroy();

// Pindah kembali ke halaman index (keluar dari folder partials)
header("Location: ../index.php");
exit();
?>