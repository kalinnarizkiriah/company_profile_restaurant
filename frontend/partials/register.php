<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrasi Akun - Resto Jogja</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body { background-color: #f8f9fa; }
        .register-card { max-width: 450px; border-radius: 15px; border: none; }
    </style>
</head>
<body class="d-flex align-items-center justify-content-center min-vh-100 py-5">

    <div class="card shadow register-card w-100 p-4">
        <div class="card-body">
            <div class="text-center mb-4">
                <h3 class="fw-bold text-danger">Resto Jogja</h3>
                <p class="text-muted">Buat akun untuk mulai memesan</p>
            </div>

            <form action="../backend/action_insert_login.php" method="POST">
                
                <div class="mb-3">
                    <label class="form-label font-weight-bold">Nama Lengkap</label>
                    <input type="text" name="nama_lengkap" class="form-control" placeholder="Masukkan nama lengkap" required>
                </div>

                <div class="mb-3">
                    <label class="form-label font-weight-bold">Email</label>
                    <input type="email" name="email" class="form-control" placeholder="contoh: user@gmail.com" required>
                </div>

                <div class="mb-3">
                    <label class="form-label font-weight-bold">Username</label>
                    <input type="text" name="username" class="form-control" placeholder="Masukkan username" required>
                </div>

                <div class="mb-4">
                    <label class="form-label font-weight-bold">Password</label>
                    <input type="password" name="password" class="form-control" placeholder="Masukkan password" required>
                </div>

                <input type="hidden" name="role" value="customer">

                <button type="submit" class="btn btn-danger w-100 py-2 fw-bold mb-3">Daftar Sekarang</button>

                <div class="text-center">
                    <a href="index.php" class="text-decoration-none text-muted"><i class="fas fa-arrow-left me-1"></i> Kembali ke Beranda</a>
                </div>

            </form>
        </div>
    </div>

</body>
</html>