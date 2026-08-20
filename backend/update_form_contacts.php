<?php 
include "connection.php"; 
include "includes/header.php"; 

// Ambil ID contact dari URL
$id = mysqli_real_escape_string($connection, $_GET['id']);

// Query ambil data contacts berdasarkan ID
$query = mysqli_query($connection, "SELECT * FROM contacts WHERE id = '$id'");
$data  = mysqli_fetch_array($query);

// Jika data tidak ditemukan, kembalikan ke tabel contacts
if (!$data) {
    header("Location: tabel_contacts.php");
    exit();
}
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
                        <h1 class="h3 mb-0 text-gray-800">Edit Data Kontak</h1>
                    </div>

                    <!-- Card Form Update -->
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">Form Edit Contacts</h6>
                        </div>
                        <div class="card-body">
                            <form action="action_update_contacts.php" method="post">
    
                                <!-- Hidden ID -->
                                <input type="hidden" name="id" value="<?= $data['id']; ?>">

                                <div class="row">
                                    <!-- Nama (name) -->
                                    <div class="col-md-6 mb-3">
                                        <label for="name" class="form-label">Nama Lengkap</label>
                                        <input type="text" class="form-control" id="name" name="name" value="<?= htmlspecialchars($data['name']); ?>" required>
                                    </div>

                                    <!-- Email -->
                                    <div class="col-md-6 mb-3">
                                        <label for="email" class="form-label">Email</label>
                                        <input type="email" class="form-control" id="email" name="email" value="<?= htmlspecialchars($data['email']); ?>" required>
                                    </div>
                                </div>

                                <div class="row">
                                    <!-- Phone -->
                                    <div class="col-md-6 mb-3">
                                        <label for="phone" class="form-label">No. Telepon / HP</label>
                                        <input type="text" class="form-control" id="phone" name="phone" value="<?= htmlspecialchars($data['phone']); ?>" required>
                                    </div>

                                    <!-- Subject -->
                                    <div class="col-md-6 mb-3">
                                        <label for="subject" class="form-label">Subjek</label>
                                        <input type="text" class="form-control" id="subject" name="subject" value="<?= htmlspecialchars($data['subject']); ?>" required>
                                    </div>
                                </div>

                                <!-- Message -->
                                <div class="mb-3">
                                    <label for="message" class="form-label">Pesan</label>
                                    <textarea class="form-control" id="message" name="message" rows="4" required><?= htmlspecialchars($data['message']); ?></textarea>
                                </div>

                                <button type="submit" class="btn btn-success"><i class="fas fa-save fa-sm"></i> Perbarui Data</button>
                                <a href="tabel_contacts.php" class="btn btn-secondary">Batal</a>

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