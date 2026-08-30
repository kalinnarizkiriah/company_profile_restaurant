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
                                            <th scope="col" style="width: 130px; white-space: nowrap;">No. Pesanan</th>
                                            <th scope="col">Nama Pemesan</th>
                                            <th scope="col">No. HP / WA</th>
                                            <th scope="col">Menu yang Dipesan</th> <!-- Ditambahkan: Kolom Menu Dipesan -->
                                            <th scope="col">Tipe</th>
                                            <th scope="col">Catatan</th>    
                                            <th scope="col">No. Meja</th>   
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
                                            
                                            <!-- Menampilkan Kolom Menu Dipesan -->
                                            <td>
                                                <span class="fw-semibold text-dark">
                                                    <?= !empty($tampil->menu_dipesan) ? htmlspecialchars($tampil->menu_dipesan) : '<span class="text-muted">Tidak ada rincian menu</span>'; ?>
                                                </span>
                                            </td>

                                            <td><span class="badge bg-secondary text-white"><?= htmlspecialchars($tampil->tipe_pesanan); ?></span></td>
                                            
                                            <!-- Kolom Catatan Terpisah -->
                                            <td><?= !empty($tampil->catatan) ? htmlspecialchars($tampil->catatan) : '<span class="text-muted">-</span>'; ?></td>
                                            
                                            <!-- Kolom No. Meja Terpisah -->
                                            <td><?= !empty($tampil->no_meja) ? htmlspecialchars($tampil->no_meja) : '<span class="text-muted">-</span>'; ?></td>
                                            
                                            <td><?= htmlspecialchars($tampil->metode_pembayaran); ?></td>
                                            <td class="fw-bold">Rp <?= number_format($tampil->total_bayar, 0, ',', '.'); ?></td>
                                            <td>
                                                <?php 
                                                    $status = trim($tampil->status_pesanan);
                                                    if ($status == 'Menunggu' || $status == 'Menunggu Konfirmasi' || $status == 'Menunggu Pembayaran di Kasir') : 
                                                ?>
                                                    <span class="badge bg-warning text-dark"><?= htmlspecialchars($status); ?></span>
                                                <?php elseif ($status == 'Pembayaran Berhasil') : ?>
                                                    <span class="badge bg-success text-white">Pembayaran Berhasil</span>
                                                <?php elseif ($status == 'Diproses') : ?>
                                                    <span class="badge bg-info text-dark">Sedang Diproses</span>
                                                <?php else : ?>
                                                    <span class="badge bg-success text-white"><?= htmlspecialchars($status); ?></span>
                                                <?php endif; ?>
                                            </td>
                                            <td><small class="text-muted"><?= htmlspecialchars($tampil->tanggal); ?></small></td>
                                            
                                            <!-- Tombol Aksi Bertahap -->
                                            <td class="text-center text-nowrap">
                                                <?php if ($status == 'Menunggu' || $status == 'Menunggu Konfirmasi' || $status == 'Menunggu Pembayaran di Kasir') : ?>
                                                    <!-- Tombol 1: Ubah ke 'Pembayaran Berhasil' -->
                                                    <a href="update_status.php?id=<?= $tampil->id; ?>&status=Pembayaran Berhasil" class="btn btn-sm btn-success fw-bold mb-1" title="Konfirmasi Pembayaran Berhasil">
                                                        <i class="fas fa-check-circle"></i> Konfirmasi
                                                    </a>
                                                    <!-- Tombol Hapus -->
                                                    <a href="delete_pesanan.php?id=<?= $tampil->id; ?>" class="btn btn-sm btn-danger mb-1" onclick="return confirm('Yakin ingin menghapus data pesanan ini?')" title="Hapus">
                                                        <i class="fas fa-trash"></i>
                                                    </a>

                                                <?php elseif ($status == 'Pembayaran Berhasil') : ?>
                                                    <!-- Tombol 2: Ubah ke 'Diproses' -->
                                                    <a href="update_status.php?id=<?= $tampil->id; ?>&status=Diproses" class="btn btn-sm btn-info fw-bold text-dark mb-1" title="Proses Pesanan">
                                                        <i class="fas fa-spinner"></i> Proses
                                                    </a>
                                                    <!-- Tombol Hapus -->
                                                    <a href="delete_pesanan.php?id=<?= $tampil->id; ?>" class="btn btn-sm btn-danger mb-1" onclick="return confirm('Yakin ingin menghapus data pesanan ini?')" title="Hapus">
                                                        <i class="fas fa-trash"></i>
                                                    </a>

                                                <?php elseif ($status == 'Diproses') : ?>
                                                    <!-- Tombol 3: Ubah ke 'Selesai' -->
                                                    <a href="update_status.php?id=<?= $tampil->id; ?>&status=Selesai" class="btn btn-sm btn-success fw-bold mb-1" title="Selesaikan Pesanan">
                                                        <i class="fas fa-check"></i> Selesai
                                                    </a>
                                                    <!-- Tombol Hapus -->
                                                    <a href="delete_pesanan.php?id=<?= $tampil->id; ?>" class="btn btn-sm btn-danger mb-1" onclick="return confirm('Yakin ingin menghapus data pesanan ini?')" title="Hapus">
                                                        <i class="fas fa-trash"></i>
                                                    </a>

                                                <?php else : ?>
                                                    <!-- Jika Sudah Selesai, Hanya Tampilkan Tombol Hapus Saja -->
                                                    <a href="delete_pesanan.php?id=<?= $tampil->id; ?>" class="btn btn-sm btn-danger mb-1" onclick="return confirm('Yakin ingin menghapus data pesanan ini?')" title="Hapus">
                                                        <i class="fas fa-trash"></i> Hapus
                                                    </a>
                                                <?php endif; ?>
                                            </td>
                                        </tr>
                                        <?php 
                                            endwhile;
                                        else :
                                        ?>
                                        <tr>
                                            <!-- Colspan disesuaikan menjadi 13 karena ada penambahan kolom -->
                                            <td colspan="13" class="text-center py-4 text-muted">Belum ada pesanan masuk.</td>
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
<!-- Skrip Realtime Notifikasi & Auto Refresh Tabel -->
<script>
let jumlahMenungguSebelumnya = null;

function cekPesananBaru() {
    fetch('cek_pesanan_baru.php')
    .then(response => response.json())
    .then(data => {
        if (jumlahMenungguSebelumnya === null) {
            jumlahMenungguSebelumnya = data.total;
        } else if (data.total !== jumlahMenungguSebelumnya) {
            // Jika ada pesanan baru yang berstatus 'Menunggu', halaman otomatis reload
            jumlahMenungguSebelumnya = data.total;
            location.reload(); 
        }
    })
    .catch(error => console.error('Error checking new orders:', error));
}

// Cek setiap 3 detik secara otomatis
setInterval(cekPesananBaru, 3000);
</script>
</body>
</html>