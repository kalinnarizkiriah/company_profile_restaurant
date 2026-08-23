<?php 
session_start();

// Proteksi halaman login
if (!isset($_SESSION['login_backend'])) {
    header("Location: login.php");
    exit;
}

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
                        <h1 class="h3 mb-0 text-gray-800">Kelola Pesanan</h1>
                    </div>

                    <!-- Card Tabel Pesanan -->
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">Daftar Pesanan Masuk</h6>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered align-middle">
                                    <thead class="table-light">
                                        <tr>
                                            <th scope="col" class="text-center" style="width: 50px;">No</th>
                                            <th scope="col">No. Pesanan</th>
                                            <th scope="col">Nama Pemesan</th>
                                            <th scope="col">No. HP / WA</th>
                                            <th scope="col">Tipe</th>
                                            <th scope="col">Catatan / No. Meja</th> <!-- Kolom Baru -->
                                            <th scope="col">Pembayaran</th>
                                            <th scope="col">Total Bayar</th>
                                            <th scope="col">Status</th>
                                            <th scope="col">Waktu</th>
                                            <th scope="col" class="text-center" style="width: 180px;">Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $no = 1;
                                        $select_pesanan = mysqli_query($connection, "SELECT * FROM pesanan ORDER BY id DESC");
                                        
                                        if ($select_pesanan && mysqli_num_rows($select_pesanan) > 0) :
                                            while ($tampil = mysqli_fetch_object($select_pesanan)) :
                                        ?>
                                        <tr>
                                            <td class="text-center"><?= $no++; ?></td>
                                            <td><strong class="text-danger"><?= htmlspecialchars($tampil->no_pesanan); ?></strong></td>
                                            <td><?= htmlspecialchars($tampil->nama_pemesan); ?></td>
                                            <td><?= htmlspecialchars($tampil->no_hp); ?></td>
                                            <td><span class="badge bg-secondary text-white"><?= htmlspecialchars($tampil->tipe_pesanan); ?></span></td>
                                            
                                            <!-- Menampilkan Data Catatan / Nomor Meja -->
                                            <td><?= !empty($tampil->catatan) ? htmlspecialchars($tampil->catatan) : '<span class="text-muted">-</span>'; ?></td>
                                            
                                            <td><?= htmlspecialchars($tampil->metode_pembayaran); ?></td>
                                            <td class="fw-bold">Rp <?= number_format($tampil->total_bayar, 0, ',', '.'); ?></td>
                                            <td>
                                                <?php if ($tampil->status_pesanan == 'Menunggu Konfirmasi' || $tampil->status_pesanan == 'Menunggu Pembayaran di Kasir') : ?>
                                                    <span class="badge bg-warning text-dark"><?= htmlspecialchars($tampil->status_pesanan); ?></span>
                                                <?php elseif ($tampil->status_pesanan == 'Diproses') : ?>
                                                    <span class="badge bg-info text-dark"><?= htmlspecialchars($tampil->status_pesanan); ?></span>
                                                <?php else : ?>
                                                    <span class="badge bg-success text-white"><?= htmlspecialchars($tampil->status_pesanan); ?></span>
                                                <?php endif; ?>
                                            </td>
                                            <td><small class="text-muted"><?= htmlspecialchars($tampil->tanggal); ?></small></td>
                                            <td class="text-center text-nowrap">
                                                <!-- Tombol Ubah Status Langsung -->
                                                <a href="update_status.php?id=<?= $tampil->id; ?>&status=Diproses" class="btn btn-sm btn-info text-dark fw-bold" title="Ubah ke Diproses">
                                                    <i class="fas fa-spinner"></i> Proses
                                                </a>
                                                <a href="update_status.php?id=<?= $tampil->id; ?>&status=Selesai" class="btn btn-sm btn-success fw-bold" title="Ubah ke Selesai">
                                                    <i class="fas fa-check"></i> Selesai
                                                </a>

                                                <!-- Tombol Hapus -->
                                                <a href="delete_pesanan.php?id=<?= $tampil->id; ?>" class="btn btn-sm btn-danger" onclick="return confirm('Yakin ingin menghapus data pesanan ini?')" title="Hapus">
                                                    <i class="fas fa-trash"></i>
                                                </a>
                                            </td>
                                        </tr>
                                        <?php 
                                            endwhile;
                                        else :
                                        ?>
                                        <tr>
                                            <td colspan="11" class="text-center py-4 text-muted">Belum ada pesanan masuk.</td>
                                        </tr>
                                        <?php endif; ?>
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
            <!-- End of Footer -->

        </div>
        <!-- End of Content Wrapper -->

    </div>
    <!-- End of Page Wrapper -->

    <!-- Bottom Scripts -->
    <?php include "includes/bottom.php"; ?>

    <!-- Skrip Realtime Notifikasi & Auto Refresh Tabel -->
<script>
let jumlahPesananSebelumnya = null;

function cekPesananBaru() {
    fetch('cek_pesanan_baru.php')
    .then(response => response.json())
    .then(data => {
        if (jumlahPesananSebelumnya === null) {
            jumlahPesananSebelumnya = data.total;
        } else if (data.total > jumlahPesananSebelumnya) {
            jumlahPesananSebelumnya = data.total;
            alert('🔔 Ada Pesanan Masuk Baru!');
            location.reload();
        }
    })
    .catch(error => console.error('Error checking new orders:', error));
}

setInterval(cekPesananBaru, 3000);
</script>
</body>
</html>