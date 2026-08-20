<?php
// 1. Hubungkan ke database backend
include_once "../backend/connection.php"; 

// 2. Ambil data dari tabel 'about'
$query_about = mysqli_query($connection, "SELECT * FROM about LIMIT 1");
$about = mysqli_fetch_assoc($query_about);

// 3. Set jalur gambar dari folder backend/img/
$gambar_1 = (!empty($about['gambar_1']) && file_exists("../backend/img/" . $about['gambar_1'])) 
            ? "../backend/img/" . $about['gambar_1'] 
            : "img/about1.jpg";

$gambar_2 = (!empty($about['gambar_2']) && file_exists("../backend/img/" . $about['gambar_2'])) 
            ? "../backend/img/" . $about['gambar_2'] 
            : "img/about2.jpg";

// 4. Pemisahan teks badge
$text_exp = trim($about['tahun_pengalaman'] ?? '12+ Years of Excellence');
$exp_parts = explode(' ', $text_exp, 2);
$angka_exp = $exp_parts[0] ?? '12+';
$label_exp = $exp_parts[1] ?? 'Years of Excellence';

// 5. Mewarnai kata "Restoran Makanan" (Membungkus 2 kata terakhir dengan <span>)
$judul_full = $about['judul_utama'] ?? 'Kami Mengundang Anda untuk Mengunjungi Restoran Makanan Kami';
$words = explode(' ', $judul_full);

if (count($words) >= 3) {
    // Ambil kata "Restoran Makanan" (posisi ke-2 dan ke-3 dari akhir)
    $last_word = array_pop($words); // Kami
    $red_word_2 = array_pop($words); // Makanan
    $red_word_1 = array_pop($words); // Restoran
    
    $judul_formatted = implode(' ', $words) . ' <span>' . $red_word_1 . ' ' . $red_word_2 . '</span> ' . $last_word;
} else {
    $judul_formatted = $judul_full;
}
?>

<!-- Style Tambahan untuk Badge Persegi & Warna Highlight Titik/Teks -->
<style>
.aexp {
    width: 130px !important;
    height: 140px !important;
    display: flex !important;
    flex-direction: column !important;
    justify-content: center !important;
    align-items: center !important;
    text-align: center !important;
    white-space: normal !important;
    padding: 12px !important;
    border-radius: 16px !important;
}
.aexp .anum {
    font-size: 2rem !important;
    font-weight: 700 !important;
    line-height: 1 !important;
    margin-bottom: 4px !important;
}
.aexp small {
    font-size: 0.8rem !important;
    line-height: 1.2 !important;
    display: block !important;
}

/* Memastikan warna <span> pada judul sama merahnya dengan section Menu */
.stitle span {
    color: #e5231a !important; /* Warna merah khas tema */
}
</style>

<!-- ABOUT SECTION -->
<section id="about">
   <div class="container">
      <div class="row align-items-center g-5">
         
         <!-- GAMBAR & BADGE PENGALAMAN -->
         <div class="col-lg-5" data-aos="fade-right">
            <div class="astack">
               <div class="aexp">
                  <span class="anum"><?= htmlspecialchars($angka_exp); ?></span>
                  <small><?= htmlspecialchars($label_exp); ?></small>
               </div>
               
               <div class="amain">
                  <img src="<?= $gambar_1; ?>" alt="Restaurant Main"/>
               </div>
               <div class="asm">
                  <img src="<?= $gambar_2; ?>" alt="Restaurant Sub"/>
               </div>
            </div>
         </div>

         <!-- TEKS & 3 POIN KEUNGGULAN -->
         <div class="col-lg-7" data-aos="fade-left">
            <h2 class="stitle text-start">
               <?= $judul_formatted; ?>
            </h2>
            <div class="sline lft"></div>
            
            <p class="sdesc mb-4">
               <?= nl2br(htmlspecialchars($about['deskripsi_singkat'] ?? '')); ?>
            </p>

            <div class="mb-4">
               <!-- POIN 1 -->
               <div class="fti">
                  <div class="ftico r"><i class="fas fa-leaf"></i></div>
                  <div>
                     <h6><?= htmlspecialchars($about['poin_1_judul'] ?? '100% Bahan-Bahan Segar'); ?></h6>
                     <p><?= htmlspecialchars($about['poin_1_desc'] ?? ''); ?></p>
                  </div>
               </div>

               <!-- POIN 2 -->
               <div class="fti">
                  <div class="ftico y"><i class="fas fa-award"></i></div>
                  <div>
                     <h6><?= htmlspecialchars($about['poin_2_judul'] ?? 'Resep Peraih Penghargaan'); ?></h6>
                     <p><?= htmlspecialchars($about['poin_2_desc'] ?? ''); ?></p>
                  </div>
               </div>

               <!-- POIN 3 -->
               <div class="fti">
                  <div class="ftico g"><i class="fas fa-shipping-fast"></i></div>
                  <div>
                     <h6><?= htmlspecialchars($about['poin_3_judul'] ?? 'Pengiriman Secepat Kilat'); ?></h6>
                     <p><?= htmlspecialchars($about['poin_3_desc'] ?? ''); ?></p>
                  </div>
               </div>
            </div>

         </div>
      </div>
   </div>
</section>