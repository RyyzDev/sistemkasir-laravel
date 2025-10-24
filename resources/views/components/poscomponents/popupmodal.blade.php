   <!-- Modal Overlay -->
      <template x-if="modal !== ''">
        <div class="fixed inset-0 bg-black bg-opacity-50 modal-overlay flex items-center justify-center z-50 p-4">
          <div class="modal-content bg-white max-w-2xl w-full p-8">
            <div class="flex justify-between items-center mb-6">
              <h3 class="text-2xl font-bold gradient-text" x-text="modal === 'cariProduk' ? '🔍 Cari Produk' : '💳 Pembayaran'"></h3>
              <button @click="modal = ''" class="text-2xl text-gray-400 hover:text-gray-600">✕</button>
            </div>

            <!-- Modal Cari Produk -->
            <div x-show="modal === 'cariProduk'" class="space-y-4">
              <input type="text" x-model="searchQuery" placeholder="Cari produk..." class="input-field w-full px-4 py-3 text-lg">
              
              <div class="table-container max-h-80 overflow-y-auto">
                <table class="w-full text-sm">
                  <thead>
                    <tr>
                      <th class="py-3 px-4 text-left font-semibold">SKU</th>
                      <th class="py-3 px-4 text-left font-semibold">Produk</th>
                      <th class="py-3 px-4 text-right font-semibold">Harga</th>
                      <th class="py-3 px-4 text-center font-semibold">Stok</th>
                      <th class="py-3 px-4 text-center font-semibold">Aksi</th>
                    </tr>
                  </thead>
                  <tbody>
                    <template x-for="product in searchResults" :key="product.id">
                      <tr>
                        <td class="py-3 px-4 text-center" x-text="product.kode_produk"></td>
                        <td class="py-3 px-4 font-semibold text-gray-800" x-text="product.nama_produk"></td>
                        <td class="py-3 px-4 text-right font-semibold text-purple-600" x-text="formatRupiah(product.price)"></td>
                        <td class="py-3 px-4 text-center" x-text="product.qty"></td>
                        <td class="py-3 px-4 text-center">
                          <button @click="addToCart(product)" class="action-btn bg-blue-500 text-white px-4 py-2 rounded-lg hover:bg-blue-600">
                            Tambah
                          </button>
                        </td>
                      </tr>
                    </template>
                    <tr x-show="searchResults.length === 0">
                      <td colspan="4" class="py-8 text-center text-gray-400">
                        <div class="text-3xl mb-2">🔍</div>
                        <p>Produk tidak ditemukan</p>
                      </td>
                    </tr>
                  </tbody>
                </table>
              </div>

              <div class="flex justify-between items-center pt-4 border-t">
                <p class="text-sm text-gray-600" x-text="searchResults.length + ' produk ditemukan'"></p>
                <button @click="modal = ''" class="px-4 py-2 bg-gray-200 text-gray-800 rounded-lg hover:bg-gray-300">Tutup</button>
              </div>
            </div>

            <!-- Modal Pembayaran -->
            <div x-show="modal === 'pembayaran'" class="space-y-6">
              <div class="bg-gradient-to-r from-purple-50 to-pink-50 p-6 rounded-lg border border-purple-200">
                <h4 class="font-bold text-gray-800 mb-4">Ringkasan Transaksi</h4>
                <div class="space-y-3 text-sm">
                  <div class="flex justify-between">
                    <span class="text-gray-600">Total Item:</span>
                    <span class="font-semibold" x-text="cartItems.reduce((sum, item) => sum + item.quantity, 0) + ' pcs'"></span>
                  </div>
                  <div class="flex justify-between pt-3 border-t border-purple-200">
                    <span class="text-gray-800 font-bold">Total Pembayaran:</span>
                    <span class="text-xl font-bold gradient-text" x-text="formatRupiah(getTotal())"></span>
                  </div>
                </div>
              </div>

              <div class="space-y-4">
                <div>
                  <label class="block text-sm font-semibold text-gray-800 mb-2">Metode Pembayaran</label>
                  <select class="input-field w-full px-4 py-3" name="payment_method">
                    <option>💵 Cash</option>
                    <option>📱 QRIS</option>
                    <option>🏧 Debit Card</option>
                    <option>💳 Credit Card</option>
                  </select>
                </div>

                <div>
                  <label class="block text-sm font-semibold text-gray-800 mb-2">Jumlah Bayar</label>
                  <input type="number" x-model.number="totalBayar" :placeholder="'Min: ' + formatRupiah(getTotal())" class="input-field w-full px-4 py-3 text-lg font-semibold">
                </div>

                <div class="bg-green-50 p-4 rounded-lg border border-green-200">
                  <p class="text-sm text-gray-600 mb-1">Kembalian:</p>
                  <p class="text-2xl font-bold gradient-text" x-text="formatRupiah(Math.max(0, totalBayar - getTotal()))"></p>
                </div>
              </div>

              <div class="flex gap-3 pt-4 border-t">
                <button @click="modal = ''" class="flex-1 px-4 py-3 bg-gray-200 text-gray-800 font-semibold rounded-lg hover:bg-gray-300 transition">
                  Batal
                </button>
                <button @click="prosesPembayaran()" class="flex-1 action-btn px-4 py-3 bg-gradient-to-r from-green-500 to-green-600 text-white font-semibold rounded-lg shadow-lg hover:shadow-xl">
                  ✅ Proses Pembayaran
                </button>
              </div>
            </div>
          </div>
        </div>
      </template>

      <!-- Success Popup -->
      <template x-if="showSuccess">
    <div class="fixed inset-0 bg-black bg-opacity-70 modal-overlay flex items-center justify-center z-50 p-4">
        
        <div class="modal-content bg-white max-w-xs w-full p-4 rounded-lg shadow-2xl relative font-mono text-xs" id="printArea">
            
            <h2 class="text-center font-bold text-base mb-1">Ryyz MART</h2>
            
            <div class="text-center border-b border-dashed border-gray-400 pb-2 mb-2">
                <p class="text-[10px]">UIN Syarif Hidayatullah Jakarta</p>
                <p class="text-[10px]">Telp: 0812-4567-8910</p>
            </div>
            
            <div class="border-b border-dashed border-gray-400 pb-2 mb-2">
                <div class="flex justify-between">
                    <span>No. Trans:</span>
                    <span class="font-semibold">TRX-XXXX</span> </div>
                <div class="flex justify-between">
                    <span>Tanggal:</span>
                    <span x-text="new Date().toLocaleDateString('id-ID') + ' ' + new Date().toLocaleTimeString('id-ID', {hour: '2-digit', minute:'2-digit'})"></span>
                </div>
                <div class="flex justify-between">
                    <span>Kasir:</span>
                    <span class="font-semibold">{{ Auth::user()->name ?? 'Kasir Tamu' }}</span>
                </div>
            </div>

            <div class="space-y-1 border-b border-dashed border-gray-400 pb-2 mb-2">
                <div class="flex justify-between font-bold">
                    <span>ITEM</span>
                    <span>SUBTOTAL</span>
                </div>
                <div class="border-t border-dashed border-gray-300 my-1"></div>
                <template x-for="item in cartItems" :key="item.id">
                    <div class="text-[11px] leading-tight">
                        <div class="font-medium" x-text="item.nama"></div>
                        <div class="flex justify-between pl-2">
                            <span x-text="item.quantity + ' x ' + formatRupiah(item.price)"></span>
                            <span x-text="formatRupiah(item.subtotal)"></span>
                        </div>
                    </div>
                </template>
            </div>

            <div class="space-y-1 border-b border-dashed border-gray-400 pb-2 mb-3">
                <div class="flex justify-between">
                    <span>TOTAL BELANJA:</span>
                    <span class="font-bold" x-text="formatRupiah(getTotal())"></span>
                </div>
                <div class="flex justify-between">
                    <span>UANG DITERIMA:</span>
                    <span class="font-bold" x-text="formatRupiah(totalBayar)"></span>
                </div>
                <div class="flex justify-between font-bold text-sm border-t border-dashed pt-1 mt-1">
                    <span>KEMBALIAN:</span>
                    <span class="text-green-700" x-text="formatRupiah(kembalian)"></span>
                </div>
            </div>

            <div class="text-center">
                <p class="text-[10px]">TERIMA KASIH ATAS KUNJUNGAN ANDA</p>
                <p class="text-[10px] mt-1">Barang yang sudah dibeli tidak dapat ditukar/dikembalikan.</p>
            </div>

            <div class="mt-4 flex gap-2 print:hidden">
                <button 
                    @click="printStruk()" 
                    class="flex-1 action-btn px-4 py-2 bg-blue-500 text-white font-semibold rounded-lg hover:bg-blue-600 transition-colors text-sm">
                    🖨️ Cetak
                </button>
                <button 
                    @click="showSuccess = false; successClearTransaction()" 
                    class="flex-1 action-btn px-4 py-2 bg-green-500 text-white font-semibold rounded-lg hover:bg-green-600 transition-colors text-sm">
                    Selesai
                </button>
            </div>
        </div>
    </div>
</template>