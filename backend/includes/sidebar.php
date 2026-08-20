<?php
include_once __DIR__ . '/../connection.php'; 

// Hitung pesan yang belum dibaca
$query_count  = "SELECT COUNT(*) AS total_pesan FROM contacts WHERE status_dibaca = 0";
$result_count = mysqli_query($connection, $query_count);
$row_count    = mysqli_fetch_assoc($result_count);
$total_pesan  = $row_count['total_pesan'] ?? 0;

// Hitung reservasi yang belum dibaca
$query_reser  = "SELECT COUNT(*) AS total_reservasi FROM reservations WHERE status_dibaca = 0";
$result_reser = mysqli_query($connection, $query_reser);
$row_reser    = mysqli_fetch_assoc($result_reser);
$total_reservasi = $row_reser['total_reservasi'] ?? 0;
?>

<?php
// Ambil nama file saat ini
$current_page = basename($_SERVER['PHP_SELF']);
?>

<!-- Sidebar -->
<ul class="navbar-nav sidebar sidebar-dark accordion" id="accordionSidebar" style="background-color: #E33A26;">

    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="index.php">
        <div class="sidebar-brand-icon rotate-n-15">
            <i class="fas fa-utensils"></i>
        </div>
        <div class="sidebar-brand-text mx-3">Restoran</div>
    </a>

    <!-- Divider -->
    <hr class="sidebar-divider my-0">

    <!-- Dashboard -->
    <li class="nav-item <?= ($current_page == 'index.php') ? 'active' : ''; ?>">
        <a class="nav-link" href="index.php">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>Dashboard</span>
        </a>
    </li>

<!-- Nav Item - Tentang -->
    <li class="nav-item <?= ($current_page == 'about.php') ? 'active' : ''; ?>">
        <a class="nav-link" href="about.php">
            <i class="fas fa-fw fa-info-circle"></i>
            <span>Tentang</span>
        </a>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider">

    <div class="sidebar-heading">
        Kelola Restoran
    </div>

    <!-- Profile -->
    <li class="nav-item <?= ($current_page == 'tabel_profile.php' || $current_page == 'form_insert_profile.php' || $current_page == 'edit_profile.php') ? 'active' : ''; ?>">
        <a class="nav-link" href="tabel_profile.php">
            <i class="fas fa-fw fa-utensils"></i>
            <span>Profile</span>
        </a>
    </li>

    <!-- Daftar Menu -->
    <li class="nav-item <?= ($current_page == 'tabel_menu.php' || $current_page == 'form_insert_menu.php' || $current_page == 'edit_menu.php') ? 'active' : ''; ?>">
        <a class="nav-link" href="tabel_menu.php">
            <i class="fas fa-fw fa-utensils"></i>
            <span>Daftar Menu</span>
        </a>
    </li>


    <!-- Koki -->
    <li class="nav-item <?= ($current_page == 'tabel_chefs.php' || $current_page == 'form_insert_chefs.php' || $current_page == 'edit_chefs.php') ? 'active' : ''; ?>">
        <a class="nav-link" href="tabel_chefs.php">
            <i class="fas fa-fw fa-user"></i>
            <span>Koki</span>
        </a>
    </li>

    <!-- Reservasi -->
<li class="nav-item <?= ($current_page == 'tabel_reservations.php') ? 'active' : '' ?>">
    <a class="nav-link d-flex align-items-center justify-content-between" href="tabel_reservations.php">
        <div>
            <i class="fas fa-fw fa-calendar-alt me-2"></i>
            <span>Reservasi</span>
        </div>
        
        <!-- Badge angka merah untuk reservasi -->
        <?php if (!empty($total_reservasi) && $total_reservasi > 0): ?>
            <span class="badge bg-danger rounded-pill px-2 py-1" style="font-size: 11px;"><?= $total_reservasi ?></span>
        <?php endif; ?>
    </a>
</li>

     <!-- Reviews -->
    <li class="nav-item <?= ($current_page == 'tabel_reviews.php' || $current_page == 'form_insert_reviews.php' || $current_page == 'update_reviews.php') ? 'active' : ''; ?>">
        <a class="nav-link" href="tabel_reviews.php">
            <i class="fas fa-star"></i>
            <span>Reviews</span>
        </a>
    </li>

    <!-- Kontak / Pesan -->
<li class="nav-item <?= ($current_page == 'tabel_contacts.php' || $current_page == 'form_insert_contacts.php') ? 'active' : '' ?>">
    <a class="nav-link d-flex align-items-center justify-content-between" href="tabel_contacts.php">
        <div>
            <i class="fas fa-fw fa-envelope me-2"></i>
            <span>Pesan</span>
        </div>
        
        <!-- Badge angka merah -->
        <?php if (!empty($total_pesan) && $total_pesan > 0): ?>
            <span class="badge bg-danger rounded-pill px-2 py-1" style="font-size: 11px;"><?= $total_pesan ?></span>
        <?php endif; ?>
    </a>
</li>


    <!-- Divider -->
    <hr class="sidebar-divider d-none d-md-block">

</ul>