<?php 
include "connection.php"; 
include "includes/header.php"; 

// Ambil ID chefs dari URL
$id = $_GET['id'];

// Query ambil data chef berdasarkan ID
$query = mysqli_query($connection, "SELECT * FROM chefs WHERE id = '$id'");
$data  = mysqli_fetch_array($query);
?>

<body id="page-top">

    <div id="wrapper">

        <!-- Sidebar -->
        <?php include "includes/sidebar.php"; ?>

        <div id="content-wrapper" class="d-flex flex-column">
            <div id="content">

                <!-- Topbar -->
                <?php include "includes/topbar.php"; ?>

                <div class="container-fluid pt-4">

                    <div class="d-sm-flex align-items-center justify-content-between mb-4">
                        <h1 class="h3 mb-0 text-gray-800">Edit Data Koki</h1>
                    </div>

                    <!-- Card Form Update -->
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">Form Edit Koki</h6>
                        </div>
                        <div class="card-body">
                          <form action="action_update_chefs.php" method="post" enctype="multipart/form-data">
    
    <input type="hidden" name="id" value="<?= $data['id']; ?>">
    <!-- Menyimpan path foto lama jika user tidak mengganti foto -->
    <input type="hidden" name="old_photo" value="<?= $data['photo']; ?>">

    <div class="mb-3">
        <label for="name" class="form-label">Nama Koki</label>
        <input type="text" class="form-control" id="name" name="name" value="<?= htmlspecialchars($data['name']); ?>" required>
    </div>

    <div class="mb-3">
        <label for="role" class="form-label">Jabatan</label>
        <input type="text" class="form-control" id="role" name="role" value="<?= htmlspecialchars($data['role']); ?>" required>
    </div>

    <div class="mb-3">
        <label for="experience" class="form-label">Pengalaman</label>
        <input type="text" class="form-control" id="experience" name="experience" value="<?= htmlspecialchars($data['experience']); ?>" min="0" required>
    </div>

    <!-- Input Upload File + Preview Foto Lama -->
    <div class="mb-3">
        <label for="photo" class="form-label">Foto Koki</label>
        <input type="file" class="form-control" id="photo" name="photo" accept="image/*">
        
        <?php if(!empty($data['photo'])): ?>
            <div class="mt-2">
                <small class="text-muted d-block">Foto Saat Ini:</small>
                <img src="<?= $data['photo']; ?>" width="100" class="img-thumbnail mt-1">
            </div>
        <?php endif; ?>
    </div>

    <div class="mb-3">
        <label for="social" class="form-label">Media Sosial</label>
        <input type="text" class="form-control" id="social" name="social" value="<?= htmlspecialchars($data['social']); ?>">
    </div>

    <button type="submit" class="btn btn-success">Perbarui Data</button>
    <a href="tabel_chefs.php" class="btn btn-secondary">Batal</a>

</form>
                        </div>
                    </div>

                </div>

            </div>

            <!-- Footer -->
            <?php include "includes/footer.php"; ?>

        </div>

    </div>

    <?php include "includes/bottom.php"; ?>
</body>
</html>