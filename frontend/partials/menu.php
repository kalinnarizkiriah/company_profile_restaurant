<?php
// Pastikan koneksi ke database tersedia
if (!isset($connection)) {
    if (file_exists("../backend/connection.php")) {
        include "../backend/connection.php";
    } elseif (file_exists("backend/connection.php")) {
        include "backend/connection.php";
    }
}

// 1. Ambil Semua Kategori Unik dari Database Backend untuk Tombol Filter
$kategori_query = mysqli_query($connection, "SELECT DISTINCT kategori FROM menu WHERE kategori IS NOT NULL AND kategori != ''");
$kategoris = [];
if ($kategori_query) {
    while ($row = mysqli_fetch_assoc($kategori_query)) {
        $kategoris[] = $row['kategori'];
    }
}

// Fungsi bantu slugify yang konsisten
function make_slug($text) {
    $text = strtolower(trim($text));
    $text = preg_replace('/[^a-z0-9]+/', '-', $text);
    return trim($text, '-');
}
?>

<!-- ============================================================
     MENU — DINAMIS DARI DATABASE BACKEND
     ============================================================ -->
<section id="menu">
   <div class="container">
      <div class="text-center mb-5" data-aos="fade-up">
         <h2 class="stitle">Pilihan <span> Menu </span>Lezat Kami </h2>
         <div class="sline"></div>
      </div>

      <!-- FILTER BUTTONS -->
      <div class="text-center mb-4 filter-controls" data-aos="fade-up">
         <button class="filtbtn active" data-f="all">All</button>
         <?php foreach ($kategoris as $kat): ?>
            <?php $slug_kat = make_slug($kat); ?>
            <button class="filtbtn" data-f="<?= $slug_kat; ?>"><?= htmlspecialchars($kat); ?></button>
         <?php endforeach; ?>
      </div>

      <!-- GRID MENU ITEM -->
      <div class="row g-4" id="mgrid">
         <?php
         // 2. Query Ambil Data Menu dari Database
         $menu_query = mysqli_query($connection, "SELECT * FROM menu ORDER BY id ASC");
         $delay = 0;

         if ($menu_query && mysqli_num_rows($menu_query) > 0) :
             while ($row = mysqli_fetch_object($menu_query)) :
                 $kat_name = !empty($row->kategori) ? $row->kategori : 'Other';
                 $cat_slug = make_slug($kat_name);
                 
                 $nama_file = trim($row->gambar ?? '');
                 $judul_menu = trim($row->title ?? '');
                 
                 if (!empty($nama_file) && file_exists("../backend/img/" . $nama_file)) {
                     $path_gambar = "../backend/img/" . $nama_file;
                 } elseif (!empty($nama_file) && file_exists("../backend/img/category/" . $nama_file)) {
                     $path_gambar = "../backend/img/category/" . $nama_file;
                 } elseif (!empty($judul_menu) && file_exists("../backend/img/category/" . $judul_menu . ".jpg")) {
                     $path_gambar = "../backend/img/category/" . $judul_menu . ".jpg";
                 } else {
                     $path_gambar = "../backend/img/category/burgers.jpg";
                 }
                 
                 $raw_price = $row->price ?? '0';
                 if (is_numeric($raw_price)) {
                     $formatted_price = "Rp " . number_format($raw_price, 0, ',', '.');
                 } else {
                     $formatted_price = (strpos($raw_price, 'Rp') === false) ? "Rp " . $raw_price : $raw_price;
                 }

                 $delay_attr = ($delay > 0) ? 'data-aos-delay="' . $delay . '"' : '';
                 $delay = ($delay >= 160) ? 0 : $delay + 80;
         ?>
         
         <!-- ITEM CARD (Ditambahkan data-category presisi) -->
         <div class="col-sm-6 col-lg-4 mwrap menu-item" data-c="<?= $cat_slug; ?>" data-category="<?= $cat_slug; ?>" data-aos="fade-up" <?= $delay_attr; ?>>
            <div class="mcard"
               data-img="<?= $path_gambar; ?>"
               data-title="<?= htmlspecialchars($row->title ?? ''); ?>"
               data-cat="<?= htmlspecialchars($kat_name); ?>"
               data-price="<?= $formatted_price; ?>" 
               data-old=""
               data-rating="<?= htmlspecialchars($row->rating ?? '5.0'); ?>" 
               data-reviews="50"
               data-cal="450" 
               data-time="15"
               data-desc="<?= htmlspecialchars($row->deskripsi ?? ''); ?>"
               data-tags="<?= htmlspecialchars($kat_name); ?>">
               
               <div class="mimg">
                  <img src="<?= $path_gambar; ?>" alt="<?= htmlspecialchars($row->title ?? 'Menu'); ?>"/>
                  <div class="mbdg hot"><i class="fa-solid fa-star"></i> <?= htmlspecialchars($row->rating ?? '5.0'); ?></div>
               </div>
               
               <div class="mbody">
                  <div class="mcat"><?= htmlspecialchars($kat_name); ?></div>
                  <div class="mtit"><?= htmlspecialchars($row->title ?? ''); ?></div>
                  <div class="mdesc"><?= htmlspecialchars($row->deskripsi ?? ''); ?></div>
                  <div class="mfoot">
                     <div>
                        <div class="mprice"><?= $formatted_price; ?></div>
                        <div class="mstars">
                           <i class="fa-solid fa-star"></i> <span style="color:#bbb;font-size:.7rem;">(<?= htmlspecialchars($row->rating ?? '5.0'); ?>)</span>
                        </div>
                     </div>
                     <!-- TOMBOL TAMBAH KE KERANJANG -->
                     <button class="madd btn-add-cart" 
                             type="button" 
                             title="Tambah ke Keranjang"
                             style="position: relative; z-index: 10; cursor: pointer;"
                             data-id="<?= $row->id; ?>"
                             data-nama="<?= htmlspecialchars($row->title ?? ''); ?>"
                             data-harga="<?= $raw_price; ?>"
                             data-gambar="<?= $path_gambar; ?>">
                        <i class="fa-solid fa-plus"></i>
                     </button>
                  </div>
               </div>
            </div>
         </div>
         <!-- END ITEM CARD -->

         <?php 
             endwhile;
         else : 
         ?>
            <div class="col-12 text-center py-4">
               <p class="text-muted">Belum ada data menu di database.</p>
            </div>
         <?php endif; ?>

      </div>
      <!-- end #mgrid -->

   </div>
