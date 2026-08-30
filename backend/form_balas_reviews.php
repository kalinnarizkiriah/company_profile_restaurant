<?php 
session_start();

if (!isset($_SESSION['login_backend'])) {
    header("Location: login.php");
    exit;
}

include "connection.php"; 

$id = $_GET['id'] ?? null;
if (!$id) {
    header("Location: tabel_reviews.php");
    exit;
}

// Ambil data ulasan berdasarkan ID
$query = mysqli_query($connection, "SELECT * FROM reviews WHERE id = '$id'");
$data = mysqli_fetch_object($query);

if (!$data) {
    header("Location: tabel_reviews.php");
    exit;
}

// Proses Simpan Balasan
if (isset($_POST['submit_balasan'])) {
    $balasan = mysqli_real_escape_string($connection, $_POST['balasan']);
    
    $update = mysqli_query($connection, "UPDATE reviews SET balasan = '$balasan' WHERE id = '$id'");
    
    if ($update) {
        header("Location: tabel_reviews.php");
        exit;
    }
}

include "includes/header.php"; 
?>

<body id="page-top">
    <div id="wrapper">
        <?php include "includes/sidebar.php"; ?>
        
        <div id="content-wrapper" class="d-flex flex-column">
            <div id="content">
                <?php include "includes/topbar.php"; ?>

                <div class="container-fluid pt-4">
                    <div class="d-sm-flex align-items-center justify-content-between mb-4">
                        <h1 class="h3 mb-0 text-gray-800">Balas Ulasan Pelanggan</h1>
                        <a href="tabel_reviews.php" class="btn btn-secondary btn-sm"><i class="fas fa-arrow-left"></i> Kembali</a>
                    </div>

                    <div class="card shadow mb-4" style="max-width: 700px;">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">Form Balasan</h6>
                        </div>
                        <div class="card-body">
                            <form action="" method="POST">
                                <div class="mb-3">
                                    <label class="form-label fw-bold">Nama Pelanggan:</label>
                                    <input type="text" class="form-control" value="<?= htmlspecialchars($data->nama); ?>" readonly>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label fw-bold">Ulasan:</label>
                                    <textarea class="form-control" rows="3" readonly><?= htmlspecialchars($data->ulasan); ?></textarea>
                                </div>
                                <div class="mb-3">
                                    <label for="balasan" class="form-label fw-bold">Tulis Balasan Admin <span class="text-danger">*</span></label>
                                    <textarea class="form-control" name="balasan" rows="4" required placeholder="Ketik balasan untuk pelanggan di sini..."><?= htmlspecialchars($data->balasan ?? ''); ?></textarea>
                                </div>
                                <button type="submit" name="submit_balasan" class="btn btn-primary"><i class="fas fa-save"></i> Simpan Balasan</button>
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