<!-- RESERVATION SECTION -->
<section id="reservation">
    <div class="container">
        <div class="text-center mb-5" data-aos="fade-up">
            <h2 class="stitle">Buat <span>Reservasi</span></h2>
            <div class="sline"></div>
            <p class="mt-3 text-muted">
                Reservasi meja Anda untuk pengalaman bersantap yang berkesan. 
                Kami menyarankan untuk memesan 24 jam sebelumnya.
            </p>
        </div>

        <div class="row g-4 align-items-center">
            <!-- Informational Left Box -->
             <div class="row g-4 align-items-start">
               <div class="col-lg-4" data-aos="fade-right">
                  <div style="background:var(--dark);border-radius:18px;padding:36px;">
                     <h4 style="color:#fff;font-size:1.3rem;margin-bottom:8px;">Informasi Kontak</h4>
                     <p style="color:rgba(255,255,255,.55);font-size:.85rem;margin-bottom:26px;">Kami senang membantu Anda merencanakan pengalaman bersantap yang sempurna.</p>
                     <div class="d-flex flex-column gap-3">
                        <div class="d-flex align-items-center gap-3">
                           <div style="width:46px;height:46px;border-radius:11px;background:rgba(232,40,26,.2);display:flex;align-items:center;justify-content:center;color:var(--primary);font-size:1.1rem;flex-shrink:0;"><i class="fas fa-clock"></i></div>
                           <div><strong style="display:block;color:#ccc;font-size:.78rem;text-transform:uppercase;letter-spacing:.8px;">Jam Buka</strong><span style="color:#fff;font-size:.87rem;">Rabu – Minggu, 09.00 - 23.00 WIB</span></div>
                        </div>
                        <div class="d-flex align-items-center gap-3">
                           <div style="width:46px;height:46px;border-radius:11px;background:rgba(232,40,26,.2);display:flex;align-items:center;justify-content:center;color:var(--primary);font-size:1.1rem;flex-shrink:0;"><i class="fas fa-phone-alt"></i></div>
                           <div><strong style="display:block;color:#ccc;font-size:.78rem;text-transform:uppercase;letter-spacing:.8px;">Telepon untuk Reservasi</strong><span style="color:#fff;font-size:.87rem;">+62 858-7147-2153</span></div>
                        </div>
                        <div class="d-flex align-items-center gap-3">
                           <div style="width:46px;height:46px;border-radius:11px;background:rgba(232,40,26,.2);display:flex;align-items:center;justify-content:center;color:var(--primary);font-size:1.1rem;flex-shrink:0;"><i class="fas fa-users"></i></div>
                           <div><strong style="display:block;color:#ccc;font-size:.78rem;text-transform:uppercase;letter-spacing:.8px;">Makan Rombongan</strong><span style="color:#fff;font-size:.87rem;">Menu khusus untuk 10+ tamu</span></div>
                        </div>
                        <div class="d-flex align-items-center gap-3">
                           <div style="width:46px;height:46px;border-radius:11px;background:rgba(232,40,26,.2);display:flex;align-items:center;justify-content:center;color:var(--primary);font-size:1.1rem;flex-shrink:0;"><i class="fas fa-map-marker-alt"></i></div>
                           <div><strong style="display:block;color:#ccc;font-size:.78rem;text-transform:uppercase;letter-spacing:.8px;">Lokasi</strong><span style="color:#fff;font-size:.87rem;">72 Perum. Gamping-Sleman,YK</span></div>
                        </div>
                     </div>
                  </div>
               </div>

            <!-- Form input data pengunjung ke backend/database -->
            <div class="col-lg-8" data-aos="fade-left">
                <div class="p-4 bg-white rounded-4 shadow-sm border">
                    <form action="../backend/action_insert_reservations.php" method="POST">
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label fw-bold">Nama Lengkap *</label>
                                <input type="text" name="full_name" class="form-control" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-bold">Telepon *</label>
                                <input type="text" name="phone" class="form-control" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-bold">Email *</label>
                                <input type="email" name="email" class="form-control" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-bold">Jumlah Tamu *</label>
                                <select name="guests" class="form-select" required>
                                    <option value="" selected disabled>Pilih Jumlah Tamu</option>
                                    <option value="1 orang">1 orang</option>
                                    <option value="2 orang">2 orang</option>
                                    <option value="3 orang">3 orang</option>
                                    <option value="4 orang">4 orang</option>
                                    <option value="5+ orang">5+ orang</option>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-bold">Tanggal *</label>
                                <input type="date" name="date" class="form-control" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-bold">Waktu *</label>
                                <input type="time" name="time" class="form-control" required>
                            </div>
                            <div class="col-12 text-center mt-4">
                            <div class="col-12"><button class="btn-red w-100 justify-content-center" id="resBtn"><i class="fas fa-calendar-check"></i>Konfirmasi Pemesanan</button></div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>