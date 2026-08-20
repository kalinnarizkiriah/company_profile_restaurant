<?php
// 1. Koneksi ke database
$db = mysqli_connect("localhost", "root", "", "restaurant");

// 2. Ambil data koki dari database
if ($db) {
    $query_chefs = mysqli_query($db, "SELECT * FROM chefs ORDER BY id ASC");
} else {
    $query_chefs = false;
}
?>

<!-- CHEFS -->
<section id="chefs">
    <div class="container">
        <div class="text-center mb-5" data-aos="fade-up">
            <h2 class="stitle">Temui <span>Koki</span> Ahli Kami</h2>
            <div class="sline"></div>
        </div>
        <div class="row g-4">

            <?php 
            if ($query_chefs && mysqli_num_rows($query_chefs) > 0) {
                $delay = 0;
                while ($row = mysqli_fetch_assoc($query_chefs)) : 
                    
                    // --- FIX UTAMA: AMBIL HANYA NAMA FILE NYA SAJA (MEMBUANG PATH DOUBLE) ---
                    $foto_db = trim($row['photo']);
                    
                    if (!empty($foto_db)) {
                        // basename() akan mengambil murni nama file (misal: 1786514928_kalin.jpeg) 
                        // meskipun di DB tersimpan "img/chefs/1786514928_kalin.jpeg"
                        $nama_file_saja = basename($foto_db);
                        $foto_koki = '../backend/img/chefs/' . $nama_file_saja;
                    } else {
                        $foto_koki = '../backend/img/chefs/1786514909_obet.jpeg';
                    }

                    // --- Format Teks Pengalaman ---
                    $exp_raw = trim($row['experience']);
                    if (is_numeric($exp_raw)) {
                        $experience_text = $exp_raw . ' Tahun Pengalaman';
                    } else {
                        $experience_text = !empty($exp_raw) ? $exp_raw : '0 Tahun Pengalaman';
                    }

                    $link_social = !empty($row['social']) ? htmlspecialchars($row['social']) : '#';
            ?>
                <div class="col-sm-6 col-lg-3" data-aos="fade-up" data-aos-delay="<?= $delay; ?>">
                    <div class="chcard">
                        <div class="chimg">
                            <img src="<?= htmlspecialchars($foto_koki); ?>" alt="<?= htmlspecialchars($row['name']); ?>"/>
                            <div class="chsoc">
                                <a href="<?= $link_social; ?>" target="_blank"><i class="fab fa-instagram"></i></a>
                                <a href="<?= $link_social; ?>" target="_blank"><i class="fab fa-facebook-f"></i></a>
                                <a href="<?= $link_social; ?>" target="_blank"><i class="fab fa-twitter"></i></a>
                            </div>
                        </div>
                        <div class="chbody">
                            <div class="chnm"><?= htmlspecialchars($row['name']); ?></div>
                            <div class="chrole"><?= htmlspecialchars($row['role']); ?></div>
                            <div class="chexp"><?= htmlspecialchars($experience_text); ?></div>
                        </div>
                    </div>
                </div>
            <?php 
                    $delay += 80;
                endwhile;
            } else {
                echo '<div class="col-12 text-center"><p>Data koki belum tersedia.</p></div>';
            }
            ?>

        </div>
    </div>
</section>