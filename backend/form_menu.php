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
                        <h1 class="h3 mb-0 text-gray-800">Tambah Menu Restaurant</h1>
                    </div>

                    <!-- Card Form Menu -->
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">Form Tambah Data Menu</h6>
                        </div>
                        <div class="card-body">
                            <!-- content start -->
                           <form action="action_insert_menu.php" method="POST" enctype="multipart/form-data">
    
    <div class="mb-3">
        <label for="title" class="form-label font-weight-bold">Nama Menu</label>
        <input type="text" class="form-control" id="title" name="title" required>
    </div>

    <div class="mb-3">
        <label for="kategori" class="form-label font-weight-bold">Kategori</label>
        <input type="text" class="form-control" id="kategori" name="kategori" required>
    </div>

    <div class="row">
        <div class="col-md-6 mb-3">
            <label for="price" class="form-label font-weight-bold">Harga</label>
            <input type="text" class="form-control" id="price" name="price" required>
        </div>

        <div class="col-md-6 mb-3">
            <label for="rating" class="form-label font-weight-bold">Penilaian</label>
            <input type="text" step="0.1" min="0" max="5" class="form-control" id="rating" name="rating" required>
        </div>
    </div>

    <div class="mb-3">
        <label for="gambar" class="form-label font-weight-bold">Foto Makanan</label>
        <input type="file" class="form-control" id="gambar" name="gambar" accept="image/*" required>
    </div>

    <div class="mb-4">
        <label for="deskripsi" class="form-label font-weight-bold">Deskripsi</label>
        <!-- Pastikan name="deskripsi" -->
        <textarea class="form-control" id="deskripsi" name="deskripsi" rows="4" required></textarea>
    </div>

    <button type="submit" name="submit" class="btn btn-primary">Simpan Menu</button>
    <a href="tabel_menu.php" class="btn btn-secondary">Kembali</a>

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