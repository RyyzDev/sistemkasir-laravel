<!DOCTYPE html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Dashboard Sistem Kasir</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <script src="//unpkg.com/alpinejs" defer></script>
</head>
<body class="bg-gray-100 text-gray-800 font-sans min-h-screen">

  <!-- Navbar -->
  <header class="bg-gradient-to-r from-indigo-600 to-purple-600 text-white shadow-lg">
    <div class="max-w-7xl mx-auto flex justify-between items-center px-6 py-4">
      <h1 class="text-xl font-bold">  &copy;  RyyzDev | Sistem Kasir</h1>
      <nav class="space-x-6">
        <a href="#" class="hover:text-indigo-200">Home</a>
        <a href="#" class="hover:text-indigo-200">Laporan</a>
        <form action="/logout" method="POST" style="display: inline;">
          @csrf
          <button type="submit" class="hover:text-indigo-200">Logout</button>
        </form>
      </nav>
    </div>
  </header>

  <!-- Flash Messages -->
  @if(session('success'))
      <div class="max-w-7xl mx-auto px-6 pt-4">
          <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
              {{ session('success') }}
          </div>
      </div>
  @endif

  @if(session('error'))
      <div class="max-w-7xl mx-auto px-6 pt-4">
          <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
              {{ session('error') }}
          </div>
      </div>
  @endif

  <!-- User Info -->
  <div class="max-w-7xl mx-auto px-6 pt-4">
      @auth
          <div class="bg-blue-50 border border-blue-200 px-4 py-2 rounded mb-4">
              <p class="text-sm">Welcome, <strong>{{ Auth::user()->name }}</strong> | {{ Auth::user()->email }}</p>
          </div>
      @else
          <div class="bg-yellow-50 border border-yellow-200 px-4 py-2 rounded mb-4">
              <p>Please <a href="/login" class="text-blue-600 underline">login</a> first.</p>
          </div>
      @endauth
  </div>

  <!-- Tabs -->
  <main x-data="{
        tab: 'produk',
        cartItems: [],
        modal: '',
        searchQuery: '',
        showSuccess: false,
        totalBayar: 0, // input dari user
        kembalian: 0,
        products: {{ Js::from($products) }},

        get searchResults() {
            if (this.searchQuery === '') {
                return this.products;
            }
            return this.products.filter(p => 
                p.nama.toLowerCase().includes(this.searchQuery.toLowerCase())
            );
        },
        addToCart(product) {
            const existingItem = this.cartItems.find(item => item.id === product.id);
            if (existingItem) {
                if (existingItem.quantity < product.qty) {
                    existingItem.quantity += 1;
                    existingItem.subtotal = existingItem.quantity * existingItem.price;
                } else {
                    alert('Quantity melebihi stok yang tersedia!');
                    return;
                }
            } else {
                this.cartItems.push({
                    id: product.id,
                    nama: product.nama,
                    kode: product.kode,
                    price: product.price,
                    quantity: 1,
                    subtotal: product.price,
                    maxStock: product.qty
                });
            }

            this.modal = '';
        },
        updateQuantity(itemId, newQty) {
            const item = this.cartItems.find(i => i.id === itemId);
            if (item) {
                if (newQty <= 0) {
                    this.removeFromCart(itemId);
                } else if (newQty <= item.maxStock) {
                    item.quantity = parseInt(newQty);
                    item.subtotal = item.quantity * item.price;
                } else {
                    alert('Quantity melebihi stok yang tersedia!');
                }
            }
        },
        removeFromCart(itemId) {
            this.cartItems = this.cartItems.filter(item => item.id !== itemId);
        },
        getTotal() {
            return this.cartItems.reduce((total, item) => total + item.subtotal, 0);
        },
        prosesPembayaran() {
        const total = this.getTotal();
        if (this.totalBayar < total) {
            alert('Jumlah bayar kurang dari total!');
            return;
        }
        this.kembalian = this.totalBayar - total;
        this.showSuccess = true;
    },
        formatRupiah(amount) {
            return new Intl.NumberFormat('id-ID', { 
                style: 'currency', 
                currency: 'IDR', 
                minimumFractionDigits: 0, 
                maximumFractionDigits: 0 
            }).format(amount);
        },
        clearTransaction() {
            if (confirm('Apakah Anda yakin ingin membatalkan semua transaksi?')) {
                this.cartItems = [];
                this.modal = '';
            }
        },
        successClearTransaction(){
          this.cartItems = [];
          this.modal = '';
        },

    }" class="max-w-7xl mx-auto px-6 py-8">

    <!-- Tab Navigation -->
    <!-- Tab Navigation -->
    <div class="flex border-b border-gray-200 mb-6">
      <button @click="tab = 'produk'" :class="tab === 'produk' ? 'border-indigo-600 text-indigo-600' : 'text-gray-500'"
        class="px-4 py-2 font-semibold border-b-2 focus:outline-none">Produk / Transaksi</button>
      <button @click="tab = 'supplier'" :class="tab === 'supplier' ? 'border-indigo-600 text-indigo-600' : 'text-gray-500'"
        class="px-4 py-2 font-semibold border-b-2 focus:outline-none">Supplier</button>
      <button @click="tab = 'stock'" :class="tab === 'stock' ? 'border-indigo-600 text-indigo-600' : 'text-gray-500'"
        class="px-4 py-2 font-semibold border-b-2 focus:outline-none">Stock Opname</button>
    </div>

    <!-- Tab 1: Produk / Transaksi -->
    <div x-show="tab === 'produk'" class="space-y-6">
      <h2 class="text-2xl font-bold">Transaksi Baru</h2>

      <!-- Table produk yang dipilih -->
      <div class="bg-white shadow rounded-lg p-4">
        <div class="flex justify-between items-center mb-4">
          <h3 class="text-lg font-semibold">Daftar Produk</h3>
          <span class="text-sm text-gray-500" x-text="cartItems.length + ' item(s)'"></span>
        </div>
        
        <div class="overflow-x-auto">
          <table class="w-full text-left text-sm">
            <thead>
              <tr class="border-b bg-gray-50">
                <th class="py-3 px-4 font-medium">Produk</th>
                <th class="py-3 px-4 font-medium">Harga</th>
                <th class="py-3 px-4 font-medium">Qty</th>
                <th class="py-3 px-4 font-medium">Subtotal</th>
                <th class="py-3 px-4 font-medium">Aksi</th>
              </tr>
            </thead>
            <tbody>
              <!-- Tampilkan jika cart kosong -->
              <tr x-show="cartItems.length === 0">
                <td colspan="5" class="py-8 text-center text-gray-500">
                  <div class="flex flex-col items-center">
                    <svg class="w-12 h-12 text-gray-300 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                    </svg>
                    <p>Belum ada produk yang dipilih</p>
                    <p class="text-xs">Klik "Cari Produk" untuk menambah item</p>
                  </div>
                </td>
              </tr>
              
              <!-- Loop cart items -->
              <template x-for="item in cartItems" :key="item.id">
                <tr class="border-b border-gray-100">
                  <td class="py-3 px-4">
                    <div>
                      <p class="font-medium" x-text="item.nama"></p>
                      <p class="text-xs text-gray-500" x-text="'Kode: ' + item.kode"></p>
                    </div>
                  </td>
                  <td class="py-3 px-4" x-text="formatRupiah(item.price)"></td>
                  <td class="py-3 px-4">
                    <div class="flex items-center space-x-2">
                      <button @click="updateQuantity(item.id, item.quantity - 1)" 
                        class="w-6 h-6 bg-gray-200 rounded text-sm hover:bg-gray-300">−</button>
                      <input type="number" :value="item.quantity" 
                        @input="updateQuantity(item.id, $event.target.value)"
                        class="w-16 text-center border rounded px-1 py-1 text-sm"
                        min="1" :max="item.maxStock">
                      <button @click="updateQuantity(item.id, item.quantity + 1)" 
                        class="w-6 h-6 bg-gray-200 rounded text-sm hover:bg-gray-300">+</button>
                    </div>
                    <p class="text-xs text-gray-500 mt-1" x-text="'Stok: ' + item.maxStock"></p>
                  </td>
                  <td class="py-3 px-4 font-semibold" x-text="formatRupiah(item.subtotal)"></td>
                  <td class="py-3 px-4">
                    <button @click="removeFromCart(item.id)" 
                      class="text-red-500 hover:text-red-700 text-sm">
                      <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                      </svg>
                    </button>
                  </td>
                </tr>
              </template>
              
              <!-- Total row -->
              <tr x-show="cartItems.length > 0" class="border-t-2 border-gray-200 bg-gray-50">
                <td colspan="3" class="py-3 px-4 font-semibold text-right">TOTAL:</td>
                <td class="py-3 px-4 font-bold text-lg text-green-600" x-text="formatRupiah(getTotal())"></td>
                <td class="py-3 px-4"></td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>

      <!-- Tombol aksi -->
      <div class="flex flex-wrap gap-3">
        <button @click="modal = 'cariProduk'" class="px-4 py-2 bg-indigo-600 text-white rounded-lg shadow hover:bg-indigo-700 flex items-center">
          <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
          </svg>
          Cari Produk
        </button>
        <button @click="clearTransaction()" :disabled="cartItems.length === 0"
          class="px-4 py-2 bg-red-500 text-white rounded-lg shadow hover:bg-red-600 disabled:bg-gray-300 disabled:cursor-not-allowed">
          Batalkan Transaksi
        </button>
        <button @click="modal = 'pembayaran'" :disabled="cartItems.length === 0"
          class="px-4 py-2 bg-green-600 text-white rounded-lg shadow hover:bg-green-700 disabled:bg-gray-300 disabled:cursor-not-allowed flex items-center">
          <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"></path>
          </svg>
          Lanjut Pembayaran
        </button>
      </div>
    </div>

    <!-- Tab 2: Supplier -->
    <div x-show="tab === 'supplier'" class="space-y-6">
      <h2 class="text-2xl font-bold">Tambah Supplier Baru</h2>
      
      <!-- Form Tambah Supplier -->
      <div class="bg-white shadow rounded-lg p-6 space-y-4">
        <h3 class="text-lg font-semibold text-gray-800 mb-4">Data Supplier</h3>
        
        <form action="/suppliers" method="POST" class="space-y-4">
          @csrf
          
          <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
              <label class="block text-sm font-medium mb-1 text-gray-700">Nama Supplier *</label>
              <input type="text" name="nama_supplier" required 
                class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
            </div>
            <div>
              <label class="block text-sm font-medium mb-1 text-gray-700">Kode Supplier *</label>
              <input type="text" name="kode_supplier" required 
                class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
            </div>
          </div>

          <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
              <label class="block text-sm font-medium mb-1 text-gray-700">Kontak/Telepon</label>
              <input type="text" name="kontak" 
                class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
            </div>
            <div>
              <label class="block text-sm font-medium mb-1 text-gray-700">Email</label>
              <input type="email" name="email" 
                class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
            </div>
          </div>

          <div>
            <label class="block text-sm font-medium mb-1 text-gray-700">Alamat</label>
            <textarea name="alamat" rows="2" 
              class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500"></textarea>
          </div>
       <h3 class="text-lg font-semibold text-gray-800 mb-4">Data Produk</h3>
          <div>
              <label class="block text-sm font-medium mb-1 text-gray-700">Nama Produk *</label>
              <input type="text" name="nama" required 
                class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
            </div>
           <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
              <label class="block text-sm font-medium mb-1 text-gray-700">Price *</label>
              <input type="text" name="price" required 
                class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
            </div>
            <div>
              <label class="block text-sm font-medium mb-1 text-gray-700">Quantity *</label>
              <input type="text" name="qty" required 
                class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
            </div>
          </div>

          <!-- Deskripsi Dinamis -->
          <div>
            <div class="flex justify-between items-center mb-2">
              <label class="block text-sm font-medium text-gray-700">Deskripsi Produk</label>
              <button type="button" @click="deskripsi.push('')" 
                class="text-sm bg-blue-500 text-white px-3 py-1 rounded hover:bg-blue-600">
                + Tambah Deskripsi (masih pengembangan... :)
              </button>
            </div>
            
            <div class="space-y-2">
              <template x-for="(desc, index) in deskripsi" :key="index">
                <div class="flex items-center space-x-2">
                  <input type="text" :name="'deskripsi[' + index + ']'" x-model="deskripsi[index]"
                    placeholder="Masukkan deskripsi produk..."
                    class="flex-1 border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                  
                  <button type="button" x-show="deskripsi.length > 1" 
                    @click="deskripsi.splice(index, 1)"
                    class="text-red-500 hover:text-red-700 px-2 py-1">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                  </button>
                </div>
              </template>
            </div>
          </div>
    

          <div class="flex justify-end space-x-3 pt-4">
            <button type="reset" 
              class="px-4 py-2 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50">
              Reset
            </button>
            <button type="submit" 
              class="px-6 py-2 bg-indigo-600 text-white font-semibold rounded-lg shadow hover:bg-indigo-700 focus:ring-2 focus:ring-indigo-500">
              Simpan Supplier
            </button>
          </div>
        </form>
      </div>

      <!-- Tabel Data Supplier -->
      <div class="bg-white shadow rounded-lg p-6">
        <h3 class="text-lg font-semibold text-gray-800 mb-4">Daftar Supplier</h3>
        
        <div class="overflow-x-auto">
          <table class="w-full text-left text-sm">
            <thead>
              <tr class="border-b border-gray-200 bg-gray-50">
                <th class="py-3 px-4 font-medium">Kode</th>
                <th class="py-3 px-4 font-medium">Nama Supplier</th>
                <th class="py-3 px-4 font-medium">Kontak</th>
                <th class="py-3 px-4 font-medium">Status</th>
                <th class="py-3 px-4 font-medium">Aksi</th>
              </tr>
            </thead>
            @foreach($products as $data)
            <tbody>
              <tr class="border-b border-gray-100">
                <td class="py-3 px-4">{{$data->kode_supplier}}</td>
                <td class="py-3 px-4">{{$data->nama_supplier}}</td>
                <td class="py-3 px-4">{{$data->kontak}}</td>
                <td class="py-3 px-4">
                  @if($data->status == 1)
                  <span class="px-2 py-1 text-xs bg-green-100 text-green-800 rounded-full">
                  Aktif
                  </span>
                  @else
                    <span class="px-2 py-1 text-xs bg-green-100 text-green-800 rounded-full">
                  Tidak Aktif
                  </span>
                  @endif
                </td>
                <td class="py-3 px-4">
                  <div class="flex space-x-2">
                    <form action="{{route('products.destroy', $data->id)}}" method="POST" onsubmit="return confirm('Yakin Mau Menghapus?')">
                      @method('delete')
                      @csrf
                       <button class="text-red-600 hover:text-red-800 text-sm">Hapus</button>
                  </form>
                  </div>
                </td>
              </tr>
            </tbody>
            @endforeach
          </table>
        </div>
      </div>
    </div>

    <!-- Tab 3: Stock Opname -->
    <div x-show="tab === 'stock'" class="space-y-6">
      <h2 class="text-2xl font-bold">Stock Opname</h2>
      <div class="bg-white shadow rounded-lg p-6 overflow-x-auto">
        <table class="w-full text-left">
          <thead>
            <tr class="border-b">
              <th class="py-2">Produk</th>
              <th class="py-2">Qty Sistem</th>
              <th class="py-2">Qty Fisik</th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <td>Produk A</td>
              <td>50</td>
              <td><input type="number" class="border rounded px-2 py-1 w-24"></td>
            </tr>
            <tr>
              <td>Produk B</td>
              <td>20</td>
              <td><input type="number" class="border rounded px-2 py-1 w-24"></td>
            </tr>
          </tbody>
        </table>
      </div>
      <button class="px-6 py-3 bg-green-600 text-white rounded-lg shadow hover:bg-green-700">Simpan Stock Opname</button>
    </div>

    <!-- ================= POPUP MODAL ================= -->
    <!-- Overlay -->
    <template x-if="modal !== ''">
      <div class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 p-4">
        <div class="bg-white rounded-lg shadow-lg w-full p-6 relative" 
             :class="modal === 'cariProduk' ? 'max-w-4xl' : 'max-w-md'">
          <button @click="modal = ''" class="absolute top-2 right-2 text-gray-500 hover:text-gray-700">&times;</button>

          <!-- Modal: Cari Produk -->
          <div x-show="modal === 'cariProduk'" class="max-w-4xl">
            <h3 class="text-xl font-bold mb-4 text-center">Cari Produk</h3>
            
            <!-- Search Input -->
            <div class="mb-4">
            <input 
  type="text" 
  x-model="searchQuery"
  placeholder="Cari produk..." 
  class="border p-2 w-full rounded"
