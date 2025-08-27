<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Metode Pembayaran - Sistem Kasir</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <script src="//unpkg.com/alpinejs" defer></script>
</head>
<body class="bg-gray-100 text-gray-800 font-sans min-h-screen flex flex-col">

  <!-- Header -->
  <header class="bg-gradient-to-r from-indigo-600 to-purple-600 text-white shadow-lg">
    <div class="max-w-7xl mx-auto flex justify-between items-center px-6 py-4">
      <h1 class="text-xl font-bold">Sistem Kasir</h1>
      <nav class="space-x-6">
        <a href="{{ url('/dashboard') }}" class="hover:text-indigo-200">Dashboard</a>
        <a href="{{ url('/laporan') }}" class="hover:text-indigo-200">Laporan</a>
        <a href="{{ url('/logout') }}" class="hover:text-indigo-200">Logout</a>
      </nav>
    </div>
  </header>

  <!-- Main -->
  <main class="flex-1 max-w-3xl mx-auto px-6 py-10" 
        x-data="{ metode: 'cash', total: 125000, bayar: 0 }">

    <h2 class="text-2xl font-bold mb-6 text-center">Metode Pembayaran</h2>

    <!-- Total Belanja -->
    <div class="bg-white shadow rounded-lg p-6 mb-6">
      <p class="text-lg text-gray-600">Total Belanja</p>
      <h3 class="text-3xl font-bold text-indigo-600 mt-2">Rp <span x-text="total.toLocaleString()"></span></h3>
    </div>

    <!-- Pilihan Metode -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
      <button @click="metode = 'cash'" 
              :class="metode === 'cash' ? 'bg-indigo-600 text-white' : 'bg-white text-gray-700 border'" 
              class="py-4 rounded-lg font-semibold shadow transition hover:opacity-90">
        Cash
      </button>
      <button @click="metode = 'debit'" 
              :class="metode === 'debit' ? 'bg-indigo-600 text-white' : 'bg-white text-gray-700 border'" 
              class="py-4 rounded-lg font-semibold shadow transition hover:opacity-90">
        Debit
      </button>
      <button @click="metode = 'ewallet'" 
              :class="metode === 'ewallet' ? 'bg-indigo-600 text-white' : 'bg-white text-gray-700 border'" 
              class="py-4 rounded-lg font-semibold shadow transition hover:opacity-90">
        E-Wallet
      </button>
    </div>

    <!-- Form Input Pembayaran -->
    <div class="bg-white shadow rounded-lg p-6 space-y-4">
      <!-- Input Uang Bayar -->
      <div>
        <label class="block text-sm font-medium mb-1">Jumlah Dibayar</label>
        <input type="number" min="0" x-model="bayar"
               class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-indigo-500">
      </div>

      <!-- Kembalian -->
      <div>
        <label class="block text-sm font-medium mb-1">Kembalian</label>
        <div class="px-4 py-2 bg-gray-100 border rounded-lg font-bold text-lg">
          Rp <span x-text="(bayar - total > 0 ? (bayar - total) : 0).toLocaleString()"></span>
        </div>
      </div>

      <!-- Tombol Konfirmasi -->
      <button class="w-full py-3 bg-green-600 text-white font-semibold rounded-lg shadow hover:bg-green-700 transition">
        Konfirmasi Pembayaran
      </button>
    </div>
  </main>

  <!-- Footer -->
  <footer class="bg-gray-50 text-center p-4 text-sm text-gray-500">
    &copy; {{ date('Y') }} Sistem Kasir - All Rights Reserved
  </footer>
</body>
</html>
