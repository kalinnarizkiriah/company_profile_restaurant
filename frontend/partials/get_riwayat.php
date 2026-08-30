<?php
session_start();
include '../../backend/connection.php';

if (!isset($_SESSION['login_customer'])) {
    exit;
}

$customer = $_SESSION['login_customer'];

// Ambil nama lengkap atau username dari session login yang aktif
$nama_pemesan = '';
if (is_array($customer)) {
    $nama_pemesan = $customer['nama_lengkap'] ?? ($customer['username'] ?? '');
} else {
    $nama_pemesan = $customer;
}

// Ambil riwayat pesanan berdasarkan nama pemesan, urutkan dari yang terbaru
$query = mysqli_query($connection, "SELECT * FROM pesanan WHERE nama_pemesan = '$nama_pemesan' ORDER BY id DESC");

if ($query && mysqli_num_rows($query) > 0) {
    while ($tampil = mysqli_fetch_object($query)) {
        $no_pesanan = $tampil->no_pesanan;
        
        // Ambil ulasan secara spesifik murni berdasarkan no_pesanan saja
        $cek_ulasan = mysqli_query($connection, "SELECT * FROM reviews WHERE no_pesanan = '$no_pesanan' LIMIT 1");

        $ada_ulasan = ($cek_ulasan && mysqli_num_rows($cek_ulasan) > 0) ? mysqli_fetch_object($cek_ulasan) : null;
        
        echo "<tr class='hover:bg-gray-50'>";
        echo "<td class='p-3 font-semibold text-red-600'>" . htmlspecialchars($tampil->no_pesanan) . "</td>";
        echo "<td class='p-3'>" . htmlspecialchars($tampil->nama_pemesan) . "</td>";
        echo "<td class='p-3'>" . htmlspecialchars($tampil->no_hp) . "</td>";
        
        // Kolom Menu yang Dipesan
        echo "<td class='p-3 font-medium text-gray-800'>" . (!empty($tampil->menu_dipesan) ? htmlspecialchars($tampil->menu_dipesan) : '<span class="text-gray-400">Tidak ada rincian menu</span>') . "</td>";
        
        echo "<td class='p-3'><span class='px-2 py-1 bg-gray-200 text-gray-700 rounded text-xs'>" . htmlspecialchars($tampil->tipe_pesanan) . "</span></td>";
        echo "<td class='p-3'>" . (!empty($tampil->catatan) ? htmlspecialchars($tampil->catatan) : '<span class="text-gray-400">-</span>') . "</td>";
        echo "<td class='p-3'>" . (!empty($tampil->no_meja) ? htmlspecialchars($tampil->no_meja) : '<span class="text-gray-400">-</span>') . "</td>";
        echo "<td class='p-3'>" . htmlspecialchars($tampil->metode_pembayaran) . "</td>";
        echo "<td class='p-3 font-semibold'>Rp " . number_format($tampil->total_bayar, 0, ',', '.') . "</td>";
        
        echo "<td class='p-3'>";
        $status = trim($tampil->status_pesanan);
        if ($status == 'Selesai') {
            echo "<span class='px-2 py-1 bg-green-100 text-green-700 rounded text-xs font-semibold'>Selesai</span>";
        } else {
            echo "<span class='px-2 py-1 bg-yellow-100 text-yellow-700 rounded text-xs font-semibold'>" . htmlspecialchars($status) . "</span>";
        }
        echo "</td>";
        
        echo "<td class='p-3 text-gray-500 text-xs'>" . htmlspecialchars($tampil->tanggal) . "</td>";
        
        // Bagian Kolom Ulasan & Balasan Admin
        echo "<td class='p-3 text-center'>";
        if ($ada_ulasan) {
            $bintang = str_repeat('★', (int)$ada_ulasan->bintang);
            echo "<div class='text-amber-500 font-bold text-sm'>" . $bintang . "</div>";
            echo "<small class='text-gray-600 italic block mb-1'>&quot;" . htmlspecialchars($ada_ulasan->ulasan) . "&quot;</small>";
            
            // Cek apakah admin sudah membalas ulasan ini
            if (!empty($ada_ulasan->balasan)) {
                echo "<div class='mt-2 p-2 bg-red-50 border-l-2 border-red-500 text-left rounded text-xs'>";
                echo "<div class='font-semibold text-red-600'>";
                echo "<i class='fas fa-reply mr-1'></i> Balasan Resto Jogja";
                echo "</div>";
                echo "<p class='text-gray-700 mt-1'>" . htmlspecialchars($ada_ulasan->balasan) . "</p>";
                echo "</div>";
            }
        } else {
            if ($status == 'Selesai') {
                echo "<button onclick=\"bukaModalRating('" . $tampil->no_pesanan . "')\" class='px-3 py-1 bg-amber-500 text-white text-xs font-semibold rounded hover:bg-amber-600 shadow'>
                        <i class='fas fa-star'></i> Beri Rating
                      </button>";
            } else {
                echo "<span class='text-gray-400 text-xs italic'>Belum Selesai</span>";
            }
        }
        echo "</td>";
        
        echo "</tr>";
    }
} else {
    echo "<tr><td colspan='12' class='p-4 text-center text-gray-500'>Belum ada riwayat pemesanan.</td></tr>";
}
?>