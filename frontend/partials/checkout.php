<?php
session_start();

// Jika keranjang kosong, kembalikan ke halaman index
if (!isset($_SESSION['cart']) || empty($_SESSION['cart'])) {
    header('Location: ../index.php');
    exit;
}

// Hitung Grand Total
$grand_total = 0;
foreach ($_SESSION['cart'] as $item) {
    $harga = (int) preg_replace('/[^0-9]/', '', $item['harga']);
    $grand_total += ($harga * $item['qty']);
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <!-- Judul Tab disamakan dengan Dashboard -->
    <title>Restoran Jogja Istimewa</title>
    
    <!-- Favicon Logo (Path dinaikkan 2 level) -->
    <link rel="icon" type="image/png" href="../../backend/img/category/logojogja7.png">
    
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- FontAwesome Icon -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"/>
    
    <style>
        :root {
            --primary-color: #E33A26;
            --primary-hover: #c82d1b;
            --primary-light: #fff5f3;
        }

        body { background-color: #f8f9fa; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; }
        .checkout-card { border: none; border-radius: 12px; box-shadow: 0 4px 12px rgba(0,0,0,0.05); }
        .option-box input[type="radio"] { display: none; }
        .option-box label {
            border: 2px solid #e9ecef;
            border-radius: 10px;
            padding: 14px;
            cursor: pointer;
            width: 100%;
            transition: all 0.2s ease-in-out;
            background-color: #fff;
        }
        .option-box label:hover { border-color: var(--primary-color); }
        .option-box input[type="radio"]:checked + label {
            border-color: var(--primary-color);
            background-color: var(--primary-light);
            box-shadow: 0 2px 8px rgba(227, 58, 38, 0.15);
        }
        .qris-box { border: 2px dashed var(--primary-color); border-radius: 12px; background: #fff; padding: 20px; }
        
        /* Kustomisasi warna kustom oren kemerahan */
        .text-custom-primary { color: var(--primary-color) !important; }
        .btn-custom-primary {
            background-color: var(--primary-color) !important;
            border-color: var(--primary-color) !important;
            color: #fff !important;
        }
        .btn-custom-primary:hover {
            background-color: var(--primary-hover) !important;
            border-color: var(--primary-hover) !important;
        }
        .btn-outline-custom {
            color: var(--primary-color) !important;
            border-color: var(--primary-color) !important;
        }
        .btn-outline-custom:hover {
            background-color: var(--primary-color) !important;
            color: #fff !important;
        }
    </style>
</head>
<body class="py-4">

<div class="container">
    <div class="d-flex align-items-center mb-4">
        <a href="../index.php" class="btn btn-outline-secondary btn-sm me-3">
            <i class="fa-solid fa-arrow-left me-1"></i> Kembali Belanja
        </a>
        <h3 class="fw-bold mb-0">Checkout Pesanan</h3>
    </div>

    <form id="formCheckout">
        <div class="row g-4">
            
            <!-- Kolom Kiri: Form Data Pemesan, Tipe Pesanan, & Pembayaran -->
            <div class="col-lg-7">
                
                <!-- Data Pemesan -->
                <div class="card checkout-card mb-4">
                    <div class="card-header bg-white py-3 fw-bold">
                        <i class="fa-solid fa-user me-2 text-custom-primary"></i>Informasi Pemesan
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <label class="form-label fw-medium">Nama Lengkap</label>
                            <input type="text" id="nama" class="form-control" required>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-medium">Nomor WhatsApp / HP</label>
                                <input type="tel" id="nohp" class="form-control" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-medium">Nomor Meja / Catatan</label>
                                <input type="text" id="catatan" class="form-control">
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Pilihan Tipe Pesanan -->
                <div class="card checkout-card mb-4">
                    <div class="card-header bg-white py-3 fw-bold">
                        <i class="fa-solid fa-utensils me-2 text-custom-primary"></i>Pilih Tipe Pesanan
                    </div>
                    <div class="card-body">
                        <div class="row g-3">
                            <div class="col-6 option-box">
                                <input type="radio" id="tipe_dinein" name="tipe" value="Makan di Tempat" checked>
                                <label for="tipe_dinein" class="d-flex align-items-center">
                                    <i class="fa-solid fa-chair fs-3 me-3 text-custom-primary"></i>
                                    <div>
                                        <div class="fw-bold">Makan di Tempat</div>
                                        <small class="text-muted">Makan langsung di restoran</small>
                                    </div>
                                </label>
                            </div>
                            <div class="col-6 option-box">
                                <input type="radio" id="tipe_takeaway" name="tipe" value="Dibungkus">
                                <label for="tipe_takeaway" class="d-flex align-items-center">
                                    <i class="fa-solid fa-bag-shopping fs-3 me-3 text-custom-primary"></i>
                                    <div>
                                        <div class="fw-bold">Dibungkus</div>
                                        <small class="text-muted">Bawa pulang / dikemas</small>
                                    </div>
                                </label>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Metode Pembayaran -->
                <div class="card checkout-card mb-4">
                    <div class="card-header bg-white py-3 fw-bold">
                        <i class="fa-solid fa-wallet me-2 text-custom-primary"></i>Pilih Metode Pembayaran
                    </div>
                    <div class="card-body">
                        <div class="row g-3">
                            <div class="col-md-6 option-box">
                                <input type="radio" id="pay_qris" name="metode" value="QRIS" checked>
                                <label for="pay_qris" class="d-flex align-items-center">
                                    <i class="fa-solid fa-qrcode fs-3 me-3 text-custom-primary"></i>
                                    <div>
                                        <div class="fw-bold">QRIS</div>
                                        <small class="text-muted">Semua E-Wallet & Mobile Banking</small>
                                    </div>
                                </label>
                            </div>
                            <div class="col-md-6 option-box">
                                <input type="radio" id="pay_cash" name="metode" value="Tunai / Kasir">
                                <label for="pay_cash" class="d-flex align-items-center">
                                    <i class="fa-solid fa-money-bill-wave fs-3 me-3 text-custom-primary"></i>
                                    <div>
                                        <div class="fw-bold">Tunai / Kasir</div>
                                        <small class="text-muted">Bayar di kasir</small>
                                    </div>
                                </label>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

            <!-- Kolom Kanan: Rincian Pesanan -->
            <div class="col-lg-5">
                <div class="card checkout-card">
                    <div class="card-header bg-white py-3 fw-bold">
                        <i class="fa-solid fa-bag-shopping me-2 text-custom-primary"></i>Rincian Pesanan
                    </div>
                    <div class="card-body p-0">
                        <ul class="list-group list-group-flush">
                            <?php foreach ($_SESSION['cart'] as $item) : 
                                $harga = (int) preg_replace('/[^0-9]/', '', $item['harga']);
                                $subtotal = $harga * $item['qty'];
                            ?>
                            <li class="list-group-item d-flex justify-content-between align-items-center py-3">
                                <div>
                                    <h6 class="mb-0 fw-bold"><?= htmlspecialchars($item['nama']); ?></h6>
                                    <small class="text-muted"><?= $item['qty']; ?> x Rp <?= number_format($harga, 0, ',', '.'); ?></small>
                                </div>
                                <span class="fw-bold">Rp <?= number_format($subtotal, 0, ',', '.'); ?></span>
                            </li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                    <div class="card-footer bg-white p-3 border-top">
                        <div class="d-flex justify-content-between mb-2">
                            <span>Subtotal</span>
                            <span class="fw-bold">Rp <?= number_format($grand_total, 0, ',', '.'); ?></span>
                        </div>
                        <div class="d-flex justify-content-between mb-3 fs-5 fw-bold text-custom-primary">
                            <span>Total Bayar</span>
                            <span>Rp <?= number_format($grand_total, 0, ',', '.'); ?></span>
                        </div>
                        <button type="submit" class="btn btn-custom-primary w-100 py-2 fw-bold">
                            Buat Pesanan
                        </button>
                    </div>
                </div>
            </div>

        </div>
    </form>
</div>

<!-- Modal Pop-up Pembayaran -->
<div class="modal fade" id="modalPembayaran" data-bs-backdrop="static" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content border-0 shadow-lg" style="border-radius: 16px;">
      <div class="modal-body text-center p-4">
        
        <!-- Ikon Dinamis -->
        <div class="mb-3">
            <i id="statusIcon" class="fa-solid fa-clock text-warning fs-1"></i>
        </div>

        <!-- Judul Dinamis -->
        <h4 id="statusTitle" class="fw-bold mb-1">Menunggu Pembayaran</h4>
        <p class="text-muted small mb-3">Nomor Pesanan: <strong id="resNoPesanan" class="text-custom-primary"></strong></p>

        <!-- Informasi Ringkasan -->
        <div class="bg-light p-3 rounded-3 text-start mb-3">
            <div class="d-flex justify-content-between mb-1">
                <span class="text-muted small">Nama Pemesan:</span>
                <span id="resNama" class="fw-bold small"></span>
            </div>
            <div class="d-flex justify-content-between mb-1">
                <span class="text-muted small">Tipe Pesanan:</span>
                <span id="resTipe" class="fw-bold small"></span>
            </div>
            <div class="d-flex justify-content-between">
                <span class="text-muted small">Total Tagihan:</span>
                <span id="resTotal" class="fw-bold text-custom-primary small"></span>
            </div>
        </div>

        <!-- Tampilan Kondisional: QRIS -->
        <div id="tampilanQRIS" class="d-none">
            <div class="qris-box my-3">
                <h6 class="fw-bold text-custom-primary mb-1"><i class="fa-solid fa-qrcode me-2"></i>Pindai Kode QRIS</h6>
                <p class="text-muted small mb-2">Silakan scan kode di bawah ini sebelum menyelesaikan pembayaran</p>
                
                <div class="p-2 bg-white d-inline-block rounded border mb-2">
                    <img id="imgQRIS" src="../../backend/img/category/qris3.jpeg" alt="Kode QRIS Resto" class="img-fluid rounded" style="max-width: 220px;">
                </div>
                
                <p class="text-muted small mb-2">Atas Nama: <strong>Restoran Jogja Istimewa</strong></p>
                <div>
                    <a href="../../backend/img/category/qris3.jpeg" download="QRIS-RestoJogja.jpeg" class="btn btn-sm btn-outline-custom">
                        <i class="fa-solid fa-download me-1"></i> Unduh Gambar QRIS
                    </a>
                </div>
            </div>

            <!-- Tombol Konfirmasi QRIS -->
            <div id="btnKonfirmasiQRIS" class="d-grid gap-2">
                <button type="button" id="btnSudahBayar" class="btn btn-success py-2 fw-bold">
                    <i class="fa-solid fa-circle-check me-2"></i>Saya Sudah Bayar
                </button>
            </div>
        </div>

        <!-- Tampilan Kondisional: Tunai / Kasir -->
        <div id="tampilanKasir" class="d-none">
            <div class="alert alert-warning text-start my-3" role="alert">
                <div class="d-flex align-items-center mb-2">
                    <i class="fa-solid fa-store fs-4 text-warning me-2"></i>
                    <strong class="text-dark">Bayar Langsung di Kasir</strong>
                </div>
                <p class="small text-muted mb-0">
                    Silakan tunjukkan No. Pesanan <strong id="resNoPesananKasir" class="text-dark"></strong> ke Kasir untuk menyelesaikan pembayaran.
                </p>
            </div>
        </div>

        <!-- Tombol Selesai -->
        <div id="btnSelesai" class="d-grid mt-3 d-none">
            <a href="clear_cart.php" class="btn btn-custom-primary py-2 fw-bold w-100" style="border-radius: 8px;">
                Selesai & Kembali ke Menu
            </a>
        </div>

      </div>
    </div>
  </div>
</div>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<script>
let globalDataPesanan = {};

document.getElementById('formCheckout').addEventListener('submit', function(e) {
    e.preventDefault();

    const nama = document.getElementById('nama').value;
    const nohp = document.getElementById('nohp').value;
    const catatan = document.getElementById('catatan').value;
    const tipe = document.querySelector('input[name="tipe"]:checked').value;
    const metode = document.querySelector('input[name="metode"]:checked').value;
    const grandTotal = "Rp <?= number_format($grand_total, 0, ',', '.'); ?>";
    const noPesanan = 'ORD-' + Math.floor(100000 + Math.random() * 900000);

    globalDataPesanan = {
        no_pesanan: noPesanan,
        nama: nama,
        nohp: nohp,
        catatan: catatan,
        tipe: tipe,
        metode: metode
    };

    document.getElementById('resNoPesanan').innerText = noPesanan;
    document.getElementById('resNama').innerText = nama;
    document.getElementById('resTipe').innerText = tipe;
    document.getElementById('resTotal').innerText = grandTotal;

    if (metode === 'QRIS') {
        document.getElementById('statusIcon').className = 'fa-solid fa-clock text-warning fs-1';
        document.getElementById('statusTitle').innerText = 'Menunggu Pembayaran...';
        
        document.getElementById('tampilanQRIS').classList.remove('d-none');
        document.getElementById('tampilanKasir').classList.add('d-none');
        
        document.getElementById('btnKonfirmasiQRIS').classList.remove('d-none');
        document.getElementById('btnSelesai').classList.add('d-none');
    } else {
        simpanPesananKeDatabase(globalDataPesanan);

        document.getElementById('statusIcon').className = 'fa-solid fa-circle-check text-success fs-1';
        document.getElementById('statusTitle').innerText = 'Pesanan Berhasil Dibuat!';
        
        document.getElementById('tampilanKasir').classList.remove('d-none');
        document.getElementById('tampilanQRIS').classList.add('d-none');
        document.getElementById('resNoPesananKasir').innerText = noPesanan;
        
        document.getElementById('btnSelesai').classList.remove('d-none');
    }

    const modalPembayaran = new bootstrap.Modal(document.getElementById('modalPembayaran'));
    modalPembayaran.show();
});

document.getElementById('btnSudahBayar').addEventListener('click', function() {
    simpanPesananKeDatabase(globalDataPesanan);

    document.getElementById('statusIcon').className = 'fa-solid fa-circle-check text-success fs-1';
    document.getElementById('statusTitle').innerText = 'Pesanan Berhasil Dibuat!';
    
    document.getElementById('btnKonfirmasiQRIS').classList.add('d-none');
    document.getElementById('btnSelesai').classList.remove('d-none');
});

function simpanPesananKeDatabase(dataPesanan) {
    fetch('proses_checkout.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify(dataPesanan)
    })
    .then(response => response.json())
    .then(data => {
        if(data.status !== 'success') {
            alert('Gagal menyimpan pesanan: ' + data.message);
        }
    })
    .catch(error => {
        console.error('Error:', error);
    });
}
</script>
</body>
</html>