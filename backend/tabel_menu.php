<?php 
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
                        <h1 class="h3 mb-0 text-gray-800">Kelola Menu Restoran</h1>
                    </div>

                    <!-- Card Tabel Menu -->
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">Daftar Menu</h6>
                        </div>
                        <div class="card-body">
                            <!-- content start -->
                            <a href="form_menu.php" class="btn btn-danger mb-3"><i class="fas fa-plus fa-sm"></i> Tambah Daftar Menu</a>

                            <div class="table-responsive">
                                <table class="table table-striped table-bordered align-middle">
                                    <thead class="table-light">
                                        <tr>
                                            <th scope="col" class="text-center" style="width: 50px;">No</th>
                                            <th scope="col">Nama Menu</th>
                                            <th scope="col" class="text-center text-nowrap" style="width: 140px;">Foto Makanan</th>
                                            <th scope="col">Kategori</th>
                                            <th scope="col">Harga</th>
                                            <th scope="col" class="text-center">Penilaian</th>
                                            <th scope="col">Deskripsi</th>
                                            <th scope="col" class="text-center" style="width: 160px;">Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $no = 1;
                                        $select_menu = mysqli_query($connection, "SELECT * FROM menu ORDER BY id DESC");
                                        
                                        if ($select_menu && mysqli_num_rows($select_menu) > 0) {
                                            while ($tampil = mysqli_fetch_object($select_menu)) {
                                                
                                                // --- LOGIKA PINTAR CARI GAMBAR ---
                                                $nama_file = trim($tampil->gambar ?? '');
                                                $judul_menu = trim($tampil->title ?? '');
                                                $path_gambar = "";

                                                // 1. Cek file asli di img/
                                                if (!empty($nama_file) && file_exists("img/" . $nama_file)) {
                                                    $path_gambar = "img/" . $nama_file;
                                                } 
                                                // 2. Cek file di img/category/
                                                elseif (!empty($nama_file) && file_exists("img/category/" . $nama_file)) {
                                                    $path_gambar = "img/category/" . $nama_file;
                                                } 
                                                // 3. Cek file berdasarkan Judul Menu (misal Pempek Palembang.jpg)
                                                elseif (file_exists("img/category/" . $judul_menu . ".jpg")) {
                                                    $path_gambar = "img/category/" . $judul_menu . ".jpg";
                                                }
                                                // 4. Spesial untuk Wedang Jahe / wedangjahe.jpg
                                                elseif (file_exists("img/category/wedangjahe.jpg") && stripos($judul_menu, 'wedang') !== false) {
                                                    $path_gambar = "img/category/wedangjahe.jpg";
                                                }
                                                // 5. Cadangan default jika file tidak ada
                                                elseif (file_exists("img/category/burgers.jpg")) {
                                                    $path_gambar = "img/category/burgers.jpg";
                                                }
                                        ?>
                                        <tr>
                                            <td class="text-center"><?= $no++; ?></td>
                                            <td><strong><?= htmlspecialchars($tampil->title ?? ''); ?></strong></td>
                                            
                                            <!-- Tampilan Foto Makanan -->
                                            <td class="text-center">
                                                <?php if (!empty($path_gambar)) : ?>
                                                    <img src="<?= $path_gambar; ?>" 
                                                         alt="<?= htmlspecialchars($tampil->title ?? ''); ?>" 
                                                         class="img-thumbnail" 
                                                         style="max-height: 100px; width: 120px; object-fit: cover;">
                                                <?php else : ?>
                                                    <span class="text-muted">-</span>
                                                <?php endif; ?>
                                            </td>

                                            <td><?= htmlspecialchars($tampil->kategori ?? ''); ?></td>
                                            <td><?= htmlspecialchars($tampil->price ?? ''); ?></td>
                                            <td class="text-center"><?= htmlspecialchars($tampil->rating ?? ''); ?> ⭐</td>
                                            <td><small><?= htmlspecialchars($tampil->deskripsi ?? '-'); ?></small></td>
                                            
                                            <!-- Tombol Aksi -->
                                            <td class="text-center text-nowrap">
                                                <a href="update_form_menu.php?id=<?= $tampil->id; ?>" class="btn btn-sm btn-success me-1">EDIT</a>
                                                <a href="delete_menu.php?id=<?= $tampil->id; ?>" class="btn btn-sm btn-danger" onclick="return confirm('Yakin ingin menghapus menu ini?')">HAPUS</a>
                                            </td>
                                        </tr>
                                        <?php 
                                            }
                                        } else {
                                        ?>
                                        <tr>
                                            <td colspan="8" class="text-center">Belum ada data menu.</td>
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