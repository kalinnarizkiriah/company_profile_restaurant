<!-- Topbar -->
<nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">

    <!-- Sidebar Toggle (Topbar) -->
    <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
        <i class="fa fa-bars"></i>
    </button>

    <!-- Topbar Navbar -->
    <ul class="navbar-nav ml-auto">

        <div class="topbar-divider d-none d-sm-block"></div>

        <!-- Nav Item - User Information -->
        <li class="nav-item dropdown no-arrow">
            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button"
                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                
                <!-- Nama Lengkap -->
                <span class="mr-2 d-none d-lg-inline text-gray-600 small">
                    <?= isset($_SESSION['admin_nama_lengkap']) ? $_SESSION['admin_nama_lengkap'] : 'Administrator'; ?>
                </span>
                
                <?php 
                    // Cek role yang sedang login di session, lalu tentukan fotonya
                    $role_login = $_SESSION['admin_role'] ?? '';
                    
                    if ($role_login === 'super_admin') {
                        $foto_profil = 'img/category/kalin.jpeg'; // Foto khusus Super Admin (Kalinna)
                    } else {
                        $foto_profil = 'img/category/obet.jpeg';  // Foto khusus Admin biasa (silakan ganti nama file foto adminnya di sini)
                    }
                ?>

                <!-- Foto Profil Dinamis -->
                <img class="img-profile rounded-circle" src="<?= $foto_profil; ?>" style="width: 30px; height: 30px; object-fit: cover;">
            </a>
            
            <!-- Dropdown - User Information -->
            <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in"
                aria-labelledby="userDropdown">
                <a class="dropdown-item" href="logout.php" onclick="return confirm('Apakah Anda yakin ingin keluar?');">
                    <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                    Logout
                </a>
            </div>
        </li>

    </ul>

</nav>
<!-- End of Topbar -->