<?php 
session_start();

// Proteksi halaman login
if (!isset($_SESSION['login_backend'])) {
    header("Location: login.php");
    exit;
}

include "connection.php"; 
include "includes/header.php"; 
?>

<body id="page-top">

    <!-- Page Wrapper -->
    <div id="wrapper">

        <!-- Sidebar -->
        <?php include "includes/sidebar.php"; ?>
        <!-- End of Sidebar -->
        
        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content">

                <!-- Topbar -->
                <?php include "includes/topbar.php"; ?>
                <!-- End of Topbar -->

                <!-- Begin Page Content -->
                <div class="container-fluid pt-4">

                    <!-- Page Heading -->
                    <div class="d-sm-flex align-items-center justify-content-between mb-4">
                        <h1 class="h3 mb-0 text-gray-800">Kelola Koki Restoran</h1>
                    </div>

                    <!-- Card Tabel Chefs -->
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">Daftar Koki</h6>
                        </div>
                        <div class="card-body">
                            <!-- content start -->
                            <a href="form_chefs.php" class="btn btn-primary mb-3"><i class="fas fa-plus fa-sm"></i> Tambah Koki Baru</a>

                            <div class="table-responsive">
                                <table class="table table-striped table-bordered align-middle">
                                    <thead class="table-light">
                                        <tr>
                                            <th scope="col" class="text-center" style="width: 50px;">No</th>
                                            <th scope="col" class="text-center" style="width: 100px;">Foto</th>
                                            <th scope="col">Nama Koki</th>
                                            <th scope="col">Jabatan</th>
                                            <th scope="col">Pengalaman</th>
                                            <th scope="col">Media Sosial</th>
                                            <th scope="col" class="text-center" style="width: 160px;">Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $no = 1;
                                        $select_chefs = mysqli_query($connection, "SELECT * FROM chefs ORDER BY id DESC");
                                        
                                        if ($select_chefs && mysqli_num_rows($select_chefs) > 0) {
                                            while ($tampil = mysqli_fetch_object($select_chefs)) {
                                        ?>
                                        <tr>
                                            <td class="text-center"><?= $no++; ?></td>
                                            <td class="text-center">
                                                <!-- Foto Bulat Sempurna Presisi di Tengah -->
                                                <?php if (!empty($tampil->photo)): ?>
                                                    <img src="<?= htmlspecialchars($tampil->photo); ?>" 
                                                         alt="<?= htmlspecialchars($tampil->name); ?>" 
                                                         style="width: 65px !important; height: 65px !important; object-fit: cover; border-radius: 50%;">
                                                <?php else: ?>
                                                    <span class="badge bg-secondary">Tidak Ada Foto</span>
                                                <?php endif; ?>
                                            </td>
                                            <td><strong><?= htmlspecialchars($tampil->name); ?></strong></td>
                                            <td><?= htmlspecialchars($tampil->role); ?></td>
                                            <td><?= htmlspecialchars($tampil->experience); ?> Tahun</td>
                                            <td>
                                                <?php 
                                                $social = $tampil->social;
                                                $socialJson = json_decode($social, true);

                                                // 1. Jika data berbentuk format JSON
                                                if (json_last_error() === JSON_ERROR_NONE && is_array($socialJson)) {
                                                    foreach ($socialJson as $platform => $link) {
                                                        if (!empty($link) && $link !== '#') {
                                                            echo '<a href="' . htmlspecialchars($link) . '" target="_blank" class="btn btn-sm btn-outline-primary me-1 mb-1">' . ucfirst($platform) . '</a>';
                                                        }
                                                    }
                                                } 
                                                // 2. Jika data berupa URL langsung
                                                elseif (filter_var($social, FILTER_VALIDATE_URL)) {
                                                    echo '<a href="' . htmlspecialchars($social) . '" target="_blank" class="btn btn-sm btn-outline-primary"><i class="fas fa-external-link-alt me-1"></i> Buka Link</a>';
                                                } 
                                                // 3. Jika teks biasa
                                                elseif (!empty($social)) {
                                                    $url = (strpos($social, 'http') === 0) ? $social : 'https://' . $social;
                                                    echo '<a href="' . htmlspecialchars($url) . '" target="_blank" class="text-primary fw-bold">' . htmlspecialchars($social) . '</a>';
                                                } 
                                                // 4. Jika kosong
                                                else {
                                                    echo '<span class="text-muted">-</span>';
                                                }
                                                ?>
                                            </td>
                                            <td class="text-center text-nowrap">
                                                <a href="update_form_chefs.php?id=<?= $tampil->id; ?>" class="btn btn-sm btn-success me-1">EDIT</a>
                                                <a href="delete_chefs.php?id=<?= $tampil->id; ?>" class="btn btn-sm btn-danger" onclick="return confirm('Yakin ingin menghapus data chef ini?')">HAPUS</a>
                                            </td>
                                        </tr>
                                        <?php 
                                            }
                                        } else {
                                        ?>
                                        <tr>
                                            <td colspan="7" class="text-center py-4 text-muted">Belum ada data chef.</td>
                                        </tr>
                                        <?php } ?>
                                    </tbody>
                                </table>
                            </div>
                            <!-- content end -->
                        </div>
                    </div>

                </div>
                <!-- /.container-fluid -->

            </div>
            <!-- End of Main Content -->

            <!-- Footer -->
            <?php include "includes/footer.php"; ?>
            <!-- End of Footer -->

        </div>
        <!-- End of Content Wrapper -->

    </div>
    <!-- End of Page Wrapper -->

    <!-- Bottom Scripts -->
    <?php include "includes/bottom.php"; ?>
</body>
</html>