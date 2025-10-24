 <!-- Main Content -->
      <div class="flex-1 overflow-y-auto px-8 py-6">
        
        <!-- Tab Produk -->
        <div x-show="tab === 'produk'" class="space-y-6">
          <!-- Cart Table -->
          <div class="card p-6">
            <div class="flex justify-between items-center mb-6">
              <h3 class="text-lg font-bold text-gray-800">Daftar Produk</h3>
              <span class="badge bg-purple-100 text-purple-700" x-text="cartItems.length + ' item(s)'"></span>
            </div>

            <div class="table-container">
              <table class="w-full text-sm">
                <thead>
                  <tr>
                    <th class="py-4 px-6 text-left font-semibold">Produk</th>
                    <th class="py-4 px-6 text-right font-semibold">Harga</th>
                    <th class="py-4 px-6 text-center font-semibold">Qty</th>
                    <th class="py-4 px-6 text-right font-semibold">Subtotal</th>
                    <th class="py-4 px-6 text-center font-semibold">Aksi</th>
                  </tr>
                </thead>
                <tbody>
                  <tr x-show="cartItems.length === 0">
                    <td colspan="5" class="py-12 text-center">
                      <div class="flex flex-col items-center text-gray-400">
                        <div class="text-5xl mb-3">🛒</div>
                        <p class="font-semibold">Belum ada produk</p>
                        <p class="text-sm">Klik "Cari Produk" untuk mulai</p>
                      </div>
                    </td>
                  </tr>

                  <template x-for="item in cartItems" :key="item.id">
                    <tr>
                      <td class="py-4 px-6">
                        <div>
                          <p class="font-semibold text-gray-800" x-text="item.nama"></p>
                          <p class="text-xs text-gray-500" x-text="'SKU: ' + item.kode"></p>
                        </div>
                      </td>
                      <td class="py-4 px-6 text-right font-semibold" x-text="formatRupiah(item.price)"></td>
                      <td class="py-4 px-6">
                        <div class="flex items-center justify-center gap-2">
                          <button @click="updateQuantity(item.id, item.quantity - 1)" class="qty-btn bg-red-100 text-red-600 hover:bg-red-200">−</button>
                          <input type="number" :value="item.quantity" @input="updateQuantity(item.id, $event.target.value)"
                            class="quantity-input" min="1" :max="item.maxStock">
                          <button @click="updateQuantity(item.id, item.quantity + 1)" class="qty-btn bg-green-100 text-green-600 hover:bg-green-200">+</button>
                        </div>
                        <p class="item-center text-xs text-gray-500 mt-2 text-center" x-text="'Stok: ' + item.maxStock"></p>
                      </td>
                      <td class="py-4 px-6 text-right font-bold text-purple-600" x-text="formatRupiah(item.subtotal)"></td>
                      <td class="py-4 px-6 text-center">
                        <button @click="removeFromCart(item.id)" class="text-red-500 hover:text-red-700 hover:bg-red-50 p-2 rounded-lg transition">
                          🗑️
                        </button>
                      </td>
                    </tr>
                  </template>

                  <tr x-show="cartItems.length > 0" class="border-t-2 border-purple-200 bg-gradient-to-r from-purple-50 to-pink-50">
                    <td colspan="3" class="py-4 px-6 text-right font-bold text-gray-800">TOTAL:</td>
                    <td class="py-4 px-6 text-right font-bold text-xl gradient-text" x-text="formatRupiah(getTotal())"></td>
                    <td></td>
                  </tr>
                </tbody>
              </table>
            </div>
          </div>

          <!-- Action Buttons -->
          <div class="flex gap-4 flex-wrap">
            <button @click="modal = 'cariProduk'" class="action-btn px-6 py-3 bg-gradient-to-r from-blue-500 to-blue-600 text-white font-semibold rounded-lg shadow-lg hover:shadow-xl">
              🔍 Cari Produk
            </button>
            <button @click="clearTransaction()" :disabled="cartItems.length === 0"
              class="action-btn px-6 py-3 bg-red-500 text-white font-semibold rounded-lg shadow-lg hover:shadow-xl disabled:opacity-50 disabled:cursor-not-allowed">
              ❌ Batalkan
            </button>
            <button @click="modal = 'pembayaran'" :disabled="cartItems.length === 0"
              class="action-btn px-6 py-3 bg-gradient-to-r from-green-500 to-green-600 text-white font-semibold rounded-lg shadow-lg hover:shadow-xl disabled:opacity-50 disabled:cursor-not-allowed">
              💳 Pembayaran
            </button>
          </div>
        </div>

        <!-- Tab Supplier -->
        <div x-show="tab === 'supplier'" class="space-y-6">
          <div>
            <h2 class="text-3xl font-bold gradient-text mb-2">Kelola Supplier</h2>
            <p class="text-gray-500">Tambah dan kelola data supplier serta produk</p>
          </div>

          <form action="/suppliers" method="POST">
            @csrf
          <div class="card p-6 space-y-6">
            <h3 class="text-xl font-bold text-gray-800">Tambah Supplier Baru</h3>
            <div class="grid grid-cols-2 gap-4">
              <input type="text" name="nama_supplier" placeholder="Nama Supplier" class="input-field px-4 py-3" required>
              <input type="text" name="kode_supplier" placeholder="Kode Supplier" class="input-field px-4 py-3" required>
              <input type="text" placeholder="Kontak/Telepon" class="input-field px-4 py-3" name="kontak">
              <input type="email" name="email" placeholder="Email" class="input-field px-4 py-3">
            </div>
            <textarea placeholder="Alamat" name="alamat" rows="2" class="input-field px-4 py-3 w-full"></textarea>
            <button class="action-btn w-full bg-gradient-to-r from-indigo-600 to-purple-600 text-white font-semibold py-3 rounded-lg shadow-lg hover:shadow-xl" type="submit">
              ✅ Simpan Supplier
            </button>
          </div>
        </form>

          <div class="card overflow-hidden">
            <div class="p-6 border-b border-gray-200">
              <h3 class="text-xl font-bold text-gray-800">Daftar Supplier</h3>
            </div>
            <div class="table-container">
              <table class="w-full text-sm">
                <thead>
                  <tr>
                    <th class="py-4 px-6 text-left font-semibold">Kode</th>
                    <th class="py-4 px-6 text-left font-semibold">Nama</th>
                    <th class="py-4 px-6 text-left font-semibold">Kontak</th>
                    <th class="py-4 px-6 text-center font-semibold">Status</th>
                    <th class="py-4 px-6 text-center font-semibold">Aksi</th>
                  </tr>
                </thead>
                <tbody>
                  <template x-for="product in products" :key="product.id">
                    <tr>
                      <td class="py-4 px-6 font-mono text-gray-600" x-text="product.kode_supplier"></td>
                      <td class="py-4 px-6 font-semibold text-gray-800" x-text="product.nama_supplier"></td>
                      <td class="py-4 px-6 text-gray-600" x-text="product.kontak"></td>
                      <td class="py-4 px-6 text-center">
                        <span class="status-badge status-active">✓ Aktif</span>
                      </td>
                      <td class="py-4 px-6 text-center">
                        <button class="text-red-500 hover:text-red-700 hover:bg-red-50 px-3 py-2 rounded-lg transition">
                          🗑️ Hapus
                        </button>
                      </td>
                    </tr>
                  </template>
                </tbody>
              </table>
            </div>
          </div>
        </div>

        <!-- Tab Stock -->
        <div x-show="tab === 'stock'" class="space-y-6">
          <div>
            <h2 class="text-3xl font-bold gradient-text mb-2">Stock Opname</h2>
            <p class="text-gray-500">Verifikasi dan catat stok fisik produk</p>
          </div>

          <div class="card overflow-hidden">
            <div class="table-container">
              <table class="w-full text-sm">
                <thead>
                  <tr>
                    <th class="py-4 px-6 text-left font-semibold">Produk</th>
                    <th class="py-4 px-6 text-center font-semibold">Qty Sistem</th>
                    <th class="py-4 px-6 text-center font-semibold">Qty Fisik</th>
                    <th class="py-4 px-6 text-center font-semibold">Selisih</th>
                  </tr>
                </thead>
                <tbody>
                  <template x-for="product in products" :key="product.id">
                    <tr>
                      <td class="py-4 px-6 font-semibold text-gray-800" x-text="product.nama"></td>
                      <td class="py-4 px-6 text-center text-gray-600" x-text="product.qty"></td>
                      <td class="py-4 px-6 text-center">
                        <input type="number" :value="product.qty" class="input-field w-20 px-3 py-2 text-center">
                      </td>
                      <td class="py-4 px-6 text-center font-semibold text-purple-600">0</td>
                    </tr>
                  </template>
                </tbody>
              </table>
            </div>
            <div class="p-6 border-t border-gray-200">
              <button class="action-btn w-full bg-gradient-to-r from-green-500 to-green-600 text-white font-semibold py-3 rounded-lg shadow-lg hover:shadow-xl">
                ✅ Simpan Stock Opname
              </button>
            </div>
          </div>
        </div>
      </div>