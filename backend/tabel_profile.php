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
                    <h1 class="h3 mb-4 text-gray-800 text-uppercase font-weight-bold">PROFILE</h1>

                    <!-- DataTales Card -->
                    <div class="card shadow mb-4">
                        <div class="card-body p-0">
                            <div class="table-responsive">
                                <table class="table table-borderless table-hover mb-0 align-middle" style="font-size: 13px;">
                                    <thead class="bg-light border-bottom text-muted">
                                        <tr>
                                            <th scope="col" style="min-width: 150px;">Nama Utama</th>
                                            <th scope="col" style="min-width: 200px;">Deskripsi</th>
                                            <th scope="col" style="min-width: 120px;">Badge Text</th>
                                            <th scope="col" style="min-width: 100px;">Gambar Hero</th>
                                            <th scope="col" style="min-width: 120px;">Teks Promo</th>
                                            <th scope="col" style="min-width: 120px;">Pengiriman</th>
                                            <th scope="col" style="min-width: 100px;">Rating</th>
                                            <th scope="col" class="text-center" style="width: 90px;">Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $select_profile = mysqli_query($connection, "SELECT * FROM tb_profile ORDER BY id ASC LIMIT 1");
                                        if ($select_profile && mysqli_num_rows($select_profile) > 0) {
                                            while ($profile = mysqli_fetch_object($select_profile)) {
                                        ?>
                                        <tr>
                                            <td class="fw-bold"><strong><?= htmlspecialchars($profile->nama ?? ''); ?></strong></td>
                                            <td class="text-muted" style="line-height: 1.4;"><?= htmlspecialchars($profile->deskripsi ?? ''); ?></td>
                                            <td><span class="badge badge-info"><?= htmlspecialchars($profile->badge_text ?? ''); ?></span></td>
                                            <td>
                                                <?php if(!empty($profile->gambar_hero)): ?>
                                                    <img src="img/category/<?= htmlspecialchars($profile->gambar_hero); ?>" alt="Hero" style="width: 50px; height: 50px; object-fit: cover;" class="rounded border">                                                <?php else: ?>
                                                    <span class="text-muted">-</span>
                                                <?php endif; ?>
                                            </td>
                                            <td><?= htmlspecialchars($profile->teks_promo ?? ''); ?></td>
                                            <td><?= htmlspecialchars($profile->waktu_pengiriman ?? ''); ?></td>
                                            <td><?= htmlspecialchars($profile->teks_rating ?? ''); ?></td>
                                            <td class="text-center align-middle">
                                                <a href="update_form_profile.php?id=<?= $profile->id; ?>" class="btn btn-sm btn-success px-3 font-weight-bold" style="font-size: 11px;">UPDATE</a>
                                            </td>
                                        </tr>
                                        <?php 
                                            }
                                        } else {
                                        ?>
                                        <tr>
                                            <td colspan="8" class="text-center py-4 text-muted">Belum ada data profile.</td>
                                        </tr>
                                        <?php } ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                </div>
                <!-- /.container-fluid -->

            </div>
            <!-- End of Main Content -->

            <!-- Footer -->
            <?php include "includes/footer.php"; ?>

        </div>
    </div>

    <!-- Bottom Scripts -->
    <?php include "includes/bottom.php"; ?>
</body>
</html>