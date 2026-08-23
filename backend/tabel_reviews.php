<?php 
session_start();

// Proteksi halaman login
if (!isset($_SESSION['login_backend'])) {
    header("Location: login.php");
    exit;
}

include "connection.php"; 

// Update status ulasan yang belum dibaca menjadi sudah dibaca (1)
mysqli_query($connection, "UPDATE reviews SET status_dibaca = 1 WHERE status_dibaca = 0");

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
                        <h1 class="h3 mb-0 text-gray-800">Kelola Ulasan Restoran</h1>
                    </div>

                    <!-- Card Tabel Reviews -->
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">Daftar Ulasan Pelanggan</h6>
                        </div>
                        <div class="card-body">
                            <!-- content start -->

                            <div class="table-responsive">
                                <table class="table table-striped table-bordered align-middle">
                                    <thead class="table-light">
                                        <tr>
                                            <th scope="col" class="text-center" style="width: 50px;">No</th>
                                            <th scope="col" style="width: 200px;">Nama</th>
                                            <th scope="col" class="text-center" style="width: 120px;">Bintang</th>
                                            <th scope="col">Ulasan</th>
                                            <th scope="col" class="text-center" style="width: 100px;">Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $no = 1;
                                        // Query mengambil data dari tabel reviews
                                        $select_reviews = mysqli_query($connection, "SELECT * FROM reviews ORDER BY id DESC");
                                        
                                        if ($select_reviews && mysqli_num_rows($select_reviews) > 0) :
                                            while ($tampil = mysqli_fetch_object($select_reviews)) :
                                        ?>
                                        <tr>
                                            <td class="text-center"><?= $no++; ?></td>
                                            <td><strong><?= htmlspecialchars($tampil->nama); ?></strong></td>
                                            <td class="text-center">
                                                <span class="badge bg-warning text-dark">
                                                    <?= htmlspecialchars($tampil->bintang); ?> ★
                                                </span>
                                            </td>
                                            <td><?= htmlspecialchars($tampil->ulasan); ?></td>
                                            <td class="text-center text-nowrap">
                                                <a href="delete_reviews.php?id=<?= $tampil->id; ?>" class="btn btn-sm btn-danger" onclick="return confirm('Yakin ingin menghapus ulasan ini?')"><i class="fas fa-trash"></i> Hapus</a>
                                            </td>
                                        </tr>
                                        <?php 
                                            endwhile;
                                        else :
                                        ?>
                                        <tr>
                                            <td colspan="5" class="text-center py-4 text-muted">Belum ada data ulasan.</td>
                                        </tr>
                                        <?php endif; ?>
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