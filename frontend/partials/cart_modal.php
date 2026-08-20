<!-- Modal Keranjang -->
<div class="modal fade" id="modalKeranjang" tabindex="-1" aria-labelledby="modalKeranjangLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-centered">
    <div class="modal-content">
      
      <!-- Header Modal -->
      <div class="modal-header bg-danger text-white">
        <h5 class="modal-title fw-bold" id="modalKeranjangLabel">
          <i class="fa-solid fa-cart-shopping me-2"></i>Keranjang Belanja
        </h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>

      <!-- Body Modal -->
      <div class="modal-body">
        <div class="table-responsive">
          <table class="table align-middle">
            <thead>
              <tr>
                <th>Menu</th>
                <th>Harga</th>
                <th class="text-center">Jumlah</th>
                <th>Subtotal</th>
                <th class="text-center">Aksi</th>
              </tr>
            </thead>
            <tbody>
              <?php 
              $grand_total = 0;
              if (isset($_SESSION['cart']) && !empty($_SESSION['cart'])) :
                foreach ($_SESSION['cart'] as $id => $item) :
                  // Pembersihan variabel harga
                  $raw_harga = isset($item['harga']) ? $item['harga'] : 0;
                  $harga = (int) preg_replace('/[^0-9]/', '', $raw_harga);
                  $qty = isset($item['qty']) ? (int)$item['qty'] : 1;
                  $subtotal = $harga * $qty;
                  $grand_total += $subtotal;
                  $nama_item = isset($item['nama']) ? htmlspecialchars($item['nama']) : 'Menu';
              ?>
                <tr>
                  <td><strong><?= $nama_item; ?></strong></td>
                  <td>Rp <?= number_format($harga, 0, ',', '.'); ?></td>
                  <td class="text-center">
                    <div class="btn-group btn-group-sm" role="group">
                      <!-- Tombol Kurang (-) -->
                      <button type="button" 
                              class="btn btn-outline-secondary btn-update-qty" 
                              data-id="<?= $id; ?>" 
                              data-nama="<?= $nama_item; ?>" 
                              data-action="decrease">-</button>
                      
                      <!-- Angka Jumlah -->
                      <span class="btn btn-light disabled fw-bold qty-val" style="min-width: 40px; color: #000;">
                        <?= $qty; ?>
                      </span>
                      
                      <!-- Tombol Tambah (+) -->
                      <button type="button" 
                              class="btn btn-outline-secondary btn-update-qty" 
                              data-id="<?= $id; ?>" 
                              data-nama="<?= $nama_item; ?>" 
                              data-action="increase">+</button>
                    </div>
                  </td>
                  <td class="subtotal-val">Rp <?= number_format($subtotal, 0, ',', '.'); ?></td>
                  <td class="text-center">
                    <!-- Tombol Hapus Item -->
                    <button type="button" 
                            class="btn btn-sm btn-outline-danger btn-delete-cart" 
                            data-id="<?= $id; ?>" 
                            data-nama="<?= $nama_item; ?>"
                            title="Hapus Menu">
                      <i class="fa-solid fa-trash"></i>
                    </button>
                  </td>
                </tr>
              <?php 
                endforeach;
              else : 
              ?>
                <tr>
                  <td colspan="5" class="text-center text-muted py-4">Keranjang belanja masih kosong.</td>
                </tr>
              <?php endif; ?>
            </tbody>
          </table>
        </div>

        <!-- Total Pembayaran -->
        <div class="d-flex justify-content-between align-items-center mt-3 pt-3 border-top">
          <span class="fs-5 fw-bold">Total Pembayaran:</span>
          <h4 class="text-danger fw-bold mb-0 grand-total-val">Rp <?= number_format($grand_total, 0, ',', '.'); ?></h4>
        </div>
      </div>

      <!-- Footer Modal -->
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Lanjut Belanja</button>
        <?php if (isset($_SESSION['cart']) && !empty($_SESSION['cart'])) : ?>
            <a href="partials/checkout.php" class="btn btn-danger fw-bold">Checkout</a>
        <?php else : ?>
            <button type="button" class="btn btn-danger fw-bold" disabled>Checkout</button>
        <?php endif; ?>
      </div>

    </div>
  </div>
</div>