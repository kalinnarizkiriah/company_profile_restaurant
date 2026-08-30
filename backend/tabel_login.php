<?php
session_start();

// 1. Panggil koneksi terlebih dahulu
include "connection.php";

// 2. Tandai semua akun customer baru sebagai "sudah dibaca"
mysqli_query($connection, "UPDATE tabel_login SET is_read = 1 WHERE role = 'customer' AND is_read = 0");

// 3. Cek session login admin
if (!isset($_SESSION['login_backend'])) {
    header("Location: login.php");
    exit;
}

include "includes/header.php";
?>

<body id="page-top">

    <div id="wrapper">

        <!-- Sidebar -->
        <?php include "includes/sidebar.php"; ?>

        <div id="content-wrapper" class="d-flex flex-column">
            <div id="content">

                <!-- Topbar -->
                <?php include "includes/topbar.php"; ?>

                <div class="container-fluid pt-4">

                    <!-- Page Heading -->
                    <div class="d-sm-flex align-items-center justify-content-between mb-4">
                        <h1 class="h3 mb-0 text-gray-800">Kelola Akun Login</h1>
                    </div>

                    <!-- Card Tabel Login -->
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">Daftar Akun Pengguna</h6>
                        </div>
                        <div class="card-body">

                            <div class="table-responsive">
                                <table class="table table-striped table-bordered align-middle">
                                    <thead class="table-light">
                                        <tr>
                                            <th scope="col" class="text-center" style="width: 50px;">No</th>
                                            <th scope="col">Nama Lengkap</th>
                                            <th scope="col">Username</th>
                                            <th scope="col">Password</th>
                                            <th scope="col" class="text-center" style="width: 140px;">Peran</th>
                                            <th scope="col" class="text-center" style="width: 160px;">Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $no = 1;
                                        // Mengurutkan posisi: Super Admin (1), Admin (2), lalu Customer (3)
                                        $query = mysqli_query($connection, "SELECT * FROM tabel_login ORDER BY 
                                            CASE 
                                                WHEN role = 'super_admin' THEN 1
                                                WHEN role = 'admin' THEN 2
                                                ELSE 3
                                            END ASC, id DESC");
                                        
                                        if ($query && mysqli_num_rows($query) > 0) :
                                            while ($data = mysqli_fetch_object($query)) :
                                        ?>
                                        <tr>
                                            <td class="text-center"><?= $no++; ?></td>
                                            <td><strong><?= htmlspecialchars($data->nama_lengkap ?? '-'); ?></strong></td>
                                            <td><?= htmlspecialchars($data->username); ?></td>
                                            <td><code><?= htmlspecialchars($data->password); ?></code></td>
                                            <td class="text-center">
                                                <?php if (strtolower($data->role ?? '') == 'super_admin') : ?>
                                                    <span class="badge bg-danger text-white px-2 py-1">Super Admin</span>
                                                <?php elseif (strtolower($data->role ?? '') == 'admin') : ?>
                                                    <span class="badge bg-primary text-white px-2 py-1">Admin</span>
                                                <?php else : ?>
                                                    <span class="badge bg-info text-white px-2 py-1">Customer</span>
                                                <?php endif; ?>
                                            </td>
                                            <td class="text-center text-nowrap">
                                                <?php if (strtolower($data->role ?? '') !== 'super_admin') : ?>
                                                    <a href="delete_login.php?id=<?= $data->id; ?>" class="btn btn-sm btn-danger" onclick="return confirm('Yakin ingin menghapus akun ini?')">HAPUS</a>
                                                <?php else : ?>
                                                    <span class="text-muted small fst-italic">Utama (Protected)</span>
                                                <?php endif; ?>
                                            </td>
                                        </tr>
                                        <?php 
                                            endwhile;
                                        else :
                                        ?>
                                        <tr>
                                            <td colspan="6" class="text-center py-4 text-muted">Belum ada data akun terdaftar.</td>
                                        </tr>
                                        <?php endif; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                </div>

            </div>

            <!-- Footer -->
            <?php include "includes/footer.php"; ?>

        </div>

    </div>

    <!-- Bottom Scripts -->
    <?php include "includes/bottom.php"; ?>
</body>
</html>