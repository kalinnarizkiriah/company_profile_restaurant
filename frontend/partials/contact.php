<section id="contact-section" class="py-5" style="background-color: #FAF7F2; padding-top: 80px; padding-bottom: 140px; margin-bottom: 0;">
<div class="container">
      <div class="text-center mb-5" data-aos="fade-up">
         <h2 class="stitle"><span>Hubungi</span> Kami</h2>
         <div class="sline"></div>
         <p class="sdesc mx-auto" style="max-width:480px;">Punya pertanyaan, masukan, atau ingin merencanakan acara khusus? Kami akan senang mendengar dari Anda.</p>
      </div>

      <div class="row g-4">
         <div class="col-lg-4" data-aos="fade-right">
            <div class="ctdark">
               <h4>Hubungi Kami</h4>
               <p class="ctsub">Kami biasanya membalas dalam waktu 2 jam pada jam kerja.</p>

               <div class="ctitem">
                  <div class="cticon"><i class="fas fa-map-marker-alt"></i></div>
                  <div class="ctinfo"><strong>ALAMAT</strong><span>72 Perum. Gamping-Sleman,YK</span></div>
               </div>

               <div class="ctitem">
                  <div class="cticon"><i class="fas fa-phone-alt"></i></div>
                  <div class="ctinfo"><strong>TELEPON</strong><span>+62 858-7147-2153</span></div>
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

         <div class="col-lg-8" data-aos="fade-left">
            <div class="fcard">
               
               <form action="../backend/action_insert_contacts.php" method="POST">
                  <div class="row g-3">
                     <div class="col-sm-6">
                        <label class="flbl">Nama Lengkap *</label>
                        <input type="text" name="name" class="fctrl" required />
                     </div>

                     <div class="col-sm-6">
                        <label class="flbl">Email *</label>
                        <input type="email" name="email" class="fctrl" required />
                     </div>

                     <div class="col-sm-6">
                        <label class="flbl">Telepon</label>
                        <input type="tel" name="phone" class="fctrl" />
                     </div>

                     <div class="col-sm-6">
                        <label class="flbl">Topik *</label>
                        <select name="subject" class="fctrl" required>
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
                        <textarea name="message" class="fctrl" rows="5" required></textarea>
                     </div>

                     <div class="col-12">
                        <button type="submit" class="btn-red" id="ctcBtn">
                           <i class="fas fa-paper-plane me-2"></i>Kirim Pesan
                        </button>
                     </div>
                  </div>
               </form>

            </div>
         </div>
      </div>
   </div>
</section>