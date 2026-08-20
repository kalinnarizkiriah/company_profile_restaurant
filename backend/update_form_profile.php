<?php 
include "connection.php"; 
include "includes/header.php"; 

// Ambil ID dari URL (default 1 jika tidak ada)
$id = isset($_GET['id']) ? intval($_GET['id']) : 1;

// Query data profile
$select = mysqli_query($connection, "SELECT * FROM tb_profile WHERE id = '$id'");
$data = mysqli_fetch_object($select);

// Jika data tidak ditemukan
if (!$data) {
    echo "<script>alert('Data tidak ditemukan!'); window.location.href='tabel_profile.php';</script>";
    exit();
}
?>

<body id="page-top">
    <div id="wrapper">
        <?php include "includes/sidebar.php"; ?>

        <div id="content-wrapper" class="d-flex flex-column">
            <div id="content">
                <?php include "includes/topbar.php"; ?>

                <div class="container-fluid pt-4">
                    <div class="d-sm-flex align-items-center justify-content-between mb-4">
                        <h1 class="h3 mb-0 text-gray-800">Edit Data Profile</h1>
                    </div>

                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">Form Edit Profile Restoran</h6>
                        </div>
                        <div class="card-body">
                            <!-- PENTING: Ditambahkan enctype="multipart/form-data" untuk upload file -->
                            <form action="action_update_profile.php" method="POST" enctype="multipart/form-data">
                                <input type="hidden" name="id" value="<?= $data->id; ?>">
                                <input type="hidden" name="gambar_lama" value="<?= htmlspecialchars($data->gambar_hero ?? ''); ?>">

                                <!-- Row 1: Nama -->
                                <div class="row">
                                    <div class="col-md-12 mb-3">
                                        <label class="form-label font-weight-bold">Nama Utama</label>
                                        <input type="text" name="nama" class="form-control" value="<?= htmlspecialchars($data->nama ?? ''); ?>" required>
                                    </div>
                                </div>

                                <!-- Row 2: Deskripsi -->
                                <div class="mb-3">
                                    <label class="form-label font-weight-bold">Deskripsi</label>
                                    <textarea name="deskripsi" class="form-control" rows="3" required><?= htmlspecialchars($data->deskripsi ?? ''); ?></textarea>
                                </div>

                                <!-- Row 3: Element Hero Section -->
                                <div class="row">
                                    <div class="col-md-4 mb-3">
                                        <label class="form-label font-weight-bold">Badge Text</label>
                                        <input type="text" name="badge_text" class="form-control" value="<?= htmlspecialchars($data->badge_text ?? ''); ?>">
                                    </div>
                                    
                                    <!-- Diubah menjadi File Upload -->
                                    <div class="col-md-4 mb-3">
                                        <label class="form-label font-weight-bold">Gambar Hero (Foto)</label>
                                        <input type="file" name="gambar_hero" class="form-control" accept="image/*">
                                        <small class="text-muted d-block mt-1">
                                            Foto saat ini: <b><?= htmlspecialchars($data->gambar_hero ?? 'Tidak ada'); ?></b>
                                        </small>
                                    </div>

                                    <div class="col-md-4 mb-3">
                                        <label class="form-label font-weight-bold">Teks Promo</label>
                                        <input type="text" name="teks_promo" class="form-control" value="<?= htmlspecialchars($data->teks_promo ?? ''); ?>">
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label font-weight-bold">Waktu Pengiriman</label>
                                        <input type="text" name="waktu_pengiriman" class="form-control" value="<?= htmlspecialchars($data->waktu_pengiriman ?? ''); ?>">
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label font-weight-bold">Teks Rating</label>
                                        <input type="text" name="teks_rating" class="form-control" value="<?= htmlspecialchars($data->teks_rating ?? ''); ?>">
                                    </div>
                                </div>

                                <hr class="mt-4 mb-4">
                                <button type="submit" name="update" class="btn btn-success px-4">Simpan Perubahan</button>
                                <a href="tabel_profile.php" class="btn btn-secondary ms-2">Batal</a>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <?php include "includes/footer.php"; ?>
        </div>
    </div>

    <?php include "includes/bottom.php"; ?>
</body>
</html>