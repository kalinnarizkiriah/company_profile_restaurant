<?php 
session_start();

// Proteksi halaman login
if (!isset($_SESSION['login_backend'])) {
    header("Location: login.php");
    exit;
}

include "connection.php"; 

// Mengubah status_dibaca menjadi 1 saat halaman reservasi dibuka
mysqli_query($connection, "UPDATE reservations SET status_dibaca = 1 WHERE status_dibaca = 0");

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
                        <h1 class="h3 mb-0 text-gray-800">Kelola Reservasi Restoran</h1>
                    </div>

                    <!-- Card Tabel Reservations -->
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">Daftar Reservasi</h6>
                        </div>
                        <div class="card-body">
                            <!-- content start -->

                            <div class="table-responsive">
                                <table class="table table-striped table-bordered align-middle">
                                    <thead class="table-light">
                                        <tr>
                                            <th scope="col" class="text-center" style="width: 50px;">No</th>
                                            <th scope="col">Nama Lengkap</th>
                                            <th scope="col">No. Telepon</th>
                                            <th scope="col">Email</th>
                                            <th scope="col" class="text-center">Jumlah Tamu</th>
                                            <th scope="col" class="text-center">Tanggal</th>
                                            <th scope="col" class="text-center">Jam</th>
                                            <th scope="col" class="text-center" style="width: 160px;">Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $no = 1;
                                        // Query mengambil data dari tabel reservations
                                        $select_reservations = mysqli_query($connection, "SELECT * FROM reservations ORDER BY id DESC");
                                        
                                        if ($select_reservations && mysqli_num_rows($select_reservations) > 0) {
                                            while ($tampil = mysqli_fetch_object($select_reservations)) {
                                        ?>
                                        <tr>
                                            <td class="text-center"><?= $no++; ?></td>
                                            <td><strong><?= htmlspecialchars($tampil->full_name); ?></strong></td>
                                            <td><?= htmlspecialchars($tampil->phone); ?></td>
                                            <td><?= htmlspecialchars($tampil->email); ?></td>
                                            <td class="text-center"><?= htmlspecialchars($tampil->guests); ?></td>
                                            <td class="text-center"><?= htmlspecialchars($tampil->date); ?></td>
                                            <td class="text-center"><?= htmlspecialchars($tampil->time); ?></td>
                                            <td class="text-center text-nowrap">
                                                <a href="delete_reservations.php?id=<?= $tampil->id; ?>" class="btn btn-sm btn-danger" onclick="return confirm('Yakin ingin menghapus data reservasi ini?')">HAPUS</a>
                                            </td>
                                        </tr>
                                        <?php 
                                            }
                                        } else {
                                        ?>
                                        <tr>
                                            <td colspan="8" class="text-center py-4 text-muted">Belum ada data reservasi.</td>
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