</section>

<!-- SCRIPT LOGIKA FILTER PRESISI & KERANJANG -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    
    // ==========================================
    // LOGIKA FILTER KATEGORI PRESISI (EXACT MATCH)
    // ==========================================
    const filterButtons = document.querySelectorAll('.filter-controls .filtbtn');
    const menuWrappers = document.querySelectorAll('#mgrid .mwrap');

    filterButtons.forEach(function(btn) {
        btn.addEventListener('click', function(e) {
            e.preventDefault();
            
            // Ubah Status Aktif Tombol
            filterButtons.forEach(b => b.classList.remove('active'));
            this.classList.add('active');

            const targetCategory = this.getAttribute('data-f');

            // Filter Setiap Card Secara Persis
            menuWrappers.forEach(function(item) {
                const itemCategory = item.getAttribute('data-c');

                if (targetCategory === 'all' || itemCategory === targetCategory) {
                    item.style.display = '';
                    item.classList.remove('d-none');
                } else {
                    item.style.display = 'none';
                    item.classList.add('d-none');
                }
            });
        });
    });

    // ==========================================
    // SCRIPT PENANGAN KLIK KERANJANG
    // ==========================================
    document.querySelectorAll('.btn-add-cart').forEach(function(button) {
        button.addEventListener('click', function(e) {
            e.preventDefault(); 
            e.stopPropagation(); 
            
            const btn = this;
            const nama = btn.getAttribute('data-nama');
            const id = btn.getAttribute('data-id');
            const harga = btn.getAttribute('data-harga');
            const gambar = btn.getAttribute('data-gambar');

            const formData = new FormData();
            formData.append('id', id);
            formData.append('nama', nama);
            formData.append('harga', harga);
            formData.append('gambar', gambar);

            fetch('partials/add_to_cart.php', {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.status === 'success') {
                    // Update badge keranjang di navbar/header
                    const cartBadges = document.querySelectorAll('[data-bs-target="#modalKeranjang"] .badge, .cart-badge');
                    cartBadges.forEach(badge => {
                        badge.textContent = data.total_items;
                    });

                    // Efek tombol berubah hijau centang sementara
                    const originalHTML = btn.innerHTML;
                    btn.innerHTML = '<i class="fa-solid fa-check"></i>';
                    btn.classList.add('bg-success', 'text-white');
                    
                    setTimeout(() => {
                        btn.innerHTML = originalHTML;
                        btn.classList.remove('bg-success', 'text-white');
                    }, 1000);

                    // Refresh isi modal keranjang agar barang yang baru langsung muncul tanpa reload halaman
                    fetch(window.location.href)
                        .then(res => res.text())
                        .then(html => {
                            const parser = new DOMParser();
                            const doc = parser.parseFromString(html, 'text/html');
                            const newModalBody = doc.querySelector('#modalKeranjang .modal-body');
                            const currentModalBody = document.querySelector('#modalKeranjang .modal-body');
                            if (newModalBody && currentModalBody) {
                                currentModalBody.innerHTML = newModalBody.innerHTML;
                            }
                        });
                } else {
                    alert('Gagal menambahkan menu.');
                }
            })
            .catch(error => {
                console.error('Error:', error);
            });
        });
    });
});
</script>