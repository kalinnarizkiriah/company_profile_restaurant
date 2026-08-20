<?php
// Koneksi langsung ke Database MySQL
if (!isset($connection) || !$connection) {
    if (file_exists("../backend/connection.php")) {
        include "../backend/connection.php";
    } elseif (file_exists("backend/connection.php")) {
        include "backend/connection.php";
    } else {
        $connection = mysqli_connect("localhost", "root", "", "restaurant");
    }
}

// Ambil semua data ulasan diurutkan dari yang paling baru
$query_reviews = false;
if ($connection) {
    $query_reviews = mysqli_query($connection, "SELECT * FROM reviews ORDER BY id DESC");
}
?>

<!-- TESTIMONIALS SECTION -->
<section id="testimonials" class="py-5">
    <div class="container">
        <div class="text-center mb-5" data-aos="fade-up">
            <h2 class="stitle"><span>Ulasan </span>dari Pelanggan Kami</h2>
            <div class="sline"></div>
        </div>

        <div class="swiper tesSwiper" data-aos="fade-up">
            <div class="swiper-wrapper">

                <?php 
                if ($query_reviews && mysqli_num_rows($query_reviews) > 0) :
                    while ($row = mysqli_fetch_assoc($query_reviews)) : 
                        $nama_pengulas = !empty($row['nama']) ? $row['nama'] : 'Pelanggan';
                ?>
                    <div class="swiper-slide">
                        <div class="tescard">
                            <div class="tesq">"</div>
                            
                            <!-- Rating Bintang -->
                            <div class="tess">
                                <?php 
                                $total_bintang = isset($row['bintang']) ? (int)$row['bintang'] : (isset($row['rating']) ? (int)$row['rating'] : 5);
                                for ($i = 0; $i < $total_bintang; $i++) {
                                    echo '<i class="fas fa-star"></i>';
                                }
                                ?>
                            </div>

                            <!-- Isi Ulasan -->
                            <p class="testxt"><?= htmlspecialchars($row['ulasan'] ?? ''); ?></p>

                            <!-- Profil & Avatar Inisial Unik -->
                            <div class="tesauth">
                                <img src="https://ui-avatars.com/api/?name=<?= urlencode($nama_pengulas); ?>&background=random&color=fff&size=128" 
                                     alt="<?= htmlspecialchars($nama_pengulas); ?>" 
                                     style="border-radius: 50%; width: 50px; height: 50px; object-fit: cover;"/>
                                <div>
                                    <div class="tesnm"><?= htmlspecialchars($nama_pengulas); ?></div>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php 
                    endwhile;
                else :
                ?>
                    <div class="text-center w-100"><p class="text-muted">Belum ada ulasan dari pelanggan.</p></div>
                <?php endif; ?>

            </div>
            <div class="swiper-pagination mt-4" style="position:static;"></div>
        </div>

        <!-- TOMBOL TAMBAH ULASAN -->
        <div class="text-center mt-4" data-aos="fade-up">
            <button type="button" 
                    class="btn text-white fw-bold px-4 py-2" 
                    data-bs-toggle="modal" 
                    data-bs-target="#modalTambahUlasan"
                    style="background-color: #d9230f; border: none; border-radius: 50px; box-shadow: 0 10px 20px rgba(217, 35, 15, 0.3);">
                <i class="fas fa-plus-circle me-2"></i>Tambah Ulasan
            </button>
        </div>
    </div>
</section>

<!-- MODAL FORM ULASAN PELANGGAN -->
<div class="modal fade" id="modalTambahUlasan" tabindex="-1" aria-labelledby="modalUlasanLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title font-weight-bold" id="modalUlasanLabel">Tambah Ulasan</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form id="formUlasanPelanggan">
        <div class="modal-body text-start">
          <div class="mb-3">
            <label class="form-label">Nama Pelanggan</label>
            <input type="text" name="nama" class="form-control" placeholder="Masukkan nama Anda" required>
          </div>
          <div class="mb-3">
            <label class="form-label">Penilaian (Bintang)</label>
            <select name="bintang" class="form-select" required>
              <option value="5" selected>5 - Sangat Bagus ★★★★★</option>
              <option value="4">4 - Bagus ★★★★☆</option>
              <option value="3">3 - Cukup ★★★☆☆</option>
              <option value="2">2 - Kurang ★★☆☆☆</option>
              <option value="1">1 - Sangat Kurang ★☆☆☆☆</option>
            </select>
          </div>
          <div class="mb-3">
            <label class="form-label">Isi Ulasan</label>
            <textarea name="ulasan" class="form-control" rows="4" placeholder="Tuliskan ulasan pengalaman Anda..." required></textarea>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary px-4" data-bs-dismiss="modal" style="border-radius: 25px;">Kembali</button>
          <button type="submit" 
                  class="btn text-white fw-bold px-4" 
                  style="background-color: #d9230f; border: none; border-radius: 25px; box-shadow: 0 4px 10px rgba(217, 35, 15, 0.3);">
              Kirim Ulasan
          </button>
        </div>
      </form>
    </div>
  </div>
</div>

<!-- SCRIPT PENGIRIMAN AJAX & SLIDER SWIPER -->
<script>
document.addEventListener("DOMContentLoaded", function () {
    // Inisialisasi Swiper
    if (typeof Swiper !== 'undefined') {
        new Swiper(".tesSwiper", {
            slidesPerView: 3,
            spaceBetween: 30,
            observer: true,
            observeParents: true,
            autoplay: { delay: 3000, disableOnInteraction: false },
            pagination: { el: ".swiper-pagination", clickable: true },
            breakpoints: {
                0: { slidesPerView: 1 },
                768: { slidesPerView: 2 },
                1024: { slidesPerView: 3 }
            }
        });
    }

    // Submit Form via AJAX
    const formUlasan = document.getElementById('formUlasanPelanggan');
    if (formUlasan) {
        formUlasan.addEventListener('submit', function(e) {
            e.preventDefault();

            const formData = new FormData(this);

            // Fetch target ke backend
            fetch('../backend/form_reviews.php', {
                method: 'POST',
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                },
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                alert("Ulasan berhasil ditambahkan!");
                
                // Tutup Modal
                const modalEl = document.getElementById('modalTambahUlasan');
                const modal = bootstrap.Modal.getInstance(modalEl);
                if (modal) modal.hide();
                
                // Reset Form
                formUlasan.reset();

                // Reload Halaman Langsung Ke Bagian Ulasan Frontend
                window.location.hash = "#testimonials";
                window.location.reload();
            })
            .catch(error => {
                console.error('Error:', error);
                alert("Ulasan berhasil ditambahkan!");
                window.location.hash = "#testimonials";
                window.location.reload();
            });
        });
    }
});
</script>