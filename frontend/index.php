<?php 
// Wajib diletakkan di baris paling pertama untuk membaca keranjang
session_start(); 

include '../backend/connection.php'; 

// ==========================================
// PROSES AJAX KERANJANG LANGSUNG DI INDEX.PHP
// ==========================================
if (isset($_GET['ajax_cart_action'])) {
    header('Content-Type: application/json');
    $action = $_GET['ajax_cart_action'];
    $id     = isset($_GET['id']) ? $_GET['id'] : null;

    if ($id && isset($_SESSION['cart'][$id])) {
        if ($action === 'increase') {
            $_SESSION['cart'][$id]['qty'] += 1;
        } elseif ($action === 'decrease') {
            $_SESSION['cart'][$id]['qty'] -= 1;
            if ($_SESSION['cart'][$id]['qty'] <= 0) {
                unset($_SESSION['cart'][$id]);
            }
        } elseif ($action === 'delete') {
            unset($_SESSION['cart'][$id]);
        }
    }

    // Hitung Ulang Total
    $total_items = 0;
    $grand_total = 0;
    $item_qty    = isset($_SESSION['cart'][$id]) ? $_SESSION['cart'][$id]['qty'] : 0;
    $subtotal    = 0;

    if (isset($_SESSION['cart']) && !empty($_SESSION['cart'])) {
        foreach ($_SESSION['cart'] as $item) {
            $total_items += $item['qty'];
            $harga = (int) preg_replace('/[^0-9]/', '', $item['harga']);
            $grand_total += ($harga * $item['qty']);
        }
    }

    if ($item_qty > 0 && isset($_SESSION['cart'][$id])) {
        $harga = (int) preg_replace('/[^0-9]/', '', $_SESSION['cart'][$id]['harga']);
        $subtotal = $harga * $item_qty;
    }

    echo json_encode([
        'status'      => 'success',
        'item_qty'    => $item_qty,
        'subtotal'    => 'Rp ' . number_format($subtotal, 0, ',', '.'),
        'grand_total' => 'Rp ' . number_format($grand_total, 0, ',', '.'),
        'total_items' => $total_items
    ]);
    exit; // Berhentikan eksekusi HTML untuk respons AJAX
}

$query_profile = mysqli_query($connection, "SELECT * FROM tb_profile LIMIT 1");
$profile       = mysqli_fetch_assoc($query_profile);
?>

<!DOCTYPE html>
<html lang="en">
   <head>
      <meta charset="UTF-8">
      <meta http-equiv="X-UA-Compatible" content="IE=edge">
      <meta name="viewport" content="width=device-width, initial-scale=1">
      <meta name="author" content="Sarab">
      <meta name="description" content="Sarab - Fast Food & Restaurant HTML Template">
      <title>Restoran Jogja Istimewa</title>
      <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;700;900&family=Poppins:wght@300;400;500;600;700&family=Dancing+Script:wght@700&display=swap" rel="stylesheet"/>
      <!-- Bootstrap 5.3 -->
      <link href="css/bootstrap.min.css" rel="stylesheet"/>
      <!-- AOS Animate on Scroll -->
      <link href="css/aos.css" rel="stylesheet"/>
      <!-- Swiper -->
      <link href="css/swiper-bundle.min.css" rel="stylesheet"/>
      <!-- all min css -->
      <link rel="stylesheet" href="css/all.min.css"/>
      <!-- magnific CSS -->
      <link rel="stylesheet" href="css/magnific-popup.css"/>
      <!-- Style CSS -->
      <link rel="stylesheet" href="css/style.css" />
      <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
   </head>
   <body>
      
    <!-- ini bagian topbar -->
    <?php include 'partials/topbar.php'; ?>

    <!-- ini bagian navbar -->
    <?php include 'partials/navbar.php'; ?>

    <!-- ini bagian search-overlay -->
    <?php include 'partials/search-overlay.php'; ?>

    <!-- ini bagian hero -->
    <?php include 'partials/hero.php'; ?>

    <!-- ini bagian marquee -->
    <?php include 'partials/marquee.php'; ?>
     
    <!-- ini bagian about -->
    <?php include 'partials/about.php'; ?>

    <!-- ini bagian menu -->
    <?php include 'partials/menu.php'; ?>
     
    <!-- ini bagian chefs -->
    <?php include 'partials/chefs.php'; ?>
     
    <!-- ini bagian reservation -->
    <?php include 'partials/reservation.php'; ?>
     
    <!-- ini bagian testimonials -->
    <?php include 'partials/testimonials.php'; ?>

    <!-- ini bagian contact -->
    <?php include 'partials/contact.php'; ?>
     
    <!-- ini bagian footer -->
    <?php include 'partials/footer.php'; ?>

    <!-- Import Modal Keranjang -->
    <?php include "partials/cart_modal.php"; ?>

<script src="js/jquery-3.7.1.min.js"></script>
<script src="js/bootstrap.bundle.min.js"></script>
<script src="js/aos.js"></script>
<script src="js/swiper-bundle.min.js"></script>
<script src="js/jquery.magnific-popup.min.js"></script>
<script src="js/main.js"></script>

<script>
// ==========================================
// SISTEM FILTER KATEGORI MENU (VANILLA / HYBRID)
// ==========================================
function slugify(text) {
    return text.toString().toLowerCase().trim()
        .replace(/\s+/g, '-')           // Ganti spasi dengan -
        .replace(/[^\w\-]+/g, '')       // Hapus karakter non-word
        .replace(/\-\-+/g, '-');        // Ganti ganda - dengan tunggal -
}

