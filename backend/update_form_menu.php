<?php 
include "connection.php"; 
include "includes/header.php"; 

// 1. Ambil ID menu dari parameter URL
$id = $_GET['id'] ?? null;

if (!$id) {
    header("Location: tabel_menu.php");
    exit();
}

// 2. Query untuk mengambil data menu berdasarkan ID
$query  = mysqli_query($connection, "SELECT * FROM menu WHERE id = '$id'");
$data   = mysqli_fetch_object($query);

// Jika data tidak ditemukan, kembalikan ke tabel
if (!$data) {
    echo "<script>alert('Data menu tidak ditemukan!'); window.location.href='tabel_menu.php';</script>";
    exit();
}

// 3. Pengecekan lokasi foto lama
$nama_file = $data->gambar;
$path_gambar = "";

if (!empty($nama_file)) {
    if (file_exists("img/category/" . $nama_file)) {
        $path_gambar = "img/category/" . $nama_file;
    } elseif (file_exists("../img/category/" . $nama_file)) {
        $path_gambar = "../img/category/" . $nama_file;
    } elseif (file_exists("backend/img/category/" . $nama_file)) {
        $path_gambar = "backend/img/category/" . $nama_file;
    }
}
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
                        <h1 class="h3 mb-0 text-gray-800">Edit Menu Restoran</h1>
                    </div>

                    <!-- Card Form Edit Menu -->
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">Form Edit Data Menu</h6>
                        </div>
                        <div class="card-body">
                            <!-- content start -->
                            <form action="action_update_menu.php" method="POST" enctype="multipart/form-data">
                                
                                <!-- Input Hidden untuk menyimpan ID dan Nama Gambar Lama -->
                                <input type="hidden" name="id" value="<?= $data->id; ?>">
                                <input type="hidden" name="gambar_lama" value="<?= $data->gambar; ?>">

                                <div class="mb-3">
                                    <label for="title" class="form-label font-weight-bold">Nama Menu</label>
                                    <input type="text" class="form-control" id="title" name="title" value="<?= htmlspecialchars($data->title ?? ''); ?>" required>
                                </div>

                                <div class="mb-3">
                                    <label for="kategori" class="form-label font-weight-bold">Kategori</label>
                                    <input type="text" class="form-control" id="kategori" name="kategori" value="<?= htmlspecialchars($data->kategori ?? ''); ?>" required>
                                </div>

                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label for="price" class="form-label font-weight-bold">Harga</label>
                                        <input type="text" class="form-control" id="price" name="price" value="<?= $data->price ?? ''; ?>" required>
                                    </div>

                                    <div class="col-md-6 mb-3">
                                        <label for="rating" class="form-label font-weight-bold">Penilaian</label>
                                        <input type="text" step="0.1" min="0" max="5" class="form-control" id="rating" name="rating" value="<?= $data->rating ?? ''; ?>" required>
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <label for="gambar" class="form-label font-weight-bold">Foto Makanan</label>
                                    
                                    <!-- Display Foto Saat Ini -->
                                    <?php if (!empty($path_gambar)) : ?>
                                        <div class="mb-2">
                                            <img src="<?= $path_gambar; ?>" alt="Foto Menu" class="img-thumbnail" style="max-height: 120px; object-fit: cover;">
                                            <small class="d-block text-muted">Foto saat ini</small>
                                        </div>
                                    <?php endif; ?>

                                    <!-- Atribut required dihilangkan agar user tidak wajib mengganti foto -->
                                    <input type="file" class="form-control" id="gambar" name="gambar" accept="image/*">
                                    <small class="form-text text-muted">Biarkan kosong jika tidak ingin mengubah foto makanan.</small>
                                </div>

                                <div class="mb-4">
                                    <label for="deskripsi" class="form-label font-weight-bold">Deskripsi</label>
                                    <textarea class="form-control" id="deskripsi" name="deskripsi" rows="4" required><?= htmlspecialchars($data->deskripsi ?? ''); ?></textarea>
                                </div>

                                <button type="submit" name="submit" class="btn btn-success">Perbarui Menu</button>
                                <a href="tabel_menu.php" class="btn btn-secondary">Batal</a>

                            </form>
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