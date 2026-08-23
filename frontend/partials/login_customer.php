<?php
session_start();
require '../../backend/connection.php';

// Jika sudah login customer, redirect ke halaman utama frontend
if (isset($_SESSION['login_customer'])) {
    header("Location: ../index.php");
    exit;
}

$error_login = "";
$error_register = "";
$success_register = "";
$active_tab = "login"; // Default tab aktif

// --- PROSES REGISTRASI ---
if (isset($_POST['register'])) {
    $active_tab = "register";
    $nama_lengkap = mysqli_real_escape_string($connection, $_POST['nama_lengkap']);
    $username     = mysqli_real_escape_string($connection, $_POST['username']);
    $password     = $_POST['password'];
    $confirm_pwd  = $_POST['confirm_password'];

    if ($password !== $confirm_pwd) {
        $error_register = "Konfirmasi password tidak cocok!";
    } else {
        // Cek ketersediaan username
        $check_user = mysqli_query($connection, "SELECT * FROM tabel_login WHERE username = '$username'");
        if (mysqli_num_rows($check_user) > 0) {
            $error_register = "Username sudah digunakan, silakan pakai yang lain!";
        } else {
            // Simpan akun customer baru (tanpa kolom email)
            $query_insert = "INSERT INTO tabel_login (nama_lengkap, username, password, role) 
                             VALUES ('$nama_lengkap', '$username', '$password', 'customer')";
            
            if (mysqli_query($connection, $query_insert)) {
                $success_register = "Pendaftaran berhasil! Silakan login di bawah.";
                $active_tab = "login";
            } else {
                $error_register = "Gagal mendaftar, coba lagi nanti!";
            }
        }
    }
}

// --- PROSES LOGIN ---
if (isset($_POST['login'])) {
    $active_tab = "login";
    $username       = mysqli_real_escape_string($connection, $_POST['username']);
    $password_input = $_POST['password'];

    $query = mysqli_query($connection, "SELECT * FROM tabel_login WHERE username = '$username'");
    $user  = mysqli_fetch_assoc($query);

    if ($user) {
        if ($password_input === $user['password']) {
            if ($user['role'] === 'customer') {
                $_SESSION['login_customer'] = true;
                $_SESSION['customer_username']     = $user['username'];     // DISESUAIKAN
                $_SESSION['customer_nama_lengkap'] = $user['nama_lengkap']; // DISESUAIKAN

                header("Location: ../index.php");
                exit;
            } else {
                $error_login = "Akun Admin silakan login melalui portal Admin!";
            }
        } else {
            $error_login = "Password salah!";
        }
    } else {
        $error_login = "Username tidak ditemukan!";
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Masuk / Daftar - Resto Jogja</title>
    
    <!-- Favicon Logo -->
    <link rel="icon" type="image/png" href="../../backend/img/category/logojogja7.png">
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background-color: #faf7f2; }
        .btn-restoran { background-color: #d9230f; color: white; border: none; box-shadow: 0 4px 10px rgba(217, 35, 15, 0.3); }
        .btn-restoran:hover { background-color: #b51d0c; color: white; }
        .nav-pills .nav-link.active { background-color: #d9230f; color: white; }
        .nav-pills .nav-link { color: #555; font-weight: 600; }
    </style>
</head>
<body class="d-flex align-items-center justify-content-center my-5" style="min-height: 90vh;">

<div class="card shadow-lg border-0 rounded-4 p-4" style="width: 100%; max-width: 420px;">
    <div class="text-center mb-3">
        <img src="../../backend/img/category/logojogja7.png" alt="Logo" style="height: 60px;" class="mb-2">
        <h4 class="fw-bold text-danger m-0">Resto Jogja</h4>
        <p class="text-muted small">Selamat Datang</p>
    </div>

    <!-- Tab Navigasi Login / Register -->
    <ul class="nav nav-pills nav-justified mb-4 bg-light rounded-3 p-1" id="pills-tab" role="tablist">
        <li class="nav-item" role="presentation">
            <button class="nav-link <?= $active_tab == 'login' ? 'active' : '' ?>" id="tab-login" data-bs-toggle="pill" data-bs-target="#content-login" type="button" role="tab">Masuk</button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link <?= $active_tab == 'register' ? 'active' : '' ?>" id="tab-register" data-bs-toggle="pill" data-bs-target="#content-register" type="button" role="tab">Daftar</button>
        </li>
    </ul>

    <div class="tab-content" id="pills-tabContent">
        <!-- FORM LOGIN -->
        <div class="tab-pane fade <?= $active_tab == 'login' ? 'show active' : '' ?>" id="content-login" role="tabpanel">
            <?php if ($error_login) : ?>
                <div class="alert alert-danger py-2 text-center small"><?= $error_login; ?></div>
            <?php endif; ?>
            <?php if ($success_register) : ?>
                <div class="alert alert-success py-2 text-center small"><?= $success_register; ?></div>
            <?php endif; ?>

            <form action="" method="POST" autocomplete="off">
                <div class="mb-3">
                    <label class="form-label">Username</label>
                    <input type="text" name="username" class="form-control" placeholder="Masukkan username" required autocomplete="one-time-code" oninvalid="this.setCustomValidity('Harap isi bidang ini.')" oninput="this.setCustomValidity('')">
                </div>
                <div class="mb-3">
                    <label class="form-label">Password</label>
                    <input type="password" name="password" class="form-control" placeholder="Masukkan password" required autocomplete="new-password" oninvalid="this.setCustomValidity('Harap isi bidang ini.')" oninput="this.setCustomValidity('')">
                </div>
                <button type="submit" name="login" class="btn btn-restoran w-100 py-2 mt-2 rounded-3">Masuk Sekarang</button>
            </form>
        </div>

        <!-- FORM REGISTRASI -->
        <div class="tab-pane fade <?= $active_tab == 'register' ? 'show active' : '' ?>" id="content-register" role="tabpanel">
            <?php if ($error_register) : ?>
                <div class="alert alert-danger py-2 text-center small"><?= $error_register; ?></div>
            <?php endif; ?>

            <form action="" method="POST" autocomplete="off">
                <div class="mb-3">
                    <label class="form-label">Nama Lengkap</label>
                    <input type="text" name="nama_lengkap" class="form-control" placeholder="Nama lengkap Anda" required autocomplete="off" oninvalid="this.setCustomValidity('Harap isi bidang ini.')" oninput="this.setCustomValidity('')">
                </div>
                <div class="mb-3">
                    <label class="form-label">Username</label>
                    <input type="text" name="username" class="form-control" placeholder="Buat username" required autocomplete="one-time-code" oninvalid="this.setCustomValidity('Harap isi bidang ini.')" oninput="this.setCustomValidity('')">
                </div>
                <div class="mb-3">
                    <label class="form-label">Password</label>
                    <input type="password" name="password" class="form-control" placeholder="Buat password" required autocomplete="new-password" oninvalid="this.setCustomValidity('Harap isi bidang ini.')" oninput="this.setCustomValidity('')">
                </div>
                <div class="mb-3">
                    <label class="form-label">Konfirmasi Password</label>
                    <input type="password" name="confirm_password" class="form-control" placeholder="Ulangi password" required autocomplete="new-password" oninvalid="this.setCustomValidity('Harap isi bidang ini.')" oninput="this.setCustomValidity('')">
                </div>
                <button type="submit" name="register" class="btn btn-restoran w-100 py-2 mt-2 rounded-3">Daftar Akun</button>
            </form>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>