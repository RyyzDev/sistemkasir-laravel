<!DOCTYPE html>
<html lang="id">
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
            <h1 class="text-xl font-bold">Sistem Kasir</h1>
            <nav class="space-x-6">
                <a href="#" class="hover:text-indigo-200">Home</a>
                <a href="#" class="hover:text-indigo-200">Laporan</a>
                <a href="#" class="hover:text-indigo-200">Logout</a>
            </nav>
        </div>
    </header>

    <!-- Tabs -->
    <main x-data="{ tab: 'produk' }" class="max-w-7xl mx-auto px-6 py-8">

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

            <!-- Table produk yg discan -->
            <div class="bg-white shadow rounded-lg p-4">
                <table class="w-full text-left">
                    <thead>
                        <tr class="border-b">
                            <th class="py-2">Produk</th>
                            <th class="py-2">Harga</th>
                            <th class="py-2">Qty</th>
                            <th class="py-2">Subtotal</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>Contoh Produk</td>
                            <td>Rp 20.000</td>
                            <td>2</td>
                            <td>Rp 40.000</td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <!-- Tombol aksi -->
            <div class="flex space-x-4">
                <button class="px-4 py-2 bg-indigo-600 text-white rounded-lg shadow hover:bg-indigo-700">Cari Produk</button>
                <button class="px-4 py-2 bg-red-500 text-white rounded-lg shadow hover:bg-red-600">Batalkan Transaksi</button>
                <button class="px-4 py-2 bg-yellow-500 text-white rounded-lg shadow hover:bg-yellow-600">Voucher</button>
                <button class="px-4 py-2 bg-green-600 text-white rounded-lg shadow hover:bg-green-700">Lanjut Pembayaran</button>
            </div>
        </div>

        <!-- Tab 2: Supplier -->
        <div x-show="tab === 'supplier'" class="space-y-6">
            <h2 class="text-2xl font-bold">Data Supplier</h2>

            <div class="bg-white shadow rounded-lg p-6 space-y-4">
                <form action="#" method="POST" class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium mb-1">Nama Supplier</label>
                        <input type="text" name="nama_supplier" class="w-full border rounded-lg px-3 py-2 focus:ring-2 focus:ring-indigo-500">
                    </div>
                    <div>
                        <label class="block text-sm font-medium mb-1">Produk</label>
                        <input type="text" name="produk" class="w-full border rounded-lg px-3 py-2 focus:ring-2 focus:ring-indigo-500">
                    </div>
                    <div>
                        <label class="block text-sm font-medium mb-1">Kode</label>
                        <input type="text" name="kode" class="w-full border rounded-lg px-3 py-2 focus:ring-2 focus:ring-indigo-500">
                    </div>
                    <div>
                        <label class="block text-sm font-medium mb-1">Kuantiti</label>
                        <input type="number" name="qty" class="w-full border rounded-lg px-3 py-2 focus:ring-2 focus:ring-indigo-500">
                    </div>
                    <div class="col-span-full">
                        <button type="submit" class="w-full bg-indigo-600 text-white font-semibold py-3 rounded-lg shadow hover:bg-indigo-700">
                            Simpan Supplier
                        </button>
                    </div>
                </form>
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

    </main>
</body>
</html>
