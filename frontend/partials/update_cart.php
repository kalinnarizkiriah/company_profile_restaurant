<?php
session_start();
header('Content-Type: application/json');

$id = isset($_GET['id']) ? $_GET['id'] : null;
$action = isset($_GET['action']) ? $_GET['action'] : null;

if ($id && isset($_SESSION['cart'][$id])) {
    if ($action === 'increase') {
        $_SESSION['cart'][$id]['qty'] += 1;
    } elseif ($action === 'decrease') {
        $_SESSION['cart'][$id]['qty'] -= 1;
        if ($_SESSION['cart'][$id]['qty'] <= 0) {
            unset($_SESSION['cart'][$id]);
        }
    }

    $total_items = 0;
    $grand_total = 0;
    $item_qty = 0;
    $subtotal = 0;

    if (isset($_SESSION['cart'][$id])) {
        $item_qty = $_SESSION['cart'][$id]['qty'];
        $harga = (int) preg_replace('/[^0-9]/', '', $_SESSION['cart'][$id]['harga']);
        $subtotal = $harga * $item_qty;
    }

    if (isset($_SESSION['cart']) && !empty($_SESSION['cart'])) {
        foreach ($_SESSION['cart'] as $item) {
            $total_items += $item['qty'];
            $harga = (int) preg_replace('/[^0-9]/', '', $item['harga']);
            $grand_total += ($harga * $item['qty']);
        }
    }

    echo json_encode([
        'status'      => 'success',
        'item_qty'    => $item_qty,
        'subtotal'    => 'Rp ' . number_format($subtotal, 0, ',', '.'),
        'grand_total' => 'Rp ' . number_format($grand_total, 0, ',', '.'),
        'total_items' => $total_items
    ]);
    exit;
}

echo json_encode(['status' => 'error', 'message' => 'Item tidak ditemukan']);
exit;