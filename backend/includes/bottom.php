<!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>

    <!-- Bootstrap core JavaScript-->
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Core plugin JavaScript-->
    <script src="vendor/jquery-easing/jquery.easing.min.js"></script>

    <!-- Custom scripts for all pages-->
    <script src="js/sb-admin-2.min.js"></script>

    <script>
document.addEventListener("DOMContentLoaded", function () {
    function checkUnreadMessages() {
        fetch('check_unread_messages.php')
            .then(response => response.json())
            .then(data => {
                if (data.status === 'success') {
                    const badge = document.getElementById('badge-pesan-unread');
                    if (badge) {
                        if (data.unread > 0) {
                            badge.textContent = data.unread;
                            badge.style.display = 'inline-block';
                        } else {
                            badge.style.display = 'none'; // Sembunyikan jika tidak ada pesan
                        }
                    }
                }
            })
            .catch(error => console.error('Error fetching messages:', error));
    }

    // Jalankan pertama kali saat halaman dimuat
    checkUnreadMessages();

    // Cek pesan baru secara otomatis setiap 3 detik tanpa refresh halaman
    setInterval(checkUnreadMessages, 3000);
});

</script>
</body>
</html>