<?php 
session_start();

// Proteksi agar halaman tidak bisa diakses jika belum login
if (!isset($_SESSION['login_backend'])) {
    header("Location: login.php");
    exit;
}

include "connection.php"; 

$message = "";
$message_type = "";

// 1. Proses Simpan / Update Data jika Form Dikirim (POST)
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id                = $_POST['id'] ?? 1;
    $tahun_pengalaman  = mysqli_real_escape_string($connection, $_POST['tahun_pengalaman']);
    $judul_utama       = mysqli_real_escape_string($connection, $_POST['judul_utama']);
    $deskripsi_singkat = mysqli_real_escape_string($connection, $_POST['deskripsi_singkat']);

    $poin_1_judul      = mysqli_real_escape_string($connection, $_POST['poin_1_judul']);
    $poin_1_desc       = mysqli_real_escape_string($connection, $_POST['poin_1_desc']);

    $poin_2_judul      = mysqli_real_escape_string($connection, $_POST['poin_2_judul']);
    $poin_2_desc       = mysqli_real_escape_string($connection, $_POST['poin_2_desc']);

    $poin_3_judul      = mysqli_real_escape_string($connection, $_POST['poin_3_judul']);
    $poin_3_desc       = mysqli_real_escape_string($connection, $_POST['poin_3_desc']);

    // Ambil data nama gambar lama
    $gambar_1 = $_POST['gambar_1_lama'] ?? '';
    $gambar_2 = $_POST['gambar_2_lama'] ?? '';

    // Folder tujuan upload gambar di backend
    $target_dir = "img/";
    if (!file_exists($target_dir)) {
        mkdir($target_dir, 0777, true);
    }

    // Upload Gambar 1 (Utama) jika ada file baru
    if (!empty($_FILES['gambar_1']['name'])) {
        $file_name1 = time() . '_1_' . basename($_FILES['gambar_1']['name']);
        if (move_uploaded_file($_FILES['gambar_1']['tmp_name'], $target_dir . $file_name1)) {
            $gambar_1 = $file_name1;
        }
    }

    // Upload Gambar 2 (Kecil Overlay) jika ada file baru
    if (!empty($_FILES['gambar_2']['name'])) {
        $file_name2 = time() . '_2_' . basename($_FILES['gambar_2']['name']);
        if (move_uploaded_file($_FILES['gambar_2']['tmp_name'], $target_dir . $file_name2)) {
            $gambar_2 = $file_name2;
        }
    }

    // Cek apakah data sudah ada di database
    $check_query = mysqli_query($connection, "SELECT id FROM about WHERE id = '$id'");

    if (mysqli_num_rows($check_query) > 0) {
        $sql = "UPDATE about SET 
                    tahun_pengalaman  = '$tahun_pengalaman',
                    judul_utama       = '$judul_utama',
                    deskripsi_singkat = '$deskripsi_singkat',
                    poin_1_judul      = '$poin_1_judul',
                    poin_1_desc       = '$poin_1_desc',
                    poin_2_judul      = '$poin_2_judul',
                    poin_2_desc       = '$poin_2_desc',
                    poin_3_judul      = '$poin_3_judul',
                    poin_3_desc       = '$poin_3_desc',
                    gambar_1          = '$gambar_1',
                    gambar_2          = '$gambar_2'
                WHERE id = '$id'";
    } else {
        $sql = "INSERT INTO about (id, tahun_pengalaman, judul_utama, deskripsi_singkat, poin_1_judul, poin_1_desc, poin_2_judul, poin_2_desc, poin_3_judul, poin_3_desc, gambar_1, gambar_2) 
                VALUES ('$id', '$tahun_pengalaman', '$judul_utama', '$deskripsi_singkat', '$poin_1_judul', '$poin_1_desc', '$poin_2_judul', '$poin_2_desc', '$poin_3_judul', '$poin_3_desc', '$gambar_1', '$gambar_2')";
    }

    if (mysqli_query($connection, $sql)) {
        $message = "Data tentang restoran berhasil diperbarui!";
        $message_type = "success";
    } else {
        $message = "Gagal memperbarui data: " . mysqli_error($connection);
        $message_type = "danger";
    }
}

// 2. Ambil Data Terbaru dari Database
$query = mysqli_query($connection, "SELECT * FROM about LIMIT 1");
$data = mysqli_fetch_assoc($query) ?? [];

include "includes/header.php"; 
?>

