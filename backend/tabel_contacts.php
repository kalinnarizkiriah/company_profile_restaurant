<?php 
session_start();

// Proteksi halaman login
if (!isset($_SESSION['login_backend'])) {
    header("Location: login.php");
    exit;
}

include "connection.php"; 

// Ubah status semua pesan menjadi sudah dibaca (1) saat admin membuka halaman ini
mysqli_query($connection, "UPDATE contacts SET status_dibaca = 1 WHERE status_dibaca = 0");

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
                        <h1 class="h3 mb-0 text-gray-800">Kelola Pesan</h1>
                    </div>

                    <!-- Card Tabel Contacts -->
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">Daftar Pesan Masuk</h6>
                        </div>
                        <div class="card-body">
                            <!-- content start -->

                            <div class="table-responsive">
                                <table class="table table-striped table-bordered align-middle">
                                    <thead class="table-light">
                                        <tr>
                                            <th scope="col" class="text-center" style="width: 50px;">No</th>
                                            <th scope="col">Nama</th>
                                            <th scope="col">Email</th>
                                            <th scope="col">No. Telepon</th>
                                            <th scope="col">Subjek</th>
                                            <th scope="col">Pesan</th>
                                            <th scope="col" class="text-center" style="width: 100px;">Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $no = 1;
                                        // Query mengambil data dari tabel contacts
                                        $select_contacts = mysqli_query($connection, "SELECT * FROM contacts ORDER BY id DESC");
                                        
                                        if ($select_contacts && mysqli_num_rows($select_contacts) > 0) :
                                            while ($tampil = mysqli_fetch_object($select_contacts)) :
                                        ?>
                                        <tr>
                                            <td class="text-center"><?= $no++; ?></td>
                                            <td><strong><?= htmlspecialchars($tampil->name); ?></strong></td>
                                            <td><?= htmlspecialchars($tampil->email); ?></td>
                                            <td><?= htmlspecialchars($tampil->phone); ?></td>
                                            <td><span class="badge bg-info text-white"><?= htmlspecialchars($tampil->subject); ?></span></td>
                                            <td><?= htmlspecialchars($tampil->message); ?></td>
                                            <td class="text-center text-nowrap">
                                                <a href="delete_contacts.php?id=<?= $tampil->id; ?>" class="btn btn-sm btn-danger" onclick="return confirm('Yakin ingin menghapus pesan ini?')"><i class="fas fa-trash"></i> Hapus</a>
                                            </td>
                                        </tr>
                                        <?php 
                                            endwhile;
                                        else :
                                        ?>
                                        <tr>
                                            <td colspan="7" class="text-center py-4 text-muted">Belum ada data pesan/kontak.</td>
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