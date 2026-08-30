<?php
session_start();
header('Content-Type: application/json');

// Menerima data JSON dari JavaScript checkout.php
$input = json_decode(file_get_contents('php://input'), true);

if ($input) {
    // Hubungkan ke database menggunakan variabel $connection
    require_once '../../backend/connection.php';

    // Pastikan keranjang tidak kosong
    if (!isset($_SESSION['cart']) || empty($_SESSION['cart'])) {
        echo json_encode([
            'status' => 'error',
            'message' => 'Keranjang belanja kosong!'
        ]);
        exit;
    }

    // Pastikan customer sudah login dan ambil user_id-nya
    if (!isset($_SESSION['login_customer'])) {
        echo json_encode([
            'status' => 'error',
            'message' => 'Sesi login habis, silakan login kembali.'
        ]);
        exit;
    }

    $customer = $_SESSION['login_customer'];
    $user_id = is_array($customer) ? ($customer['id'] ?? 0) : $customer;

    $no_pesanan = $input['no_pesanan'];
    $nama       = $input['nama'];
    $nohp       = $input['nohp'];
    $no_meja    = $input['no_meja']; 
    $catatan    = $input['catatan'];
    $tipe       = $input['tipe'];
    $metode     = $input['metode'];

    // Hitung grand total dan kumpulkan string nama menu dari keranjang
    $grand_total = 0;
    $arr_menu = [];
    foreach ($_SESSION['cart'] as $item) {
        $harga = (int) preg_replace('/[^0-9]/', '', $item['harga']);
        $qty = (int) $item['qty'];
        $grand_total += ($harga * $qty);
        
        // Format gabungan menu dan jumlahnya (Contoh: Nasi Goreng (2x), Es Teh (1x))
        $nama_menu_item = $item['nama'] ?? $item['nama_menu'] ?? 'Menu';
        $arr_menu[] = $nama_menu_item . " (" . $qty . "x)";
    }
    
    // Gabungkan array menu menjadi satu teks string dipisahkan koma
    $menu_dipesan = implode(", ", $arr_menu);

    // Ubah status awal menjadi "Menunggu Konfirmasi" agar sinkron
    $status = 'Menunggu Konfirmasi';

    // Simpan data utama ke tabel pesanan (termasuk kolom menu_dipesan)
    $query_pesanan = "INSERT INTO pesanan (user_id, no_pesanan, nama_pemesan, no_hp, no_meja, catatan, tipe_pesanan, metode_pembayaran, total_bayar, status_pesanan, menu_dipesan) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt = mysqli_prepare($connection, $query_pesanan);
    
    // Bind parameter (11 parameter: 2 int, 9 string -> 'isssssssiss' atau sesuaikan tipe datanya)
    // Perhatikan: user_id (i), no_pesanan (s), nama (s), nohp (s), no_meja (s), catatan (s), tipe (s), metode (s), grand_total (i atau s), status (s), menu_dipesan (s)
    mysqli_stmt_bind_param($stmt, 'isssssssiss', $user_id, $no_pesanan, $nama, $nohp, $no_meja, $catatan, $tipe, $metode, $grand_total, $status, $menu_dipesan);

    if (mysqli_stmt_execute($stmt)) {
        // Simpan setiap item di keranjang ke tabel detail_pesanan (jika masih ingin digunakan)
        foreach ($_SESSION['cart'] as $item) {
            $harga = (int) preg_replace('/[^0-9]/', '', $item['harga']);
            $qty = (int) $item['qty'];
            $subtotal = $harga * $qty;
            $nama_menu = $item['nama'] ?? $item['nama_menu'];

            $query_detail = "INSERT INTO detail_pesanan (no_pesanan, nama_menu, harga, qty, subtotal) VALUES (?, ?, ?, ?, ?)";
            $stmt_detail = mysqli_prepare($connection, $query_detail);
            mysqli_stmt_bind_param($stmt_detail, 'ssiii', $no_pesanan, $nama_menu, $harga, $qty, $subtotal);
            mysqli_stmt_execute($stmt_detail);
        }

        // Kosongkan keranjang belanja secara otomatis setelah berhasil disimpan
        unset($_SESSION['cart']); 

        // Kirim respon sukses ke JavaScript
        echo json_encode([
            'status' => 'success',
            'message' => 'Pesanan berhasil dibuat!'
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