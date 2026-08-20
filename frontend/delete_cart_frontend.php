<?php
session_start();
header('Content-Type: application/json'); // Wajib agar JS membacanya sebagai JSON

$id = isset($_GET['id']) ? $_GET['id'] : null;

if ($id && isset($_SESSION['cart'][$id])) {
    unset($_SESSION['cart'][$id]); // Hapus item
}

// Hitung ulang total
$total_items = 0;
$grand_total = 0;

if (isset($_SESSION['cart']) && !empty($_SESSION['cart'])) {
    foreach ($_SESSION['cart'] as $item) {
        $total_items += $item['qty'];
        $harga = (int) preg_replace('/[^0-9]/', '', $item['harga']);
        $grand_total += ($harga * $item['qty']);
    }
}

echo json_encode([
    'status'      => 'success',
    'grand_total' => 'Rp ' . number_format($grand_total, 0, ',', '.'),
    'total_items' => $total_items
]);
exit;
?>