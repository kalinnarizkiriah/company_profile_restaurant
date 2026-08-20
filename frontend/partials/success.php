<?php
session_start();

// Ambil data pesanan dari URL atau Session
$id_pesanan = isset($_GET['id']) ? $_GET['id'] : 'ORD-' . rand(100000, 999999);
$nama       = isset($_GET['nama']) ? htmlspecialchars($_GET['nama']) : 'Pelanggan';
$tipe       = isset($_GET['tipe']) ? htmlspecialchars($_GET['tipe']) : 'Makan di Tempat';
$metode     = isset($_GET['metode']) ? htmlspecialchars($_GET['metode']) : 'Tunai / Kasir';
$total      = isset($_GET['total']) ? (int)$_GET['total'] : 0;

// Bersihkan keranjang belanja setelah pesanan dibuat
unset($_SESSION['cart']);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pesanan Berhasil - Resto Jogja</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"/>
    <style>
        body { background-color: #f4f6f9; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; }
        .success-card { border: none; border-radius: 16px; box-shadow: 0 10px 25px rgba(0,0,0,0.08); }
        .icon-box { width: 80px; height: 80px; background-color: #d1e7dd; color: #0f5132; border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 20px; }
        .qris-box { border: 2px dashed #dc3545; border-radius: 12px; background: #fff; padding: 20px; }
    </style>
</head>
<body class="py-5">

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-7 col-lg-6">
            <div class="card success-card bg-white p-4">
                <div class="card-body text-center">
                    
                    <!-- Ikon Berhasil -->
                    <div class="icon-box">
                        <i class="fa-solid fa-check fs-1"></i>
                    </div>

                    <h4 class="fw-bold mb-1">Pesanan Berhasil Dibuat!</h4>
                    <p class="text-muted small">Terima kasih, pesanan Anda sedang kami proses.</p>

                    <!-- Kode Transaksi -->
                    <div class="bg-light p-3 rounded-3 my-3 text-start">
                        <div class="d-flex justify-content-between mb-2">
                            <span class="text-muted small">No. Pesanan</span>
                            <span class="fw-bold text-danger"><?= $id_pesanan; ?></span>
                        </div>
                        <div class="d-flex justify-content-between mb-2">
                            <span class="text-muted small">Nama Pemesan</span>
                            <span class="fw-bold"><?= $nama; ?></span>
                        </div>
                        <div class="d-flex justify-content-between mb-2">
                            <span class="text-muted small">Tipe Pesanan</span>
                            <span class="fw-bold"><?= $tipe; ?></span>
                        </div>
                        <div class="d-flex justify-content-between">
                            <span class="text-muted small">Metode Pembayaran</span>
                            <span class="fw-bold"><?= $metode; ?></span>
                        </div>
                    </div>

                    <!-- Tampilan Khusus Jika Memilih QRIS -->
                    <?php if (stristr($metode, 'QRIS')) : ?>
                        <div class="qris-box my-4">
                            <h6 class="fw-bold text-danger mb-2"><i class="fa-solid fa-qrcode me-2"></i>Pindai Kode QRIS</h6>
                            <p class="text-muted small mb-3">Silakan scan kode QR di bawah menggunakan Gopay, OVO, Dana, atau Mobile Banking.</p>
                            <img src="https://api.qrserver.com/v1/create-qr-code/?size=180x180&data=<?= $id_pesanan; ?>" alt="QRIS Code" class="img-fluid rounded mb-3">
                            <h4 class="fw-bold text-danger">Rp <?= number_format($total, 0, ',', '.'); ?></h4>
                        </div>
                    <?php else : ?>
                        <!-- Instruksi Jika Memilih Tunai/Kasir -->
                        <div class="alert alert-warning text-start my-4" role="alert">
                            <i class="fa-solid fa-circle-info me-2"></i>
                            Silakan tunjukkan No. Pesanan <strong><?= $id_pesanan; ?></strong> ke Kasir saat melakukan pembayaran sebesar <strong>Rp <?= number_format($total, 0, ',', '.'); ?></strong>.
                        </div>
                    <?php endif; ?>

                    <!-- Tombol Navigasi -->
                    <div class="d-grid gap-2">
                        <a href="../index.php" class="btn btn-danger py-2 fw-bold">
                            <i class="fa-solid fa-house me-2"></i>Kembali ke Beranda
                        </a>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>

</body>
</html>