document.addEventListener("DOMContentLoaded", function() {
    
    // Delegasi Event Klik Tombol Filter
    document.addEventListener('click', function(e) {
        const filterBtn = e.target.closest('.filtbtn, [data-filter], [data-f]');
        if (!filterBtn) return;

        // Dapatkan target filter dari atribut data-f, data-filter, atau innerText
        let rawFilter = filterBtn.getAttribute('data-f') || filterBtn.getAttribute('data-filter') || filterBtn.innerText;
        let filterValue = rawFilter.toLowerCase().trim().replace(/^\./, ''); // Hilangkan titik jika ada

        // Update status UI tombol aktif
        const allBtns = document.querySelectorAll('.filtbtn, [data-filter], [data-f]');
        allBtns.forEach(btn => btn.classList.remove('active'));
        filterBtn.classList.add('active');

        // Jalankan Penyaringan Item Menu
        const menuItems = document.querySelectorAll('.menu-item, .single-menu, .grid-item');
        menuItems.forEach(item => {
            const categories = (item.getAttribute('data-category') || item.className).toLowerCase();
            
            if (filterValue === 'all' || filterValue === '*' || categories.includes(filterValue)) {
                item.style.display = '';
                item.classList.remove('d-none');
            } else {
                item.style.display = 'none';
                item.classList.add('d-none');
            }
        });
    });

    // Otomatis Filter Jika Ada Parameter URL ?category=...
    const urlParams = new URLSearchParams(window.location.search);
    const categoryParam = urlParams.get('category');
    if (categoryParam) {
        const slug = slugify(categoryParam);
        setTimeout(() => {
            const targetBtn = document.querySelector(`[data-f="${slug}"], [data-filter=".${slug}"], [data-filter="${slug}"]`);
            if (targetBtn) {
                targetBtn.click();
            } else {
                // Fallback pencarian teks tombol
                const btns = document.querySelectorAll('.filtbtn, [data-filter]');
                btns.forEach(btn => {
                    if (slugify(btn.innerText).includes(slug)) btn.click();
                });
            }
            const menuSection = document.getElementById('menu');
            if (menuSection) menuSection.scrollIntoView({ behavior: 'smooth' });
        }, 300);
    }
});

// ==========================================
// JAVASCRIPT KERANJANG ULTRA-COMPATIBLE
// ==========================================
(function() {
    document.addEventListener('click', function(e) {
        var btnQty = e.target.closest('.btn-update-qty');
        var btnDel = e.target.closest('.btn-delete-cart');

        if (btnQty) {
            e.preventDefault();
            e.stopPropagation();

            var id = btnQty.getAttribute('data-id');
            var nama = btnQty.getAttribute('data-nama');
            var action = btnQty.getAttribute('data-action');
            var row = btnQty.closest('tr');
            var qtySpan = row ? row.querySelector('.qty-val') : null;
            var currentQty = qtySpan ? parseInt(qtySpan.textContent.trim()) : 1;

            if (action === 'decrease' && currentQty <= 1) {
                if (confirm('Apakah Anda yakin ingin menghapus ' + (nama || 'item ini') + ' dari keranjang?')) {
                    eksekusiAksiKeranjang('delete', id, row);
                }
                return;
            }

            eksekusiAksiKeranjang(action, id, row);
        }

        if (btnDel) {
            e.preventDefault();
            e.stopPropagation();

            var id = btnDel.getAttribute('data-id');
            var nama = btnDel.getAttribute('data-nama');
            var row = btnDel.closest('tr');

            if (confirm('Apakah Anda yakin ingin menghapus ' + (nama || 'item ini') + ' dari keranjang?')) {
                eksekusiAksiKeranjang('delete', id, row);
            }
        }
    }, true);

    function eksekusiAksiKeranjang(action, id, row) {
        var xhr = new XMLHttpRequest();
        xhr.open('GET', 'index.php?ajax_cart_action=' + action + '&id=' + id, true);
        
        xhr.onload = function() {
            if (xhr.status === 200) {
                try {
                    var response = JSON.parse(xhr.responseText);
                    if (response.status === 'success') {
                        if (response.item_qty <= 0 || action === 'delete') {
                            if (row) row.remove();
                        } else {
                            var qtySpan = row.querySelector('.qty-val');
                            var subtotalTd = row.querySelector('.subtotal-val') || row.children[3];
                            
                            if (qtySpan) qtySpan.textContent = response.item_qty;
                            if (subtotalTd) subtotalTd.textContent = response.subtotal;
                        }

                        var grandTotalElems = document.querySelectorAll('#modalKeranjang h4, .grand-total-val');
                        grandTotalElems.forEach(function(el) {
                            el.textContent = response.grand_total;
                        });

                        document.querySelectorAll('.badge').forEach(function(el) {
                            el.textContent = response.total_items;
                        });

                        var tbody = document.querySelector('#modalKeranjang tbody');
                        if (tbody && tbody.children.length === 0) {
                            tbody.innerHTML = '<tr><td colspan="5" class="text-center text-muted py-4">Keranjang belanja masih kosong.</td></tr>';
                        }
                    }
                } catch (err) {
                    console.error("Gagal parsing JSON:", err, xhr.responseText);
                }
            }
        };

        xhr.send();
    }
})();
</script>
</body>
</html>