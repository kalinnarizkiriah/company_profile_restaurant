<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id    = $_POST['id'] ?? null;
    $nama  = $_POST['nama'] ?? '';
    $harga_raw = $_POST['harga'] ?? 0;
    $harga = (int) preg_replace('/[^0-9]/', '', $harga_raw);

    if ($id) {
        if (!isset($_SESSION['cart'])) {
            $_SESSION['cart'] = [];
        }

        if (isset($_SESSION['cart'][$id])) {
            $_SESSION['cart'][$id]['qty'] += 1;
        } else {
            $_SESSION['cart'][$id] = [
                'nama'  => $nama,
                'harga' => $harga,
                'qty'   => 1
            ];
        }

        // Hitung total porsi (jumlah seluruh qty)
        $total_items = array_sum(array_column($_SESSION['cart'], 'qty'));

        echo json_encode([
            'status'      => 'success',
            'message'     => 'Menu berhasil ditambahkan!',
            'total_items' => $total_items
        ]);
        exit;
    }
}

echo json_encode(['status' => 'error', 'message' => 'Gagal menambahkan menu']);