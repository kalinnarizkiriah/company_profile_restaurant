<?php
// 1. Ambil data dari database ($profile dikirim dari index.php)
$nama             = $profile['nama'] ?? '';
$deskripsi        = $profile['deskripsi'] ?? '';
$badge_text       = $profile['badge_text'] ?? '';
$gambar_hero      = $profile['gambar_hero'] ?? '';
$teks_promo       = $profile['teks_promo'] ?? '';
$waktu_pengiriman = $profile['waktu_pengiriman'] ?? '';
$teks_rating       = $profile['teks_rating'] ?? '';

// 2. Mewarnai "Makanan Cepat Saji" / "Delicious Fast Food" menjadi merah (#e52e2e)
$nama_highlight = str_replace(
    ['Makanan Cepat Saji', 'Delicious Fast Food', 'makanan cepat saji', 'delicious fast food'], 
    [
        '<span style="color: #e52e2e;">Makanan Cepat Saji</span>', 
        '<span style="color: #e52e2e;">Delicious Fast Food</span>',
        '<span style="color: #e52e2e;">makanan cepat saji</span>',
        '<span style="color: #e52e2e;">delicious fast food</span>'
    ], 
    htmlspecialchars($nama)
);
?>

<!-- ============================================================
     HERO (DINAMIS)
     ============================================================ -->
<section id="hero">
   <div class="hs hs1"></div>
   <div class="hs hs2"></div>
   <div class="hbgtxt">FOOD</div>
   <div class="container">
      <div class="row align-items-center g-5" style="min-height:88vh;">
         <div class="col-lg-6">
            <div class="hbadge">
               <div class="hbi"><i class="fas fa-star"></i></div>
               <!-- Ambil badge_text dari database -->
               <span><?= htmlspecialchars($badge_text != '' ? $badge_text : '#1 Restoran Khas Jogja'); ?></span>
            </div>
            
            <!-- Judul Utama dengan Makanan Cepat Saji Berwarna Merah -->
            <h1 class="htitle"><?= $nama_highlight; ?></h1>
            
            <!-- Ambil deskripsi dari database -->
            <p class="hdesc"><?= htmlspecialchars($deskripsi); ?></p>
            
            <div class="d-flex flex-wrap gap-3 mb-2">
               <!-- Magnific popup video trigger -->
               <a href="https://www.youtube.com/watch?v=RXv_uIN6e-Y" class="magnific_popup btn-play popup-youtube">
               </a>
            </div>
         </div>
         
         <div class="col-lg-6">
            <div style="position:relative;text-align:center;">
               <div class="hcircle">
                  <!-- Ambil gambar_hero dari database -->
                  <img src="../backend/img/category/<?= htmlspecialchars($gambar_hero); ?>" alt="<?= htmlspecialchars($nama); ?>">
               </div>
               
               <div class="fcard fc1">
                  <div class="fcoi r"><i class="fas fa-fire"></i></div>
                  <div>
                     <!-- Ambil teks_promo dari database -->
                     <span class="fcnum">Promo</span>
                     <span class="fcsm"><?= htmlspecialchars($teks_promo != '' ? $teks_promo : 'Diskon Spesial'); ?></span>
                  </div>
               </div>
               
               <div class="fcard fc2">
                  <div class="fcoi y"><i class="fas fa-star"></i></div>
                  <div>
                     <!-- Ambil teks_rating dari database -->
                     <span class="fcnum">Rating</span>
                     <span class="fcsm"><?= htmlspecialchars($teks_rating != '' ? $teks_rating : '4.9 / 5'); ?></span>
                  </div>
               </div>
               
               <div class="fcard fc3">
                  <div class="fcoi g"><i class="fas fa-clock"></i></div>
                  <div>
                     <!-- Ambil waktu_pengiriman dari database -->
                     <span class="fcnum">Estimasi</span>
                     <span class="fcsm"><?= htmlspecialchars($waktu_pengiriman != '' ? $waktu_pengiriman : '20 Menit'); ?></span>
                  </div>
               </div>
            </div>
         </div>
      </div>
   </div>
</section>