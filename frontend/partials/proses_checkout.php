<?php
session_start();
header('Content-Type: application/json');

// Menerima data JSON dari JavaScript checkout.php
$input = json_decode(file_get_contents('php://input'), true);

if ($input) {
    // Hubungkan ke database menggunakan variabel $connection (sesuaikan path folder jika perlu)
    require_once '../../backend/connection.php';

    // Pastikan keranjang tidak kosong
    if (!isset($_SESSION['cart']) || empty($_SESSION['cart'])) {
        echo json_encode([
            'status' => 'error',
            'message' => 'Keranjang belanja kosong!'
        ]);
        exit;
    }

    $no_pesanan = $input['no_pesanan'];
    $nama = $input['nama'];
    $nohp = $input['nohp'];
    $catatan = $input['catatan'];
    $tipe = $input['tipe'];
    $metode = $input['metode'];

    // Hitung grand total dari session cart asli untuk keamanan
    $grand_total = 0;
    foreach ($_SESSION['cart'] as $item) {
        $harga = (int) preg_replace('/[^0-9]/', '', $item['harga']);
        $grand_total += ($harga * $item['qty']);
    }

    // Tentukan status awal pesanan berdasarkan metode pembayaran
    $status = ($metode === 'Tunai / Kasir') ? 'Menunggu Pembayaran di Kasir' : 'Menunggu Konfirmasi';

    // Simpan data utama ke tabel pesanan
    $query_pesanan = "INSERT INTO pesanan (no_pesanan, nama_pemesan, no_hp, catatan, tipe_pesanan, metode_pembayaran, total_bayar, status_pesanan) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt = mysqli_prepare($connection, $query_pesanan);
    mysqli_stmt_bind_param($stmt, 'ssssssis', $no_pesanan, $nama, $nohp, $catatan, $tipe, $metode, $grand_total, $status);

    if (mysqli_stmt_execute($stmt)) {
        // Simpan setiap item di keranjang ke tabel detail_pesanan
        foreach ($_SESSION['cart'] as $item) {
            $harga = (int) preg_replace('/[^0-9]/', '', $item['harga']);
            $qty = $item['qty'];
            $subtotal = $harga * $qty;
            $nama_menu = $item['nama'];

            $query_detail = "INSERT INTO detail_pesanan (no_pesanan, nama_menu, harga, qty, subtotal) VALUES (?, ?, ?, ?, ?)";
            $stmt_detail = mysqli_prepare($connection, $query_detail);
            mysqli_stmt_bind_param($stmt_detail, 'ssiii', $no_pesanan, $nama_menu, $harga, $qty, $subtotal);
            mysqli_stmt_execute($stmt_detail);
        }

        // Kosongkan keranjang/troli belanja secara otomatis setelah berhasil disimpan
        unset($_SESSION['cart']); 

        // Kirim respon sukses ke JavaScript
        echo json_encode([
            'status' => 'success',
            'message' => 'Pesanan berhasil diproses dan keranjang dikosongkan'
        ]);
    } else {
        echo json_encode([
            'status' => 'error',
            'message' => 'Gagal menyimpan pesanan ke database: ' . mysqli_error($connection)
        ]);
    }
} else {
    echo json_encode([
        'status' => 'error',
        'message' => 'Data tidak ditemukan'
    ]);
}
?>