<?php
session_start(); 
require 'connection.php';

if (isset($_SESSION['login_backend'])) {
    header("Location: index.php");
    exit;
}

$error = "";

if (isset($_POST['login'])) {
    $username       = mysqli_real_escape_string($connection, $_POST['username']);
    $password_input = $_POST['password'];

    $query = mysqli_query($connection, "SELECT * FROM tabel_login WHERE username = '$username'");
    $user  = mysqli_fetch_assoc($query);

    if ($user) {
        if ($password_input === $user['password']) {            
            // Mengizinkan akun dengan role super_admin atau admin untuk masuk
            if ($user['role'] === 'super_admin' || $user['role'] === 'admin') {
                $_SESSION['login_backend'] = true;
                $_SESSION['admin_username']     = $user['username']; 
                $_SESSION['admin_nama_lengkap'] = $user['nama_lengkap']; 
                $_SESSION['admin_role']         = $user['role']; 

                header("Location: index.php");
                exit;
            } else {
                $error = "Akses ditolak! Akun Customer tidak bisa masuk ke Backend Admin.";
            }
        } else {
            $error = "Password salah!";
        }
    } else {
        $error = "Username tidak ditemukan!";
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Admin - Resto Jogja</title>
    
    <!-- Favicon / Logo Tab Browser -->
    <link rel="icon" type="image/png" href="img/category/logojogja7.png">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background-color: #faf7f2; }
        .btn-restoran { background-color: #d9230f; color: white; border: none; box-shadow: 0 4px 10px rgba(217, 35, 15, 0.3); }
        .btn-restoran:hover { background-color: #b51d0c; color: white; }
    </style>
</head>
<body class="d-flex align-items-center justify-content-center my-5" style="min-height: 90vh;">

<div class="card shadow-lg border-0 rounded-4 p-4" style="width: 100%; max-width: 420px;">
    <div class="text-center mb-3">
        <img src="img/category/logojogja7.png" alt="Logo" style="height: 60px;" class="mb-2">
        <h4 class="fw-bold text-danger m-0">Resto Jogja</h4>
        <p class="text-muted small">Silakan login</p>
    </div>
    
    <?php if ($error) : ?>
        <div class="alert alert-danger py-2 text-center small" role="alert">
            <?= $error; ?>
        </div>
    <?php endif; ?>

    <form action="" method="POST" autocomplete="off">
        <div class="mb-3">
            <label class="form-label">Username</label>
            <input 
                type="text" 
                name="username" 
                class="form-control" 
                placeholder="Masukkan username" 
                required 
                autofocus 
                autocomplete="off"
                oninvalid="this.setCustomValidity('Harap isi bidang ini.')" 
                oninput="this.setCustomValidity('')"
            >
        </div>
        <div class="mb-3">
            <label class="form-label">Password</label>
            <input 
                type="password" 
                name="password" 
                class="form-control" 
                placeholder="Masukkan password" 
                required 
                autocomplete="new-password"
                oninvalid="this.setCustomValidity('Harap isi bidang ini.')" 
                oninput="this.setCustomValidity('')"
            >
        </div>
        <button type="submit" name="login" class="btn btn-restoran w-100 py-2 mt-2 rounded-3">Login Admin</button>
    </form>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>