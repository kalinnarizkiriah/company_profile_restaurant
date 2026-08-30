<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Ambil data user dari session login yang valid di sistem Anda
$customer_data = $_SESSION['login_customer'] ?? null;

$nama_user  = '';

if (is_array($customer_data)) {
    $nama_user  = $customer_data['nama_lengkap'] ?? ($customer_data['username'] ?? '');
} elseif (isset($_SESSION['customer_nama_lengkap'])) {
    $nama_user = $_SESSION['customer_nama_lengkap'];
}

// Variabel untuk mendeteksi status login di JavaScript (true / false)
$is_logged_in = isset($_SESSION['login_customer']) ? 'true' : 'false';
?>

<!-- RESERVATION SECTION -->
<section id="reservation" class="py-5" style="background-color: #FAF7F2; padding-top: 80px; padding-bottom: 140px; margin-bottom: 0;">
    <div class="container">
        <div class="text-center mb-5" data-aos="fade-up">
            <h2 class="stitle">Buat <span>Reservasi</span></h2>
            <div class="sline"></div>
            <p class="sdesc mx-auto" style="max-width:480px;">
                Reservasi meja Anda untuk pengalaman bersantap yang berkesan. 
                Kami menyarankan untuk memesan 24 jam sebelumnya.
            </p>
        </div>

        <div class="row g-4 align-items-stretch">
            <!-- Informational Left Box -->
            <div class="col-lg-4" data-aos="fade-right">
                <div class="ctdark h-100 d-flex flex-column justify-content-between">
                    <div>
                        <h4>Informasi Kontak</h4>
                        <p class="ctsub">Kami senang membantu Anda merencanakan pengalaman bersantap yang sempurna.</p>

                        <div class="ctitem">
                            <div class="cticon"><i class="fas fa-clock"></i></div>
                            <div class="ctinfo"><strong>JAM BUKA</strong><span>Rabu – Minggu, 09.00 - 23.00 WIB</span></div>
                        </div>

                        <div class="ctitem">
                            <div class="cticon"><i class="fas fa-phone-alt"></i></div>
                            <div class="ctinfo"><strong>TELEPON / WHATSAPP</strong><span>+62 858-7147-2153</span></div>
                        </div>

                        <div class="ctitem">
                            <div class="cticon"><i class="fas fa-users"></i></div>
                            <div class="ctinfo"><strong>MAKAN ROMBONGAN</strong><span>Menu khusus untuk 10+ tamu</span></div>
                        </div>

                        <div class="ctitem">
                            <div class="cticon"><i class="fas fa-map-marker-alt"></i></div>
                            <div class="ctinfo"><strong>LOKASI</strong><span>Gamping-Sleman,YK</span></div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Form Area Kanan (Ruang lowong bawah dikurangi dengan menyesuaikan padding/flex) -->
            <div class="col-lg-8" data-aos="fade-left">
                <div class="fcard h-100 d-flex flex-column justify-content-center">
                    <form action="../backend/action_insert_reservations.php" method="POST" onsubmit="return cekLoginReservasi(event)">
                        
                        <div class="row g-3">
                            <!-- Nama Lengkap -->
                            <div class="col-sm-6">
                                <label class="flbl">Nama Lengkap *</label>
                                <input type="text" 
                                       name="full_name" 
                                       class="fctrl bg-light" 
                                       value="<?php echo htmlspecialchars($nama_user); ?>" 
                                       readonly 
                                       required />
                            </div>

                            <!-- Email -->
                            <div class="col-sm-6">
                                <label class="flbl">Email *</label>
                                <input type="email" name="email" class="fctrl" required />
                            </div>

                            <!-- Pilihan Nomor Meja & Area -->
                            <div class="col-12">
                                <label class="flbl">Pilih Nomor Meja & Area *</label>
                                <select name="no_meja" class="fctrl" required>
                                    <option value="" selected disabled>Pilih Meja Restoran</option>
                                    <optgroup label="--- Area Indoor ---">
                                        <option value="Meja Indoor 01 (Kapasitas 2 Orang)">Meja Indoor 01 — Kapasitas 2 Orang</option>
                                        <option value="Meja Indoor 02 (Kapasitas 2 Orang)">Meja Indoor 02 — Kapasitas 2 Orang</option>
                                        <option value="Meja Indoor 03 (Kapasitas 4 Orang)">Meja Indoor 03 — Kapasitas 4 Orang</option>
                                        <option value="Meja Indoor 04 (Kapasitas 4 Orang)">Meja Indoor 04 — Kapasitas 4 Orang</option>
                                        <option value="Meja Indoor 05 (Kapasitas 6 Orang)">Meja Indoor 05 — Kapasitas 6 Orang (Keluarga)</option>
                                        <option value="Meja VIP 01 (Indoor - Private Room / AC, Kapasitas 8-10 Orang)">Meja VIP 01 (Indoor - Private AC) — Kapasitas 8-10 Orang</option>
                                        <option value="Meja VIP 02 (Indoor - Private Room / AC, Kapasitas 10-12 Orang)">Meja VIP 02 (Indoor - Private AC) — Kapasitas 10-12 Orang</option>
                                    </optgroup>
                                    <optgroup label="--- Area Outdoor ---">
                                        <option value="Meja Outdoor 01 (Kapasitas 2 Orang)">Meja Outdoor 01 — Kapasitas 2 Orang</option>
                                        <option value="Meja Outdoor 02 (Kapasitas 2 Orang)">Meja Outdoor 02 — Kapasitas 2 Orang</option>
                                        <option value="Meja Outdoor 03 (Kapasitas 4 Orang)">Meja Outdoor 03 — Kapasitas 4 Orang</option>
                                        <option value="Meja Outdoor 04 (Kapasitas 4 Orang)">Meja Outdoor 04 — Kapasitas 4 Orang</option>
                                    </optgroup>
                                </select>
                            </div>

                            <!-- Tanggal -->
                            <div class="col-sm-6">
                                <label class="flbl">Tanggal *</label>
                                <input type="date" name="date" class="fctrl" required />
                            </div>

                            <!-- Waktu -->
                            <div class="col-sm-6">
                                <label class="flbl">Waktu *</label>
                                <input type="time" name="time" class="fctrl" required />
                            </div>

                            <!-- Tombol Konfirmasi -->
                            <div class="col-12 mt-4">
                                <button type="submit" class="btn-red w-100 justify-content-center py-2" id="resBtn">
                                    <i class="fas fa-calendar-check me-2"></i> Konfirmasi Pemesanan
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Script JavaScript Validasi Login, Simpan ke Database via Fetch, & Buka WhatsApp -->
<script>
function cekLoginReservasi(event) {
    event.preventDefault();

    var isUserLoggedIn = <?php echo $is_logged_in; ?>;

    if (!isUserLoggedIn) {
        alert('Silakan login terlebih dahulu untuk melakukan reservasi!');
        window.location.href = '/company_profile_restaurant/frontend/partials/login_customer.php';
        return false;
    }

    const form = event.target;
    const formData = new FormData(form);

    const fullName = form.querySelector('input[name="full_name"]').value;
    const email = form.querySelector('input[name="email"]').value;
    const noMeja = form.querySelector('select[name="no_meja"]').value;
    const date = form.querySelector('input[name="date"]').value;
    const time = form.querySelector('input[name="time"]').value;

    fetch(form.action, {
        method: 'POST',
        body: formData
    })
    .then(response => response.text())
    .then(result => {
        if (result.includes("sudah dipesan")) {
            alert(result);
            return;
        }

        const nomorAdmin = "6285871472153"; 

        const pesan = `Halo Admin Resto Jogja, saya ingin konfirmasi reservasi dan menanyakan perihal pembayaran DP:%0A` +
                    `-----------------------------------%0A` +
                    `- Nama Lengkap: *${fullName}*%0A` +
                    `- Email: ${email}%0A` +
                    `- Pilihan Meja: ${noMeja}%0A` +
                    `- Tanggal: ${date}%0A` +
                    `- Waktu: ${time}%0A` +
                    `-----------------------------------%0A` +
                    `Mohon info selanjutnya ya. Terima kasih!`;

        window.open(`https://wa.me/${nomorAdmin}?text=${pesan}`, '_blank');
        
        form.reset();
    })
    .catch(error => {
        console.error('Terjadi kesalahan:', error);
        alert('Gagal menyimpan ke database, tetapi WhatsApp akan tetap dibuka.');
        
        const nomorAdmin = "6285871472153";
        window.open(`https://wa.me/${nomorAdmin}`, '_blank');
    });

    return false;
}
</script>