<!-- ============================================================
     NAVBAR
     ============================================================ -->
<nav class="navbar navbar-expand-lg" id="nav">
   <div class="container">
      <a class="navbar-brand" href="#">
         <div class="blogo d-flex align-items-center">
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

            <!-- Tombol Riwayat Pesanan -->
<?php if (isset($_SESSION['login_customer'])) : ?>
    <a href="partials/riwayat-pesanan.php" class="btn text-white text-decoration-none d-flex align-items-center gap-1 px-3 py-2" style="background-color: #d9230f; border: none; border-radius: 10px; font-size: 0.95rem; box-shadow: 0 4px 10px rgba(217, 35, 15, 0.3);">
        <i class="fas fa-history"></i> Riwayat
    </a>
<?php endif; ?>

            <?php if (isset($_SESSION['login_customer'])) : ?>
                <!-- TAMPILAN USER SUDAH LOGIN -->
                <div class="custom-dropdown position-relative" style="z-index: 99999;">
                    <button type="button" onclick="toggleUserMenu()" class="btn text-white px-3 py-2 d-flex align-items-center gap-2" style="background-color: #d9230f; border: none; border-radius: 10px; box-shadow: 0 4px 10px rgba(217, 35, 15, 0.3);">
                        <i class="fas fa-user-circle"></i>
                        <!-- PERUBAHAN DISINI: Menggunakan customer_nama_lengkap -->
                        <span class="ms-2">
    <span><?= isset($_SESSION['customer_nama_lengkap']) ? htmlspecialchars($_SESSION['customer_nama_lengkap']) : 'Customer'; ?></span>
</span> 
                        <i class="fas fa-chevron-down small"></i>
                    </button>

                    <!-- MENU MELAYANG KEBAWAH (LOGOUT) -->
                    <div id="userMenuDropdown" class="shadow-lg bg-white rounded-3 py-2" style="display: none; position: absolute; right: 0; top: 110%; min-width: 160px; border: 1px solid #eee;">
                        <a href="partials/logout_customer.php" 
                           onclick="return confirm('Apakah Anda yakin ingin keluar?');" 
                           class="d-block px-3 py-2 text-danger text-decoration-none fw-semibold border-0 bg-transparent text-start w-100 hover-bg-light">
                            <i class="fas fa-sign-out-alt me-2"></i> Logout
                        </a>
                    </div>
                </div>

                <script>
                function toggleUserMenu() {
                    var menu = document.getElementById("userMenuDropdown");
                    if (menu.style.display === "none" || menu.style.display === "") {
                        menu.style.display = "block";
                    } else {
                        menu.style.display = "none";
                    }
                }

                // Tutup menu otomatis kalau klik di luar area tombol
                document.addEventListener("click", function(event) {
                    var dropdown = document.querySelector(".custom-dropdown");
                    if (dropdown && !dropdown.contains(event.target)) {
                        var userMenu = document.getElementById("userMenuDropdown");
                        if (userMenu) userMenu.style.display = "none";
                    }
                });
                </script>

            <?php else : ?>
                <!-- TAMPILAN BELUM LOGIN -->
                <a href="partials/login_customer.php" class="btn text-white" style="background-color: #d9230f; border: none; border-radius: 10px; padding: 6px 20px; box-shadow: 0 4px 10px rgba(217, 35, 15, 0.3);">
                    <i class="fas fa-user me-1"></i> Masuk / Daftar
                </a>
            <?php endif; ?>
         </div>
      </div>
   </div>
</nav>