/>

            </div>

            <!-- Product Table -->
            <div class="max-h-80 overflow-y-auto border border-gray-200 rounded-lg">
              <table class="w-full text-left text-sm">
                <thead class="sticky top-0 bg-gray-50 border-b border-gray-200">
                  <tr>
                    <th class="py-3 px-4 font-medium text-gray-700">Nama Produk</th>
                    <th class="py-3 px-4 font-medium text-gray-700">Harga</th>
                    <th class="py-3 px-4 font-medium text-gray-700">Stok</th>
                    <th class="py-3 px-4 font-medium text-gray-700 text-center">Aksi</th>
                  </tr>
                </thead>
                <tbody>
                  <!-- Loop filtered products -->
         <template x-for="product in searchResults" :key="product.id">
  <tr class="border-b">
    <td class="py-2 px-4" x-text="product.nama"></td>
    <td class="py-2 px-4" x-text="formatRupiah(product.price)"></td>
    <td class="py-2 px-4" x-text="product.qty"></td>
    <td class="py-2 px-4 text-center">
      <button @click="addToCart(product)" class="bg-blue-500 text-white px-2 py-1 rounded">
        Tambah
      </button>
    </td>
  </tr>
</template>

                  
                  <!-- No results message -->
                  <tr x-show="searchResults.length === 0">
                    <td colspan="4" class="py-8 text-center text-gray-500">
                      <div class="flex flex-col items-center">
                        <svg class="w-8 h-8 text-gray-300 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                        </svg>
                        <p>Produk tidak ditemukan</p>
                        <p class="text-xs">Coba kata kunci yang berbeda</p>
                      </div>
                    </td>
                  </tr>
                </tbody>
              </table>
            </div>

            <!-- Footer Actions -->
            <div class="flex justify-between items-center mt-4 pt-4 border-t border-gray-200">
              <p class="text-sm text-gray-600" x-text="'Menampilkan ' + searchResults.length + ' produk'"></p>
              <div class="flex space-x-2">
                <button @click="modal = ''; searchQuery = ''" class="px-4 py-2 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50">
                  Tutup
                </button>
              </div>
            </div>
          </div>

          <!-- Modal: Batalkan Transaksi -->
          <div x-show="modal === 'batalTransaksi'">
            <h3 class="text-xl font-bold mb-4">Batalkan Transaksi</h3>
            <p class="mb-4">Apakah Anda yakin ingin membatalkan transaksi ini?</p>
            <div class="flex justify-end space-x-2">
              <button @click="modal = ''" class="px-4 py-2 bg-gray-300 rounded">Tidak</button>
              <button class="px-4 py-2 bg-red-600 text-white rounded">Ya, Batalkan</button>
            </div>
          </div>

          <!-- Modal: Pembayaran -->
          <div x-show="modal === 'pembayaran'">
            <h3 class="text-xl font-bold mb-4">Pembayaran</h3>
            
            <!-- Summary transaksi -->
            <div class="bg-gray-50 p-4 rounded-lg mb-4">
              <h4 class="font-semibold mb-2">Ringkasan Transaksi</h4>
              <div class="space-y-1 text-sm">
                <div class="flex justify-between">
                  <span>Total Item:</span>
                  <span x-text="cartItems.reduce((sum, item) => sum + item.quantity, 0) + ' pcs'"></span>
                </div>
                <div class="flex justify-between font-semibold text-lg border-t pt-2">
                  <span>Total Pembayaran:</span>
                  <span x-text="formatRupiah(getTotal())" class="text-green-600"></span>
                </div>
              </div>
            </div>
            
            <div class="space-y-4">
              <div>
                <label class="block mb-2 font-medium">Metode Pembayaran</label>
                <select class="w-full border rounded-lg px-3 py-2 focus:ring-2 focus:ring-green-500">
                  <option>Cash</option>
                  <option>QRIS (integrasi API payment gateway)</option>
                  <option>Debit Card (integrasi API payment gateway)</option>
                  <option>Credit Card (integrasi API payment gateway)</option>
                </select>
              </div>
              
             <div>
              <label class="block mb-2 font-medium">Jumlah Bayar</label>
              <input type="number" 
                     x-model="totalBayar" 
                     :placeholder="'Minimal: ' + formatRupiah(getTotal())" 
                     class="w-full border rounded-lg px-3 py-2 focus:ring-2 focus:ring-green-500">
              </div>
              
              <div class="flex justify-end space-x-2 pt-4">
                <button @click="modal = ''" class="px-4 py-2 border border-gray-300 rounded-lg hover:bg-gray-50">
                  Batal
                </button>
               <button @click="prosesPembayaran()" class="px-6 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700">
                Proses Pembayaran
              </button>
              </div>
<!-- Popup Sukses -->
<div 
  x-show="showSuccess" 
  x-transition 
  class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 z-50">
  <div class="bg-white rounded-2xl shadow-xl p-6 max-w-sm w-full text-center">
    
    <!-- Icon centang -->
    <div class="flex justify-center mb-4">
      <svg class="w-16 h-16 text-green-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
      </svg>
    </div>

    <h2 class="text-xl font-bold mb-2">Pembayaran Berhasil!</h2>
    <div class="text-gray-700 text-sm text-left space-y-1 mb-4">
      <p><span class="font-medium">Total Harga:</span> <span x-text="formatRupiah(getTotal())"></span></p>
      <p><span class="font-medium">Jumlah Bayar:</span> <span x-text="formatRupiah(totalBayar)"></span></p>
      <p><span class="font-medium">Kembalian:</span> <span x-text="formatRupiah(kembalian)"></span></p>
    </div>

    <button 
      @click="showSuccess = false; modal = ''; successClearTransaction()" 
      class="px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700">
      Tutup
    </button>
     <button 
  
      class="px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700">
      Cetak Struk
    </button>
  </div>
</div>

</div>
            </div>
          </div>
        </div>
      </div>
    </template>
  </main>
</body>
</html>