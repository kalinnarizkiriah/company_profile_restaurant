<!-- Bootstrap core JavaScript -->
<script src="vendor/jquery/jquery.min.js"></script>
<script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

<!-- Core plugin JavaScript -->
<script src="vendor/jquery-easing/jquery.easing.min.js"></script>

<!-- Custom scripts for all pages -->
<script src="js/sb-admin-2.min.js"></script>

<script>
// Fungsi Cek Pesan Baru secara Real-time
function checkNewMessages() {
    fetch('check_unread_messages.php')
        .then(response => response.text())
        .then(count => {
            let messageCount = parseInt(count.trim()) || 0;
            let badge = document.querySelector('#pesan-badge');
            let pesanMenu = document.querySelector('#pesan-menu');

            if (messageCount > 0) {
                if (badge) {
                    badge.innerText = messageCount;
                    badge.style.display = 'inline-block';
                } else if (pesanMenu) {
                    let newBadge = document.createElement('span');
                    newBadge.id = 'pesan-badge';
                    newBadge.className = 'badge bg-danger rounded-pill px-2 py-1';
                    newBadge.style.fontSize = '11px';
                    newBadge.innerText = messageCount;
                    pesanMenu.appendChild(newBadge);
                }
            } else if (badge) {
                badge.style.display = 'none';
            }
        })
        .catch(error => console.error('Error fetching messages:', error));
}

// Fungsi Cek Reviews Baru secara Real-time
function checkNewReviews() {
    fetch('check_unread_reviews.php')
        .then(response => response.text())
        .then(count => {
            let reviewCount = parseInt(count.trim()) || 0;
            let badge = document.querySelector('#review-badge');
            let reviewMenu = document.querySelector('#review-menu');

            if (reviewCount > 0) {
                if (badge) {
                    badge.innerText = reviewCount;
                    badge.style.display = 'inline-block';
                } else if (reviewMenu) {
                    let newBadge = document.createElement('span');
                    newBadge.id = 'review-badge';
                    newBadge.className = 'badge bg-danger rounded-pill px-2 py-1';
                    newBadge.style.fontSize = '11px';
                    newBadge.innerText = reviewCount;
                    reviewMenu.appendChild(newBadge);
                }
            } else if (badge) {
                badge.style.display = 'none';
            }
        })
        .catch(error => console.error('Error fetching reviews:', error));
}

// Fungsi Cek Reservasi Baru secara Real-time
function checkNewReservations() {
    fetch('check_unread_reservations.php')
        .then(response => response.text())
        .then(count => {
            let reservationCount = parseInt(count.trim()) || 0;
            let badge = document.querySelector('#reservasi-badge');
            let reservasiMenu = document.querySelector('#reservasi-menu');

            if (reservationCount > 0) {
                if (badge) {
                    badge.innerText = reservationCount;
                    badge.style.display = 'inline-block';
                } else if (reservasiMenu) {
                    let newBadge = document.createElement('span');
                    newBadge.id = 'reservasi-badge';
                    newBadge.className = 'badge bg-danger rounded-pill px-2 py-1';
                    newBadge.style.fontSize = '11px';
                    newBadge.innerText = reservationCount;
                    reservasiMenu.appendChild(newBadge);
                }
            } else if (badge) {
                badge.style.display = 'none';
            }
        })
        .catch(error => console.error('Error fetching reservations:', error));
}

// Jalankan pengecekan langsung saat halaman pertama kali dibuka
checkNewMessages();
checkNewReviews();
checkNewReservations();

// Jalankan pengecekan otomatis setiap 3 detik
setInterval(function() {
    checkNewMessages();
    checkNewReviews();
    checkNewReservations();
}, 3000);
</script>

<!-- Skrip Cek Pesanan Otomatis -->
<script>
function cekPesananBaru() {
    fetch('check_new_pesanan.php')
        .then(response => response.json())
        .then(data => {
            if (data.status === 'success') {
                let badge = document.getElementById('pesanan-badge');
                if (badge) {
                    if (data.total > 0) {
                        badge.innerText = data.total;
                        badge.style.display = 'inline-block';
                    } else {
                        badge.style.display = 'none';
                    }
                }
            }
        })
        .catch(error => console.error('Gagal mengecek pesanan:', error));
}

// Cek otomatis setiap 3 detik
setInterval(cekPesananBaru, 3000);
</script>