<body id="page-top">
    <div id="wrapper">
        <?php include "includes/sidebar.php"; ?>

        <div id="content-wrapper" class="d-flex flex-column">
            <div id="content">
                <?php include "includes/topbar.php"; ?>

                <div class="container-fluid pt-4">
                    <h1 class="h3 mb-4 text-gray-800">Kelola Tentang Restoran</h1>

                    <?php if (!empty($message)): ?>
                        <div class="alert alert-<?= $message_type; ?> alert-dismissible fade show" role="alert">
                            <?= $message; ?>
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    <?php endif; ?>

                    <form action="" method="POST" enctype="multipart/form-data">
                        <input type="hidden" name="id" value="<?= $data['id'] ?? 1; ?>">
                        <input type="hidden" name="gambar_1_lama" value="<?= htmlspecialchars($data['gambar_1'] ?? ''); ?>">
                        <input type="hidden" name="gambar_2_lama" value="<?= htmlspecialchars($data['gambar_2'] ?? ''); ?>">

                        <!-- CARD 1: INFORMASI UTAMA -->
                        <div class="card shadow mb-4">
                            <div class="card-header py-3">
                                <h6 class="m-0 font-weight-bold text-primary"><i class="fas fa-edit me-1"></i> Informasi Utama</h6>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-4 mb-3">
                                        <label class="font-weight-bold">Badge Pengalaman</label>
                                        <input type="text" name="tahun_pengalaman" class="form-control" value="<?= htmlspecialchars($data['tahun_pengalaman'] ?? '12+ Years of Excellence'); ?>" required>
                                    </div>
                                    <div class="col-md-8 mb-3">
                                        <label class="font-weight-bold">Judul Utama</label>
                                        <input type="text" name="judul_utama" class="form-control" value="<?= htmlspecialchars($data['judul_utama'] ?? ''); ?>" required>
                                    </div>
                                    <div class="col-12 mb-3">
                                        <label class="font-weight-bold">Deskripsi / Cerita Restoran</label>
                                        <textarea name="deskripsi_singkat" class="form-control" rows="4" required><?= htmlspecialchars($data['deskripsi_singkat'] ?? ''); ?></textarea>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- CARD 2: 3 POIN KEUNGGULAN -->
                        <div class="card shadow mb-4">
                            <div class="card-header py-3">
                                <h6 class="m-0 font-weight-bold text-primary"><i class="fas fa-list me-1"></i> 3 Poin Keunggulan Restoran</h6>
                            </div>
                            <div class="card-body">
                                <!-- POIN 1 -->
                                <div class="row border-bottom pb-3 mb-3">
                                    <div class="col-md-4 mb-2">
                                        <label class="font-weight-bold">Judul Poin 1</label>
                                        <input type="text" name="poin_1_judul" class="form-control" value="<?= htmlspecialchars($data['poin_1_judul'] ?? ''); ?>" required>
                                    </div>
                                    <div class="col-md-8 mb-2">
                                        <label class="font-weight-bold">Deskripsi Poin 1</label>
                                        <input type="text" name="poin_1_desc" class="form-control" value="<?= htmlspecialchars($data['poin_1_desc'] ?? ''); ?>" required>
                                    </div>
                                </div>

                                <!-- POIN 2 -->
                                <div class="row border-bottom pb-3 mb-3">
                                    <div class="col-md-4 mb-2">
                                        <label class="font-weight-bold">Judul Poin 2</label>
                                        <input type="text" name="poin_2_judul" class="form-control" value="<?= htmlspecialchars($data['poin_2_judul'] ?? ''); ?>" required>
                                    </div>
                                    <div class="col-md-8 mb-2">
                                        <label class="font-weight-bold">Deskripsi Poin 2</label>
                                        <input type="text" name="poin_2_desc" class="form-control" value="<?= htmlspecialchars($data['poin_2_desc'] ?? ''); ?>" required>
                                    </div>
                                </div>

                                <!-- POIN 3 -->
                                <div class="row">
                                    <div class="col-md-4 mb-2">
                                        <label class="font-weight-bold">Judul Poin 3</label>
                                        <input type="text" name="poin_3_judul" class="form-control" value="<?= htmlspecialchars($data['poin_3_judul'] ?? ''); ?>" required>
                                    </div>
                                    <div class="col-md-8 mb-2">
                                        <label class="font-weight-bold">Deskripsi Poin 3</label>
                                        <input type="text" name="poin_3_desc" class="form-control" value="<?= htmlspecialchars($data['poin_3_desc'] ?? ''); ?>" required>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- CARD 3: UPLOAD GAMBAR -->
                        <div class="card shadow mb-4">
                            <div class="card-header py-3">
                                <h6 class="m-0 font-weight-bold text-primary"><i class="fas fa-image me-1"></i> Foto / Gambar Restoran</h6>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <!-- GAMBAR 1 -->
                                    <div class="col-md-6 mb-3">
                                        <label class="font-weight-bold">Gambar Utama (Besar)</label>
                                        <div class="d-flex align-items-center">
                                            <?php if (!empty($data['gambar_1']) && file_exists("img/" . $data['gambar_1'])): ?>
                                                <img src="img/<?= htmlspecialchars($data['gambar_1']); ?>" class="img-thumbnail mr-3" style="width: 100px; height: 80px; object-fit: cover;">
                                            <?php endif; ?>
                                            <input type="file" name="gambar_1" class="form-control-file" accept="image/*">
                                        </div>
                                    </div>

                                    <!-- GAMBAR 2 -->
                                    <div class="col-md-6 mb-3">
                                        <label class="font-weight-bold">Gambar Kecil (Overlay)</label>
                                        <div class="d-flex align-items-center">
                                            <?php if (!empty($data['gambar_2']) && file_exists("img/" . $data['gambar_2'])): ?>
                                                <img src="img/<?= htmlspecialchars($data['gambar_2']); ?>" class="img-thumbnail mr-3" style="width: 100px; height: 80px; object-fit: cover;">
                                            <?php endif; ?>
                                            <input type="file" name="gambar_2" class="form-control-file" accept="image/*">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="text-right mb-4">
                            <button type="submit" class="btn btn-primary btn-lg shadow-sm"><i class="fas fa-save me-2"></i>Simpan Perubahan</button>
                        </div>
                    </form>
                </div>

            </div>
            <?php include "includes/footer.php"; ?>
        </div>
    </div>
    <?php include "includes/bottom.php"; ?>
</body>
</html>