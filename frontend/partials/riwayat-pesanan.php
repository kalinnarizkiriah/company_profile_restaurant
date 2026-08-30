<?php
session_start();
include '../../backend/connection.php'; 

if (!isset($_SESSION['login_customer'])) {
    header("Location: login_customer.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Riwayat Pemesanan - Resto Jogja</title>
    <link rel="icon" type="image/jpeg" href="../../backend/img/category/logojogja7.png">
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body class="bg-gray-50">

    <!-- Navbar Sederhana -->
<nav class="bg-white shadow-sm p-4">
    <div class="container mx-auto flex justify-between items-center">
        <!-- Tombol Kembali di sebelah Kiri -->
        <a href="../index.php" class="text-gray-600 hover:text-red-600"><i class="fas fa-arrow-left"></i> Kembali ke Beranda</a>
        
        <!-- Judul Resto di sebelah Kanan -->
        <a href="../index.php" class="text-xl font-bold text-red-600">Resto Jogja</a>
    </div>
</nav>

    <!-- Konten Utama Riwayat Pesanan -->
    <div class="container mx-auto px-4 py-8 max-w-7xl">
        <h1 class="text-2xl font-bold mb-6 text-gray-800"><i class="fas fa-history text-red-600 mr-2"></i> Riwayat Pemesanan Anda</h1>

        <div class="bg-white shadow-md rounded-lg overflow-x-auto">
            <table class="w-full border-collapse text-left text-sm">
               <thead class="bg-gray-100 text-gray-600 border-b">
                <tr>
                    <th class="p-3">No. Pesanan</th>
                    <th class="p-3">Nama Pemesan</th>
                    <th class="p-3">No. HP / WA</th>
                    <th class="p-3">Menu yang Dipesan</th> <!-- Ditambahkan: Kolom Menu Dipesan -->
                    <th class="p-3">Tipe</th>
                    <th class="p-3">Catatan</th>      <!-- Kolom Catatan -->
                    <th class="p-3">No. Meja</th>     <!-- Kolom No Meja Baru -->
                    <th class="p-3">Pembayaran</th>
                    <th class="p-3">Total Bayar</th>
                    <th class="p-3">Status</th>
                    <th class="p-3">Waktu</th>
                    <th class="p-3 text-center">Ulasan</th>
                </tr>
            </thead>
                <tbody id="tabel-riwayat" class="divide-y divide-gray-200">
                    <!-- Data dimuat via AJAX -->
                </tbody>
            </table>
        </div>
    </div>

    <!-- MODAL FORM ULASAN -->
    <div id="modalTambahUlasan" class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50 hidden">
      <div class="bg-white rounded-lg shadow-lg w-full max-w-md p-6 relative">
        <div class="flex justify-between items-center mb-4">
          <h3 class="text-lg font-bold text-gray-800"><i class="fas fa-star text-amber-500 mr-1"></i> Beri Rating Pesanan</h3>
          <button type="button" onclick="tutupModalRating()" class="text-gray-400 hover:text-gray-600 text-xl font-bold">&times;</button>
        </div>
        
        <form action="../../backend/form_reviews.php" method="POST">
          <input type="hidden" name="no_pesanan" id="inputNoPesanan">

          <div class="mb-4 text-left">
            <label class="block text-sm font-medium text-gray-700 mb-1">Penilaian (Bintang)</label>
            <select name="bintang" class="w-full border border-gray-300 rounded-md p-2 text-sm" required>
              <option value="5">5 - Sangat Bagus ★★★★★</option>
              <option value="4">4 - Bagus ★★★★☆</option>
              <option value="3">3 - Cukup ★★★☆☆</option>
              <option value="2">2 - Kurang ★★☆☆☆</option>
              <option value="1">1 - Sangat Kurang ★☆☆☆☆</option>
            </select>
          </div>

          <div class="mb-4 text-left">
            <label class="block text-sm font-medium text-gray-700 mb-1">Isi Ulasan</label>
            <textarea name="ulasan" rows="4" class="w-full border border-gray-300 rounded-md p-2 text-sm" placeholder="Tuliskan ulasan..." required></textarea>
          </div>

          <div class="flex justify-end gap-2">
            <button type="button" onclick="tutupModalRating()" class="px-4 py-2 bg-gray-200 text-gray-700 text-sm font-medium rounded-md hover:bg-gray-300">Kembali</button>
            <button type="submit" class="px-4 py-2 bg-red-600 text-white text-sm font-semibold rounded-md hover:bg-red-700">Kirim Ulasan</button>
          </div>
        </form>
      </div>
    </div>

    <script>
        function muatRiwayat() {
            $.ajax({
                url: 'get_riwayat.php',
                type: 'GET',
                success: function(data) {
                    $('#tabel-riwayat').html(data);
                }
            });
        }

        function bukaModalRating(noPesanan) {
            document.getElementById('inputNoPesanan').value = noPesanan;
            document.getElementById('modalTambahUlasan').classList.remove('hidden');
        }

        function tutupModalRating() {
            document.getElementById('modalTambahUlasan').classList.add('hidden');
        }

        $(document).ready(function() {
            muatRiwayat(); 
            setInterval(muatRiwayat, 3000);
        });
    </script>
</body>
</html>