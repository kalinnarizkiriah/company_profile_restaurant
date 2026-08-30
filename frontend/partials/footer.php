<footer>
   <div class="container">
      <div class="row g-5">
         <div class="col-lg-4">
            <div class="fnm">Resto<span>Jogja</span></div>
            <p class="fdesc">Kami menghadirkan cita rasa terbaik dunia secara bersamaan dalam pengalaman yang cepat, ramah, dan terjangkau. Setiap hidangan dibuat dengan cinta.</p>
         </div>

         <div class="col-sm-6 col-lg-2">
            <div class="ftit">Tautan Cepat</div>
            <ul class="flinks ps-0">
               <li><a href="#hero"><i class="fa-solid fa-chevron-right"></i>Rumah</a></li>
               <li><a href="#about"><i class="fa-solid fa-chevron-right"></i>Tentang</a></li>
               <li><a href="#menu"><i class="fa-solid fa-chevron-right"></i>Menu</a></li>
               <li><a href="#chefs"><i class="fa-solid fa-chevron-right"></i>Koki</a></li>
               <li><a href="#reservation"><i class="fa-solid fa-chevron-right"></i>Reservasi</a></li>
               <li><a href="#testimonials"><i class="fa-solid fa-chevron-right"></i>Ulasan</a></li>
               <li><a href="#contact-section"><i class="fa-solid fa-chevron-right"></i>Kontak</a></li>
            </ul>
         </div>

         <div class="col-sm-6 col-lg-2">
            <div class="ftit">Menu Kami</div>
            <ul class="flinks ps-0">
               <li><a href="#menu" onclick="filterMenuDirect('makanan-ringan')"><i class="fa-solid fa-chevron-right"></i>Makanan Ringan</a></li>
               <li><a href="#menu" onclick="filterMenuDirect('makanan-utama')"><i class="fa-solid fa-chevron-right"></i>Makanan Utama</a></li>
               <li><a href="#menu" onclick="filterMenuDirect('makanan-berat')"><i class="fa-solid fa-chevron-right"></i>Makanan Berat</a></li>
               <li><a href="#menu" onclick="filterMenuDirect('minuman-dingin')"><i class="fa-solid fa-chevron-right"></i>Minuman Dingin</a></li>
               <li><a href="#menu" onclick="filterMenuDirect('minuman-hangat')"><i class="fa-solid fa-chevron-right"></i>Minuman Hangat</a></li>
            </ul>
         </div>

         <div class="col-lg-4">
            <div class="ftit">Hubungi Kami</div>
            <div class="fci">
               <div class="fciico"><i class="fa-solid fa-location-dot"></i></div>
               <div class="fciinfo"><strong>Alamat</strong>Gamping-Sleman,YK</div>
            </div>
            <div class="fci">
               <div class="fciico"><i class="fa-solid fa-phone"></i></div>
               <div class="fciinfo"><strong>Telepon / WhatsApp</strong>+62 858-7147-2153</div>
            </div>
            <div class="fci">
               <div class="fciico"><i class="fa-solid fa-envelope"></i></div>
               <div class="fciinfo"><strong>Email</strong>hello@restojogja.com</div>
            </div>
            <div class="fci">
               <div class="fciico"><i class="fa-solid fa-clock"></i></div>
               <div class="fciinfo"><strong>Jam Buka</strong>Rabu – Minggu, 09.00 - 23.00 WIB</div>
            </div>
         </div>
      </div>
   </div>

   <div class="fbot">
      <div class="container">
         <div class="row">
            <div class="col-12 text-center">
               <p class="mb-0">
                  © 2026 <a href="#" class="text-danger fw-bold text-decoration-none">Restoran Jogja Istimewa</a>. All Rights Reserved.
               </p>
            </div>
         </div>
      </div>
   </div>
</footer>

<button id="btt" onclick="window.scrollTo({top:0,behavior:'smooth'})"><i class="fa-solid fa-chevron-up"></i></button>

<script src="js/jquery-3.7.1.min.js"></script>
<script src="js/bootstrap.bundle.min.js"></script>
<script src="js/aos.js"></script>
<script src="js/swiper-bundle.min.js"></script>
<script src="js/jquery.magnific-popup.min.js"></script>
<script src="js/main.js"></script>

<script>
// Fungsi yang dipanggil langsung saat link di footer diklik
function filterMenuDirect(categorySlug) {
    const targetBtn = document.querySelector(`.filtbtn[data-f="${categorySlug}"]`);
    if (targetBtn) {
        targetBtn.click();
    }
    const menuSection = document.getElementById('menu');
    if (menuSection) {
        menuSection.scrollIntoView({ behavior: 'smooth' });
    }
}

// Handler saat halaman di-refresh/dibuka pertama kali dengan parameter URL
document.addEventListener("DOMContentLoaded", function() {
    const urlParams = new URLSearchParams(window.location.search);
    const categoryParam = urlParams.get('category');

    if (categoryParam) {
        const slug = categoryParam.toLowerCase().trim().replace(/[^a-z0-9-]+/g, '-');
        setTimeout(() => {
            const targetBtn = document.querySelector(`.filtbtn[data-f="${slug}"]`);
            if (targetBtn) {
                targetBtn.click();
            }
            const menuSection = document.getElementById('menu');
            if (menuSection) {
                menuSection.scrollIntoView({ behavior: 'smooth' });
            }
        }, 300);
    }
});
</script>
</body>
</html>