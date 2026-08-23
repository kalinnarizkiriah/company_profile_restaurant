<?php
session_start();

// Hapus semua session
$_SESSION = array();
session_unset();
session_destroy();

// Pindahkan kembali ke login
header("Location: login.php");
exit;
?>