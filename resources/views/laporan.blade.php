<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan - Sistem Kasir</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="//unpkg.com/alpinejs" defer></script>
</head>
<body class="bg-gray-100 text-gray-800 font-sans min-h-screen">

    <!-- Navbar -->
    <header class="bg-gradient-to-r from-indigo-600 to-purple-600 text-white shadow-lg">
        <div class="max-w-7xl mx-auto flex justify-between items-center px-6 py-4">
            <h1 class="text-xl font-bold">Sistem Kasir</h1>
            <nav class="space-x-6">
                <a href="{{ url('/dashboard') }}" class="hover:text-indigo-200">Dashboard</a>
                <a href="{{ url('/laporan') }}" class="hover:text-indigo-200 font-semibold underline">Laporan</a>
                <a href="{{ url('/logout') }}" class="hover:text-indigo-200">Logout</a>
            </nav>
        </div>
    </header>

    <main class="max-w-7xl mx-auto px-6 py-8 space-y-8">
        <!-- Filter -->
        <section class="bg-white shadow rounded-lg p-6">
            <h2 class="text-2xl font-bold mb-4">Filter Laporan</h2>
            <form class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div>
                    <label class="block text-sm font-medium mb-1">Tanggal Mulai</label>
                    <input type="date" name="start_date" class="w-full border rounded-lg px-3 py-2 focus:ring-2 focus:ring-indigo-500">
                </div>
                <div>
                    <label class="block text-sm font-medium mb-1">Tanggal Akhir</label>
                    <input type="date" name="end_date" class="w-full border rounded-lg px-3 py-2 focus:ring-2 focus:ring-indigo-500">
                </div>
                <div class="flex items-end">
                    <button type="submit" class="w-full bg-indigo-600 text-white py-2 rounded-lg hover:bg-indigo-700">Terapkan</button>
                </div>
            </form>
        </section>

        <!-- Ringkasan -->
        <section class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <div class="bg-white shadow rounded-lg p-6 text-center">
                <p class="text-sm text-gray-500">Total Transaksi Hari Ini</p>
                <h3 class="text-2xl font-bold text-indigo-600 mt-2">45</h3>
            </div>
            <div class="bg-white shadow rounded-lg p-6 text-center">
                <p class="text-sm text-gray-500">Total Penjualan</p>
                <h3 class="text-2xl font-bold text-green-600 mt-2">Rp 12.500.000</h3>
            </div>
            <div class="bg-white shadow rounded-lg p-6 text-center">
                <p class="text-sm text-gray-500">Produk Terlaris</p>
                <h3 class="text-2xl font-bold text-purple-600 mt-2">Minyak Goreng</h3>
            </div>
        </section>

        <!-- Tabel Transaksi -->
        <section class="bg-white shadow rounded-lg p-6 overflow-x-auto">
            <h2 class="text-xl font-bold mb-4">Detail Transaksi</h2>
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="border-b bg-gray-50">
                        <th class="py-2 px-3">ID Transaksi</th>
                        <th class="py-2 px-3">Produk</th>
                        <th class="py-2 px-3">Qty</th>
                        <th class="py-2 px-3">Total</th>
                        <th class="py-2 px-3">Kasir</th>
                        <th class="py-2 px-3">Tanggal</th>
                    </tr>
                </thead>
                <tbody class="divide-y">
                    <tr>
                        <td class="py-2 px-3">#TRX001</td>
                        <td class="py-2 px-3">Indomie Goreng</td>
                        <td class="py-2 px-3">5</td>
                        <td class="py-2 px-3">Rp 75.000</td>
                        <td class="py-2 px-3">Admin</td>
                        <td class="py-2 px-3">27 Agustus 2025, 10:30</td>
                    </tr>
                    <tr>
                        <td class="py-2 px-3">#TRX002</td>
                        <td class="py-2 px-3">Beras Premium</td>
                        <td class="py-2 px-3">2</td>
                        <td class="py-2 px-3">Rp 200.000</td>
                        <td class="py-2 px-3">Ryyz</td>
                        <td class="py-2 px-3">27 Agustus 2025, 11:00</td>
                    </tr>
                </tbody>
            </table>
        </section>

        <!-- Export Button -->
        <section class="flex justify-end">
            <button class="px-6 py-3 bg-green-600 text-white rounded-lg shadow hover:bg-green-700">Export ke Excel</button>
        </section>
    </main>
</body>
</html>
