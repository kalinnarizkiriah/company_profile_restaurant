<?php 
include "connection.php"; 
include "includes/header.php"; 
?>

<body id="page-top">

    <!-- Page Wrapper -->
    <div id="wrapper">

        <!-- Sidebar -->
        <?php include "includes/sidebar.php"; ?>

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content">

                <!-- Topbar -->
                <?php include "includes/topbar.php"; ?>

                <!-- Begin Page Content -->
                <div class="container-fluid pt-4">

                    <!-- Page Heading -->
                    <div class="d-sm-flex align-items-center justify-content-between mb-4">
                        <h1 class="h3 mb-0 text-gray-800">Tambah Koki Baru</h1>
                    </div>

                    <!-- Card Form -->
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">Form Tambah Koki</h6>
                        </div>
                        <div class="card-body">
                            <!-- content start -->
                            <form action="action_insert_chefs.php" method="post" enctype="multipart/form-data">

                                <div class="mb-3">
                                    <label for="name" class="form-label">Nama Koki</label>
                                    <input type="text" class="form-control" id="name" name="name" required>
                                </div>

                                <div class="mb-3">
                                    <label for="role" class="form-label">Jabatan</label>
                                    <input type="text" class="form-control" id="role" name="role" required>
                                </div>

                                <div class="mb-3">
                                    <label for="experience" class="form-label">Pengalaman</label>
                                    <input type="text" class="form-control" id="experience" name="experience" required>
                                </div>

                                <!-- Input Foto Koki -->
                                <div class="mb-3">
                                    <label for="photo" class="form-label">Foto Koki</label>
                                    <input type="file" class="form-control" id="photo" name="photo" accept="image/*" required>
                                </div>

                                <div class="mb-3">
                                    <label for="social" class="form-label">Media Sosial</label>
                                    <input type="text" class="form-control" id="social" name="social">
                                </div>

                                <button type="submit" class="btn btn-primary">Kirim</button>
                                <a href="tabel_chefs.php" class="btn btn-secondary">Kembali</a>

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

        </div>
        <!-- End of Content Wrapper -->

    </div>
    <!-- End of Page Wrapper -->

    <!-- Scroll to Top / Bottom Scripts -->
    <?php include "includes/bottom.php"; ?>
</body>
</html>