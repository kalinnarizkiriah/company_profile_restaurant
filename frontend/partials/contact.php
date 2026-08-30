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

<section id="contact-section" class="py-5" style="background-color: #FAF7F2; padding-top: 80px; padding-bottom: 140px; margin-bottom: 0;">
   <div class="container">
      <div class="text-center mb-5" data-aos="fade-up">
         <h2 class="stitle"><span>Hubungi</span> Kami</h2>
         <div class="sline"></div>
         <p class="sdesc mx-auto" style="max-width:480px;">Punya pertanyaan, masukan, atau ingin merencanakan acara khusus? Kami akan senang mendengar dari Anda.</p>
      </div>

      <div class="row g-4 align-items-stretch">
         <div class="col-lg-4" data-aos="fade-right">
            <div class="ctdark h-100 d-flex flex-column justify-content-between">
               <div>
                  <h4>Hubungi Kami</h4>
                  <p class="ctsub">Kami biasanya membalas dalam waktu 2 jam pada jam kerja.</p>

                  <div class="ctitem">
                     <div class="cticon"><i class="fas fa-map-marker-alt"></i></div>
                     <div class="ctinfo"><strong>ALAMAT</strong><span>Gamping-Sleman,YK</span></div>
                  </div>

                  <div class="ctitem">
                     <div class="cticon"><i class="fas fa-phone-alt"></i></div>
                     <div class="ctinfo"><strong>TELEPON / WHATSAPP</strong><span>+62 858-7147-2153</span></div>
                  </div>

                  <div class="ctitem">
                     <div class="cticon"><i class="fas fa-envelope"></i></div>
                     <div class="ctinfo"><strong>EMAIL</strong><span>hello@restojogja.com</span></div>
                  </div>

                  <div class="ctitem">
                     <div class="cticon"><i class="fas fa-clock"></i></div>
                     <div class="ctinfo"><strong>JAM BUKA</strong><span>Rabu – Minggu, 09.00 – 23.00 WIB</span></div>
                  </div>
               </div>
            </div>
         </div>

         <div class="col-lg-8" data-aos="fade-left">
            <div class="fcard h-100 d-flex flex-column justify-content-center">
               
               <!-- Form Kontak tanpa input telepon -->
               <form id="contactForm" action="../backend/action_insert_contacts.php" method="POST" onsubmit="return handleContactSubmit(event)">
                  <div class="row g-3">
                     <div class="col-sm-6">
                        <label class="flbl">Nama Lengkap *</label>
                        <input type="text" name="name" id="contactName" class="fctrl bg-light" value="<?php echo htmlspecialchars($nama_user); ?>" readonly required />
                     </div>

                     <div class="col-sm-6">
                        <label class="flbl">Email *</label>
                        <input type="email" name="email" id="contactEmail" class="fctrl" required />
                     </div>

                     <!-- Kolom Topik -->
                     <div class="col-12">
                        <label class="flbl">Topik *</label>
                        <select name="subject" id="contactSubject" class="fctrl" required>
                           <option value="" disabled selected>Pilih Topik Pesan</option>
                           <option value="Katering">Katering</option>
                           <option value="Katering & Acara">Katering &amp; Acara</option>
                           <option value="Kerja Sama">Kerja Sama</option>
                           <option value="Pertanyaan Umum">Pertanyaan Umum</option>
                           <option value="Kritik & Masukan">Kritik &amp; Masukan</option>
                        </select>
                     </div>

                     <div class="col-12">
                        <label class="flbl">Pesan *</label>
                        <textarea name="message" id="contactMessage" class="fctrl" rows="5" required></textarea>
                     </div>

                     <div class="col-12">
                        <button type="submit" class="btn-red" id="ctcBtn">
                            <i class="fas fa-paper-plane me-2"></i>Kirim Pesan ke WhatsApp
                        </button>
                     </div>
                  </div>
               </form>

            </div>
         </div>
      </div>
   </div>
</section>

<!-- Script JavaScript untuk Validasi Login & Redirect WhatsApp -->
<script>
function handleContactSubmit(event) {
    var isUserLoggedIn = <?php echo $is_logged_in; ?>;
    
    if (!isUserLoggedIn) {
        event.preventDefault();
        alert('Silakan login terlebih dahulu untuk mengirim pesan!');
        window.location.href = '/company_profile_restaurant/frontend/partials/login_customer.php';
        return false; 
    }

    // Ambil data nilai form untuk pesan WhatsApp
    const name = document.getElementById('contactName').value;
    const email = document.getElementById('contactEmail').value;
    const subject = document.getElementById('contactSubject').value;
    const message = document.getElementById('contactMessage').value;

    // Format pesan WhatsApp dengan garis pemisah (sama persis seperti reservasi)
    let waMessage = `Halo Admin Resto Jogja, saya ingin mengirimkan pesan:\n` +
                    `----------------------------------------\n` +
                    `* Nama Lengkap: ${name}\n` +
                    `* Email: ${email}\n` +
                    `* Topik: ${subject}\n` +
                    `* Pesan: ${message}\n` +
                    `----------------------------------------\n` +
                    `Mohon info selanjutnya ya. Terima kasih!`;

    // Nomor WhatsApp Admin
    let adminPhone = '6285871472153';

    // Buka WhatsApp di tab/aplikasi baru
    let waUrl = `https://wa.me/${adminPhone}?text=` + encodeURIComponent(waMessage);
    window.open(waUrl, '_blank');

    // Biarkan form melakukan submit agar data tetap masuk ke backend database
    return true; 
}
</script>