      <!-- ============================================================
         NAVBAR
         ============================================================ -->
      <nav class="navbar navbar-expand-lg" id="nav">
         <div class="container">
          <a class="navbar-brand" href="#">
   <div class="blogo d-flex align-items-center">
      <!-- GANTI DIV BICO DENGAN TAG IMG INI -->
      <img src="../backend/img/category/logojogja.jpeg" 
           alt="Logo Resto" 
           style="width: 50px; height: 50px; object-fit: cover; border-radius: 50%; flex-shrink: 0;">
      
      <div class="ms-2">
         <div class="bname">Resto <span>Jogja</span></div>
         <div class="bsub">Makanan Cepat Saji & Restoran</div>
      </div>
   </div>
</a>
            <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#navmenu">
            <i class="fas fa-bars" style="color:var(--primary);font-size:1.35rem;"></i>
            </button>
            <div class="collapse navbar-collapse" id="navmenu">
               <ul class="navbar-nav mx-auto">
                  <li class="nav-item"><a class="nav-link active" href="#hero">Rumah</a></li>
                  <li class="nav-item"><a class="nav-link" href="#about">Tentang</a></li>
                  <li class="nav-item"><a class="nav-link" href="#menu">Menu</a></li>
                  <li class="nav-item"><a class="nav-link" href="#chefs">Koki</a></li>
                  <li class="nav-item"><a class="nav-link" href="#reservation">Reservasi</a></li>
                  <li class="nav-item"><a class="nav-link" href="#testimonials">Ulasan</a></li>
                  <li class="nav-item"><a class="nav-link" href="#contact-section">Kontak</a></li>
               </ul>
               <div class="d-flex align-items-center gap-2">
    

<!-- Tombol Keranjang Belanja -->
<button type="button" class="btn text-white position-relative ms-2 me-2" data-bs-toggle="modal" data-bs-target="#modalKeranjang" style="display: inline-block !important; z-index: 999; background-color: #d9230f; border: none; border-radius: 10px; box-shadow: 0 4px 10px rgba(217, 35, 15, 0.3);">
    <i class="fas fa-shopping-cart"></i>
    <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-dark">
        <?php echo isset($_SESSION['cart']) ? array_sum(array_column($_SESSION['cart'], 'qty')) : '0'; ?>
    </span>
</button>

</div>
            </div>
         </div>
      </nav>