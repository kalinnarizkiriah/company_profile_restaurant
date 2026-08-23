<?php
session_start();

// Kosongkan session keranjang
unset($_SESSION['cart']);

// Kembalikan ke halaman utama
header('Location: ../index.php');
exit;
?>