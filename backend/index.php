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
                        <h1 class="h3 mb-0 text-gray-800">Dashboard</h1>
                    </div>

                    <!-- Welcome Card / Content Dashboard -->
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">Selamat datang di Backend Restoran</h6>
                        </div>
                        <div class="card-body">
                            <!-- content start -->
                            <h5>Halo, Selamat Datang! 👋</h5>
                            <p class="mt-3">
                                Silakan pilih menu pada <strong>sidebar sebelah kiri</strong> untuk mulai mengelola data restoran Anda (seperti Daftar Menu, Koki, dan tabel lainnya).
                            </p>
                            <hr>
                            <a href="tabel_menu.php" class="btn btn-primary">
                                <i class="fas fa-utensils fa-sm mr-1"></i>Kelola Daftar Menu
                            </a>
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