<?php 
include "connection.php"; 
include "includes/header.php"; 

// Ambil ID reservations dari URL
$id = $_GET['id'];

// Query ambil data reservasi berdasarkan ID
$query = mysqli_query($connection, "SELECT * FROM reservations WHERE id = '$id'");
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
                        <h1 class="h3 mb-0 text-gray-800">Edit Data Reservasi</h1>
                    </div>

                    <!-- Card Form Update -->
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">Form Edit Reservasi</h6>
                        </div>
                        <div class="card-body">
                            <form action="action_update_reservations.php" method="post">
    
                                <input type="hidden" name="id" value="<?= $data['id']; ?>">

                                <div class="mb-3">
                                    <label for="full_name" class="form-label">Nama Lengkap</label>
                                    <input type="text" class="form-control" id="full_name" name="full_name" value="<?= htmlspecialchars($data['full_name']); ?>" required>
                                </div>

                                <div class="mb-3">
                                    <label for="phone" class="form-label">No. Telepon</label>
                                    <input type="text" class="form-control" id="phone" name="phone" value="<?= htmlspecialchars($data['phone']); ?>" required>
                                </div>

                                <div class="mb-3">
                                    <label for="email" class="form-label">Email</label>
                                    <input type="email" class="form-control" id="email" name="email" value="<?= htmlspecialchars($data['email']); ?>" required>
                                </div>

                                <div class="mb-3">
                                    <label for="guests" class="form-label">Jumlah Tamu</label>
                                    <input type="text" class="form-control" id="guests" name="guests" value="<?= htmlspecialchars($data['guests']); ?>" required>
                                </div>

                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label for="date" class="form-label">Tanggal</label>
                                        <input type="date" class="form-control" id="date" name="date" value="<?= $data['date']; ?>" required>
                                    </div>

                                    <div class="col-md-6 mb-3">
                                        <label for="time" class="form-label">Jam</label>
                                        <input type="time" class="form-control" id="time" name="time" value="<?= $data['time']; ?>" required>
                                    </div>
                                </div>

                    

                                <button type="submit" class="btn btn-success">Perbarui Data</button>
                                <a href="tabel_reservations.php" class="btn btn-secondary">Batal</a>

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