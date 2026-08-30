<?php
include_once __DIR__ . '/../connection.php'; 

// pesan/contacts
$query_message = "SELECT COUNT(*) AS total_messages FROM contacts WHERE status_dibaca = 0";
$result_message = mysqli_query($connection, $query_message);
$row_message = mysqli_fetch_assoc($result_message);
$total_messages = $row_message['total_messages'] ?? 0;

// reservasi
$query_reservation = "SELECT COUNT(*) AS total_reservations FROM reservations WHERE status_dibaca = 0";
$result_reservation = mysqli_query($connection, $query_reservation);
$row_reservation = mysqli_fetch_assoc($result_reservation);
$total_reservations = $row_reservation['total_reservations'] ?? 0;

// ulasan 
$query_review = "SELECT COUNT(*) AS total_reviews FROM reviews WHERE status_dibaca = 0";
$result_review = mysqli_query($connection, $query_review);
$row_review = mysqli_fetch_assoc($result_review);
$total_reviews = $row_review['total_reviews'] ?? 0;

// pesanan baru (menunggu konfirmasi atau pembayaran di kasir)
$query_pesanan = "SELECT COUNT(*) AS jml FROM pesanan WHERE status_pesanan = 'Menunggu Konfirmasi' OR status_pesanan = 'Menunggu Pembayaran di Kasir'";
$result_pesanan = mysqli_query($connection, $query_pesanan);
$row_pesanan = mysqli_fetch_assoc($result_pesanan);
$jumlah_pesanan_baru = $row_pesanan['jml'] ?? 0;
?>

<?php
// Ambil nama file saat ini
$current_page = basename($_SERVER['PHP_SELF']);
?>

<!-- Sidebar -->
<ul class="navbar-nav sidebar sidebar-dark accordion" id="accordionSidebar" style="background-color: #E33A26;">

    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="index.php">
        <div class="sidebar-brand-icon">
            <img src="img/category/logojogja.jpeg" alt="Logo" class="rounded-circle" style="width: 40px; height: 40px; object-fit: cover;">
        </div>
        <div class="sidebar-brand-text mx-3">Resto Jogja</div>
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

    <!-- Nav Item - Reservasi -->
    <li class="nav-item <?= ($current_page == 'tabel_reservations.php') ? 'active' : ''; ?>">
        <a id="reservasi-menu" class="nav-link d-flex align-items-center justify-content-between" href="tabel_reservations.php">
            <div>
                <i class="fas fa-fw fa-calendar-alt me-2"></i>
                <span>Reservasi</span>
            </div>
            <?php if (!empty($total_reservations) && $total_reservations > 0) : ?>
                <span id="reservasi-badge" class="badge bg-danger rounded-pill px-2 py-1" style="font-size: 11px;"><?= $total_reservations; ?></span>
            <?php endif; ?>
        </a>
    </li>

    <!-- Nav Item - Reviews -->
    <li class="nav-item <?= ($current_page == 'tabel_reviews.php' || $current_page == 'form_insert_reviews.php') ? 'active' : ''; ?>">
        <a id="review-menu" class="nav-link d-flex align-items-center justify-content-between" href="tabel_reviews.php">
            <div>
                <i class="fas fa-fw fa-star me-2"></i>
                <span>Ulasan</span>
            </div>
            <?php if (!empty($total_reviews) && $total_reviews > 0): ?>
                <span id="review-badge" class="badge bg-danger rounded-pill px-2 py-1" style="font-size: 11px;"><?= $total_reviews ?></span>
            <?php endif; ?>
        </a>
    </li>

    <!-- Nav Item - Pesan -->
    <li class="nav-item <?= ($current_page == 'tabel_contacts.php') ? 'active' : ''; ?>">
        <a id="pesan-menu" class="nav-link d-flex align-items-center justify-content-between" href="tabel_contacts.php">
            <div>
                <i class="fas fa-fw fa-envelope me-2"></i>
                <span>Pesan</span>
            </div>
            <?php if (!empty($total_messages) && $total_messages > 0): ?>
                <span id="pesan-badge" class="badge bg-danger rounded-pill px-2 py-1" style="font-size: 11px;"><?= $total_messages ?></span>
            <?php endif; ?>
        </a>
    </li>

    <?php if (isset($_SESSION['admin_role']) && $_SESSION['admin_role'] === 'super_admin') : ?>
<li class="nav-item <?= ($current_page == 'tabel_login.php') ? 'active' : ''; ?>">
    <a class="nav-link text-white d-flex align-items-center justify-content-between" href="tabel_login.php">
        <div>
            <i class="fas fa-users me-2"></i>
            <span>Kelola Akun</span>
        </div>
        <span id="badge-akun-baru" class="badge bg-danger rounded-pill px-2 py-1" style="display: none;"></span>
    </a>
</li>
<?php endif; ?>

    <!-- Menu Pesanan di Sidebar -->
  <li class="nav-item <?= ($current_page == 'pesanan.php') ? 'active' : ''; ?>">
        <a class="nav-link d-flex align-items-center justify-content-between" href="pesanan.php">
            <div>
                <i class="fas fa-fw fa-shopping-cart me-2"></i>
                <span>Pesanan</span>
            </div>
            <span id="badge-pesanan-baru" class="badge bg-danger rounded-pill px-2 py-1" style="font-size: 11px; <?= ($jumlah_pesanan_baru > 0) ? '' : 'display: none;'; ?>">
                <?= $jumlah_pesanan_baru; ?>
            </span>
        </a>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider d-none d-md-block">

</ul>
<script>
function updateBadgePesanan() {
    // Sesuaikan path ../backend/ jika file sidebar berada di luar folder backend
    fetch('../backend/cek_pesanan_baru.php?t=' + new Date().getTime())
        .then(response => response.json())
        .then(data => {
            const badge = document.getElementById('badge-pesanan-baru');
            if (badge) {
                // Sesuai dengan output PHP: echo json_encode(['total' => ...])
                if (data.total > 0) {
                    badge.textContent = data.total;
                    badge.style.display = 'inline-block'; // Munculkan badge
                } else {
                    badge.style.display = 'none'; // Sembunyikan jika 0
                }
            }
        })
        .catch(error => console.log('Gagal ambil data pesanan:', error));
}

// Jalankan otomatis saat halaman dimuat dan ulang setiap 2 detik
document.addEventListener('DOMContentLoaded', function() {
    updateBadgePesanan();
    setInterval(updateBadgePesanan, 2000);
});
</script>
