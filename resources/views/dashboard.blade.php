<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Admin Dashboard</title>
    <script src="https://cdn.tailwindcss.com"></script>

    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.9.1/chart.min.js"></script>

    <link rel="stylesheet" href="{{ asset('css/style.css') }}">

    <script type="module" src="https://unpkg.com/heroicons@2.1.1/dist/solid.js"></script>
    <script type="module" src="https://unpkg.com/heroicons@2.1.1/dist/outline.js"></script>

    <style>
        body {
            display: flex;
            align-items: center;
            justify-content: center;
        }
    </style>
</head>
<body 
    x-data="{ 
        activeTab: 'laporan', 
        showProdukModal: false, 
        isEditMode: false,
        showGajiModal: false,
        showSupplierModal: false,
        showKaryawanModal: false, 
    }"
>

@include('components.poscomponents.logicfunction')
<!-- @if(session('success'))
      <div class="max-w-7xl mx-auto px-6 pt-4">
          <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
              {{ session('success') }}
          </div>
      </div>
  @endif

  @if(session('error'))
          <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
              {{ session('error') }}
          </div>
      </div>
  @endif -->

    <div class="app-container w-[95%] h-[95vh] max-w-screen-2xl mx-auto flex">
        <nav class="w-64 bg-gray-900 text-white flex-shrink-0 p-4 flex flex-col">
            <div class="text-center p-4 mb-4">
                <h1 class="text-2xl font-bold gradient-text">Management App</h1>
            </div>

            <ul class="flex flex-col gap-2">
                <li>
                    <a @click="activeTab = 'laporan'"
                       :class="{ 'active': activeTab === 'laporan' }"
                       class="menu-item flex items-center gap-3">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-6 h-6"><path fill-rule="evenodd" d="M3 6a3 3 0 0 1 3-3h2.25a3 3 0 0 1 3 3v2.25a3 3 0 0 1-3 3H6a3 3 0 0 1-3-3V6Zm12 0a3 3 0 0 1 3-3H21a3 3 0 0 1 3 3v2.25a3 3 0 0 1-3 3h-2.25a3 3 0 0 1-3-3V6ZM3 15.75a3 3 0 0 1 3-3h2.25a3 3 0 0 1 3 3V18a3 3 0 0 1-3 3H6a3 3 0 0 1-3-3v-2.25Zm12 0a3 3 0 0 1 3-3H21a3 3 0 0 1 3 3V18a3 3 0 0 1-3 3h-2.25a3 3 0 0 1-3-3v-2.25Z" clip-rule="evenodd" /></svg>
                        Laporan
                    </a>
                </li>
                <li>
                    <a @click="activeTab = 'produk'"
                       :class="{ 'active': activeTab === 'produk' }"
                       class="menu-item flex items-center gap-3">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-6 h-6"><path d="M5.625 1.5c-1.036 0-1.875.84-1.875 1.875v17.25c0 1.035.84 1.875 1.875 1.875h12.75c1.035 0 1.875-.84 1.875-1.875V12.75A3.75 3.75 0 0 0 16.5 9h-1.875a.375.375 0 0 1-.375-.375V6.375A3.75 3.75 0 0 0 10.5 2.625H8.625a.375.375 0 0 1-.375-.375V1.5H5.625ZM12 9.375A.375.375 0 0 0 11.625 9H9.375A.375.375 0 0 0 9 9.375v2.25c0 .207.168.375.375.375h2.25A.375.375 0 0 0 12 11.625v-2.25Z" /><path d="M14.25 1.5c.207 0 .375.168.375.375v2.25A3.75 3.75 0 0 0 18.375 7.875h2.25A.375.375 0 0 0 21 7.5V5.625c0-1.036-.84-1.875-1.875-1.875h-2.25a.375.375 0 0 1-.375-.375V1.5h-2.25Z" /></svg>
                        Produk
                    </a>
                </li>
                <li>
                    <a @click="activeTab = 'supplier'"
                       :class="{ 'active': activeTab === 'supplier' }"
                       class="menu-item flex items-center gap-3">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-6 h-6"><path d="M4.5 6.375a.75.75 0 0 1 .75-.75h13.5a.75.75 0 0 1 .75.75v11.25a.75.75 0 0 1-.75.75H5.25a.75.75 0 0 1-.75-.75V6.375Z" /><path fill-rule="evenodd" d="M20.25 2.25A.75.75 0 0 0 19.5 3v1.125a.75.75 0 0 0 .75.75h1.5a.75.75 0 0 0 .75-.75V3a.75.75 0 0 0-.75-.75h-1.5ZM2.25 4.875a.75.75 0 0 0-.75.75v11.25c0 .414.336.75.75.75h.001a.75.75 0 0 0 .75-.75V5.625a.75.75 0 0 0-.75-.75H2.25ZM19.5 19.875v1.125a.75.75 0 0 1-.75.75h-1.5a.75.75 0 0 1-.75-.75V19.875c0 .414.336.75.75.75h1.5a.75.75 0 0 0 .75-.75Z" clip-rule="evenodd" /></svg>
                        Supplier
                    </a>
                </li>
                <li>
                    <a @click="activeTab = 'karyawan'"
                       :class="{ 'active': activeTab === 'karyawan' }"
                       class="menu-item flex items-center gap-3">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-6 h-6"><path fill-rule="evenodd" d="M8.25 6.75a3.75 3.75 0 1 1 7.5 0 3.75 3.75 0 0 1-7.5 0ZM15.75 9.75a.75.75 0 0 0-1.5 0v.75c0 .414.336.75.75.75h.75a.75.75 0 0 0 .75-.75v-.75ZM4.5 9.75a.75.75 0 0 1 .75-.75h.75a.75.75 0 0 1 .75.75v.75c0 .414-.336.75-.75.75h-.75a.75.75 0 0 1-.75-.75v-.75ZM15 12a.75.75 0 0 0-1.5 0v.75c0 .414.336.75.75.75h.75a.75.75 0 0 0 .75-.75v-.75ZM4.5 12a.75.75 0 0 1 .75-.75h.75a.75.75 0 0 1 .75.75v.75c0 .414-.336.75-.75.75h-.75a.75.75 0 0 1-.75-.75v-.75ZM12 15a.75.75 0 0 0-1.5 0v.75c0 .414.336.75.75.75h.75a.75.75 0 0 0 .75-.75v-.75Z" clip-rule="evenodd" /><path d="M3 18.75a.75.75 0 0 0-1.5 0v.75c0 1.12 1.006 2.03 2.25 2.03h15c1.244 0 2.25-1.031 2.25-2.28v-.51a.75.75 0 0 0-1.5 0v.51c0 .323-.323.57-.75.57h-15c-.427 0-.75-.247-.75-.57v-.75Z" /></svg>
                        Karyawan
                    </a>
                </li>
                <li>
                    <a @click="activeTab = 'invoice'"
                       :class="{ 'active': activeTab === 'invoice' }"
                       class="menu-item flex items-center gap-3">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-6 h-6"><path d="M3.375 3C2.339 3 1.5 3.84 1.5 4.875v11.25C1.5 17.16 2.34 18 3.375 18h9.75v1.5H6A.75.75 0 0 0 6 21h12a.75.75 0 0 0 0-1.5h-7.125v-1.5h9.75c1.036 0 1.875-.84 1.875-1.875V4.875C22.5 3.839 21.66 3 20.625 3H3.375Z" /><path d="M9 9a.75.75 0 0 0 0 1.5h6a.75.75 0 0 0 0-1.5H9Z" /></svg>
                        Invoice
                    </a>
                </li>
            </ul>

            <div class="mt-auto">
                 <a href="/pos" class="menu-item flex items-center gap-3 bg-blue-600/20 text-blue-300 hover:bg-blue-500 hover:text-white">
                    Back to POS
                </a>
            </div>

             <div class="mt-0 p-0">
                <form action="/logout" method="POST">
                    @csrf
                 <button type="submit" href="/logout" class="menu-item flex items-center gap-3 bg-red-600/20 text-red-300 hover:bg-red-500 hover:text-white">
                    Logout
                </button>
            </form>
            </div>
        </nav>

        <div class="flex-1 flex flex-col overflow-hidden">

            <header class="top-bar p-4 flex justify-between items-center text-white">
                <h2 class="text-xl font-semibold capitalize" x-text="activeTab"></h2>
                <div class="flex items-center gap-4">
                    @auth
                    <div class="flex items-center gap-2">
                        <img src="https://media.licdn.com/dms/image/v2/D5603AQEFt9f_jh0RzQ/profile-displayphoto-scale_200_200/B56ZiMkd.QH0AY-/0/1754705029140?e=1762992000&v=beta&t=vKZKYyNEIYvz89yb0cfyuc-dyu3zJ8v6pSHNTcNoUa8" alt="Avatar" class="w-10 h-10 rounded-full border-2 border-indigo-400">
                        <div>
                            <div class="font-medium">{{ Auth::user()->name }}</div>
                            <div class="font-medium">Founder/CEO</div>
                            <div class="text-xs text-gray-400">{{ Auth::user()->email }}</div>
                        </div>
                    </div>
                    @endauth
                </div>
            </header>

            <main class="flex-1 overflow-y-auto p-6 bg-gray-100">

      @include('components.dashboardcomponents.tablaporan')




                <div x-show="activeTab === 'produk'" x-transition.opacity.duration.300ms>
                    <div class="flex justify-between items-center mb-6">
                        <h2 class="text-2xl font-semibold">Manajemen Produk</h2>
                        <button @click="showProdukModal = true; isEditMode = false;" class="action-btn bg-indigo-600 hover:bg-indigo-700 text-white px-5 py-2 flex items-center gap-2">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-5 h-5"><path d="M10.75 4.75a.75.75 0 0 0-1.5 0v4.5h-4.5a.75.75 0 0 0 0 1.5h4.5v4.5a.75.75 0 0 0 1.5 0v-4.5h4.5a.75.75 0 0 0 0-1.5h-4.5v-4.5Z" /></svg>
                            Tambah Produk
                        </button>
                    </div>

                    <div class="table-container shadow-lg">
                        <table class="w-full">
                            <thead>
                                <tr>
                                    <th class="p-4 text-left">SKU</th>
                                    <th class="p-4 text-left">Nama Produk</th>
                                    <th class="p-4 text-left">Harga</th>
                                    <th class="p-4 text-left">Stok</th>
                                    <th class="p-4 text-left">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                    @foreach($products as $produk)
                                    <th class="p-4">{{$produk->kode_produk}}</th>
                                    <th class="p-4">{{$produk->nama_produk}}</th>
                                    <th class="p-4">{{$produk->price}}</th>
                                    <th class="p-4">{{$produk->qty}}</th>
                                    <td class="p-4 flex gap-2">
                                        <button @click="showProdukModal = true; isEditMode = true;" class="action-btn bg-yellow-500 hover:bg-yellow-600 text-white p-2">
                                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-5 h-5"><path d="m2.695 14.762-1.262 3.155a.5.5 0 0 0 .65.65l3.155-1.262a4 4 0 0 0 1.343-.886L17.5 5.501a2.121 2.121 0 0 0-3-3L3.58 13.42a4 4 0 0 0-.885 1.343Z" /></svg>
                                        </button>
                                        <button class="action-btn bg-red-500 hover:bg-red-600 text-white p-2">
                                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-5 h-5"><path fill-rule="evenodd" d="M8.75 1A2.75 2.75 0 0 0 6 3.75v.443c-.795.077-1.58.11-2.368.11a.75.75 0 0 0-.75.75v1.5c0 .414.336.75.75.75h13.5a.75.75 0 0 0 .75-.75v-1.5a.75.75 0 0 0-.75-.75c-.788 0-1.573-.033-2.368-.11V3.75A2.75 2.75 0 0 0 14 1H8.75ZM6 6.443v-.693A1.25 1.25 0 0 1 7.25 4.5h5.5A1.25 1.25 0 0 1 14 5.75v.693c-1.12.08-2.288.11-3.5.11s-2.38-.03-3.5-.11Z" clip-rule="evenodd" /><path d="M5.25 9.75a.75.75 0 0 0-.75.75v6a.75.75 0 0 0 .75.75h9.5a.75.75 0 0 0 .75-.75v-6a.75.75 0 0 0-.75-.75h-9.5Z" /></svg>
                                        </button>
                                    </td>
                                </tr>
                        @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

                <div x-show="activeTab === 'supplier'" x-transition.opacity.duration.300ms>
                    <div class="flex justify-between items-center mb-6">
                        <h2 class="text-2xl font-semibold">Manajemen Supplier</h2>
                        <button @click="showSupplierModal = true" class="action-btn bg-indigo-600 hover:bg-indigo-700 text-white px-5 py-2 flex items-center gap-2">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-5 h-5"><path d="M10.75 4.75a.75.75 0 0 0-1.5 0v4.5h-4.5a.75.75 0 0 0 0 1.5h4.5v4.5a.75.75 0 0 0 1.5 0v-4.5h4.5a.75.75 0 0 0 0-1.5h-4.5v-4.5Z" /></svg>
                            Tambah Supplier
                        </button>
                    </div>


                    <div class="table-container shadow-lg">
                        <table class="w-full">
                            <thead>
                                <tr>
                                    <th class="p-4 text-left">Nama Supplier</th>
                                    <th class="p-4 text-left">Kode Supplier</th>
                                    <th class="p-4 text-left">Email</th>
                                    <th class="p-4 text-left">Telepon</th>
                                    <th class="p-4 text-left">Aksi</th>
                                </tr>
                            </thead>

                            <tbody>
                            @foreach($suppliers as $data)
                                <tr>
                                    <td class="p-4">{{$data->nama_supplier}}</td>
                                    <td class="p-4">{{$data->kode_supplier}}</td>
                                    <td class="p-4">{{$data->email}}</td>
                                    <td class="p-4">{{$data->kontak}}</td>
                                    <td class="p-4 flex gap-2">
                                        <button @click="showSupplierModal = true" class="action-btn bg-yellow-500 hover:bg-yellow-600 text-white p-2">
                                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-5 h-5"><path d="m2.695 14.762-1.262 3.155a.5.5 0 0 0 .65.65l3.155-1.262a4 4 0 0 0 1.343-.886L17.5 5.501a2.121 2.121 0 0 0-3-3L3.58 13.42a4 4 0 0 0-.885 1.343Z" /></svg>
                                        </button>
                                        <button class="action-btn bg-red-500 hover:bg-red-600 text-white p-2">
                                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-5 h-5"><path fill-rule="evenodd" d="M8.75 1A2.75 2.75 0 0 0 6 3.75v.443c-.795.077-1.58.11-2.368.11a.75.75 0 0 0-.75.75v1.5c0 .414.336.75.75.75h13.5a.75.75 0 0 0 .75-.75v-1.5a.75.75 0 0 0-.75-.75c-.788 0-1.573-.033-2.368-.11V3.75A2.75 2.75 0 0 0 14 1H8.75ZM6 6.443v-.693A1.25 1.25 0 0 1 7.25 4.5h5.5A1.25 1.25 0 0 1 14 5.75v.693c-1.12.08-2.288.11-3.5.11s-2.38-.03-3.5-.11Z" clip-rule="evenodd" /><path d="M5.25 9.75a.75.75 0 0 0-.75.75v6a.75.75 0 0 0 .75.75h9.5a.75.75 0 0 0 .75-.75v-6a.75.75 0 0 0-.75-.75h-9.5Z" /></svg>
                                        </button>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

                <div x-show="activeTab === 'karyawan'" x-transition.opacity.duration.300ms>
                    <div class="flex justify-between items-center mb-6">
                        <h2 class="text-2xl font-semibold">Manajemen Karyawan</h2>
                        <button @click="showKaryawanModal = true" class="action-btn bg-indigo-600 hover:bg-indigo-700 text-white px-5 py-2 flex items-center gap-2">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-5 h-5"><path d="M10.75 4.75a.75.75 0 0 0-1.5 0v4.5h-4.5a.75.75 0 0 0 0 1.5h4.5v4.5a.75.75 0 0 0 1.5 0v-4.5h4.5a.75.75 0 0 0 0-1.5h-4.5v-4.5Z" /></svg>
                            Tambah Karyawan
                        </button>
                    </div>

                    <div class="table-container shadow-lg">
                        <table class="w-full">
                            <thead>
                                <tr>
                                    <th class="p-4 text-left">Nama</th>
                                    <th class="p-4 text-left">Posisi</th>
                                    <th class="p-4 text-left">Email</th>
                                    <th class="p-4 text-left">Status</th>
                                    <th class="p-4 text-left">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($person as $karyawan)
                                <tr>
                                    <td class="p-4">{{$karyawan->name}}</td>
                                    <td class="p-4">{{$karyawan->role}}</td>
                                    <td class="p-4">{{$karyawan->email}}</td>
                                    <td class="p-4"><span class="status-badge status-active">Aktif</span></td>
                                    <td class="p-4 flex gap-2">
                                        <button @click="showGajiModal = true" class="action-btn bg-green-500 hover:bg-green-600 text-white p-2" title="Proses Gaji">
                                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-5 h-5"><path fill-rule="evenodd" d="M1 4a1 1 0 0 1 1-1h16a1 1 0 0 1 1 1v2.25a.75.75 0 0 1-1.5 0V5H2v1.25a.75.75 0 0 1-1.5 0V4ZM2.5 8.5A.75.75 0 0 1 3.25 8h13.5a.75.75 0 0 1 .75.75v6.5a.75.75 0 0 1-.75.75H3.25a.75.75 0 0 1-.75-.75v-6.5ZM3 9.25v5.5h14v-5.5H3Z" clip-rule="evenodd" /></svg>
                                        </button>
                                        <button class="action-btn bg-red-500 hover:bg-red-600 text-white p-2" title="Hapus Karyawan">
                                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-5 h-5"><path fill-rule="evenodd" d="M8.75 1A2.75 2.75 0 0 0 6 3.75v.443c-.795.077-1.58.11-2.368.11a.75.75 0 0 0-.75.75v1.5c0 .414.336.75.75.75h13.5a.75.75 0 0 0 .75-.75v-1.5a.75.75 0 0 0-.75-.75c-.788 0-1.573-.033-2.368-.11V3.75A2.75 2.75 0 0 0 14 1H8.75ZM6 6.443v-.693A1.25 1.25 0 0 1 7.25 4.5h5.5A1.25 1.25 0 0 1 14 5.75v.693c-1.12.08-2.288.11-3.5.11s-2.38-.03-3.5-.11Z" clip-rule="evenodd" /><path d="M5.25 9.75a.75.75 0 0 0-.75.75v6a.75.75 0 0 0 .75.75h9.5a.75.75 0 0 0 .75-.75v-6a.75.75 0 0 0-.75-.75h-9.5Z" /></svg>
                                        </button>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

                <div x-show="activeTab === 'invoice'" x-transition.opacity.duration.300ms>
                    <div class="flex justify-between items-center mb-6">
                        <h2 class="text-2xl font-semibold">Riwayat Transaksi</h2>
                    </div>

                    <div class="table-container shadow-lg">
                        <table class="w-full">
                            <thead>
                                <tr>
                                    <th class="p-4 text-left">ID Transaksi</th>
                                    <th class="p-4 text-left">Kasir</th>
                                    <th class="p-4 text-left">Tanggal</th>
                                    <th class="p-4 text-left">Total Bayar</th>
                                    <th class="p-4 text-left">Status</th>
                                    <th class="p-4 text-left">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($transactions as $transaksi)
                                <tr>
                                    <td class="p-4">{{$transaksi->transaction_code}}</td>
                                    <td class="p-4">
                                        {{$transaksi->user_id}}
                                    </td>
                                    <td class="p-4">{{$transaksi->transaction_date}}</td>
                                    <td class="p-4">{{number_format($transaksi->total_amount, 0, ',', '.')}}</td>
                                    <td class="p-4"><span class="badge bg-green-100 text-green-700">Lunas</span></td>
                                    <td class="p-4">
                                        <button class="action-btn bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 text-sm flex items-center gap-1">
                                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-5 h-5"><path fill-rule="evenodd" d="M5 2.5a.75.75 0 0 1 .75-.75h6.5a.75.75 0 0 1 .75.75v.5h1.75a3 3 0 0 1 3 3v9.5a3 3 0 0 1-3 3H5.25a3 3 0 0 1-3-3V6a3 3 0 0 1 3-3h1.75v-.5A.75.75 0 0 1 5 2.5ZM4.5 6a1.5 1.5 0 0 0-1.5 1.5v9.5a1.5 1.5 0 0 0 1.5 1.5h9.5a1.5 1.5 0 0 0 1.5-1.5V7.5a1.5 1.5 0 0 0-1.5-1.5H4.5Z" clip-rule="evenodd" /></svg>
                            Cetak
                                        </button>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

            </main>
        </div>
    </div>

    <div x-show="showProdukModal" @keydown.escape.window="showProdukModal = false" class="modal-overlay fixed inset-0 bg-black/30 flex items-center justify-center p-4 z-50" x-transition>
        <div @click.outside="showProdukModal = false" class="modal-content bg-white w-full max-w-lg p-8 shadow-xl">
            <h2 class="text-2xl font-semibold mb-6 gradient-text" x-text="isEditMode ? 'Edit Produk' : 'Tambah Produk Baru'"></h2>
            <form action="/productregister" method="POST" class="space-y-4">
                @csrf
                <div>
                    <label class="block text-sm font-medium text-gray-700">Nama Produk</label>
                    <input type="text" name="nama_produk" class="input-field w-full mt-1 p-3" placeholder="Misal: Laptop Core i9">
                </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">SKU</label>
                        <input type="text" name="kode_produk" class="input-field w-full mt-1 p-3" placeholder="LP-001">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Deskripsi</label>
                        <input type="text" name="description" class="input-field w-full mt-1 p-3" placeholder="Misal: Laptop Core i9">
                    </div>
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Harga Jual</label>
                        <input type="number" name="price" class="input-field w-full mt-1 p-3" placeholder="25000000">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">QTY</label>
                        <input type="number" name="qty" class="input-field w-full mt-1 p-3" placeholder="50">
                    </div>
                </div>
                
                <div class="flex justify-end gap-3 pt-4">
                    <button @click="showProdukModal = false" type="button" class="action-btn bg-gray-200 hover:bg-gray-300 text-gray-800 px-5 py-2">
                        Batal
                    </button>
                    <button type="submit" class="action-btn bg-indigo-600 hover:bg-indigo-700 text-white px-5 py-2">
                        Simpan
                    </button>
                </div>
            </form>
        </div>
    </div>

    <div x-show="showSupplierModal" @keydown.escape.window="showSupplierModal = false" class="modal-overlay fixed inset-0 bg-black/30 flex items-center justify-center p-4 z-50" x-transition>
        <div @click.outside="showSupplierModal = false" class="modal-content bg-white w-full max-w-lg p-8 shadow-xl">
            <h2 class="text-2xl font-semibold mb-6 gradient-text" x-text="isEditMode ? '' : 'Tambah Supplier Baru'"></h2>

            <form action="/suppliers" method="POST" class="space-y-4">
                @csrf
                <div>
                    <label class="block text-sm font-medium text-gray-700">Nama Supplier</label>
                    <input name="nama_supplier" type="text" class="input-field w-full mt-1 p-3" placeholder="PT. Global Teguh Indonesia">
                </div>
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Kode Supplier</label>
                        <input name="kode_supplier" type="text" class="input-field w-full mt-1 p-3" placeholder="LP-001">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">E-mail</label>
                        <input name="email" type="email" class="input-field w-full mt-1 p-3" placeholder="fachri@fachri.com">
                    </div>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">Kontak</label>
                    <input name="kontak" type="text" class="input-field w-full mt-1 p-3" placeholder="0851897287">
                </div>
                <div>
                    <textarea name="alamat"></textarea>
                </div>
                
                <div class="flex justify-end gap-3 pt-4">
                    <button @click="showSupplierModal = false" type="button" class="action-btn bg-gray-200 hover:bg-gray-300 text-gray-800 px-5 py-2">
                        Batal
                    </button>
                    <button type="submit" class="action-btn bg-indigo-600 hover:bg-indigo-700 text-white px-5 py-2">
                        Simpan
                    </button>
                </div>
            </form>
        </div>
    </div>

    <div x-show="showKaryawanModal" @keydown.escape.window="showKaryawanModal = false" class="modal-overlay fixed inset-0 bg-black/30 flex items-center justify-center p-4 z-50" x-transition>
        <div @click.outside="showKaryawanModal = false" class="modal-content bg-white w-full max-w-lg p-8 shadow-xl">
            <h2 class="text-2xl font-semibold mb-6 gradient-text" x-text="isEditMode ? 'Edit Karyawan' : 'Tambah Karyawan Baru'"></h2>
            <form action="/register" method="POST" class="space-y-4">
                @csrf
                <div>
                    <label class="block text-sm font-medium text-gray-700">Nama Karyawan</label>
                    <input name="name" type="text" class="input-field w-full mt-1 p-3">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">Jabatan
                    <input type="text" name="role" class="input-field w-full mt-1 p-3">
                    </select>
                </div>
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Email</label>
                        <input type="email" name="email" class="input-field w-full mt-1 p-3" placeholder="email@email.com">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Password</label>
                        <input type="text" name="password" class="input-field w-full mt-1 p-3" placeholder="50">
                    </div>
                </div>
                
                <div class="flex justify-end gap-3 pt-4">
                    <button @click="showKaryawanModal = false" type="button" class="action-btn bg-gray-200 hover:bg-gray-300 text-gray-800 px-5 py-2">
                        Batal
                    </button>
                    <button type="submit" class="action-btn bg-indigo-600 hover:bg-indigo-700 text-white px-5 py-2">
                        Simpan
                    </button>
                </div>
            </form>
        </div>
    </div>

    <div x-show="showGajiModal" @keydown.escape.window="showGajiModal = false" class="modal-overlay fixed inset-0 bg-black/30 flex items-center justify-center p-4 z-50" x-transition>
        <div @click.outside="showGajiModal = false" class="modal-content bg-white w-full max-w-md p-8 shadow-xl">
            <h2 class="text-2xl font-semibold mb-6 gradient-text">Proses Gaji Karyawan</h2>
            <form action="#" method="POST" class="space-y-4">
                @csrf
                <div>
                    <label class="block text-sm font-medium text-gray-700">Nama Karyawan</label>
                    <input type="text" class="input-field w-full mt-1 p-3 bg-gray-100" value="Andi Wijaya" readonly>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">Periode Gaji</label>
                    <input type="month" class="input-field w-full mt-1 p-3" value="{{ date('Y-m') }}">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">Gaji Pokok</label>
                    <input type="number" class="input-field w-full mt-1 p-3" placeholder="5000000">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">Bonus/Tunjangan</label>
                    <input type="number" class="input-field w-full mt-1 p-3" placeholder="500000">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">Potongan (PPh, dll)</label>
                    <input type="number" class="input-field w-full mt-1 p-3" placeholder="250000">
                </div>
                
                <div class="flex justify-end gap-3 pt-4">
                    <button @click="showGajiModal = false" type="button" class="action-btn bg-gray-200 hover:bg-gray-300 text-gray-800 px-5 py-2">
                        Batal
                    </button>
                    <button type="submit" class="action-btn bg-green-600 hover:bg-green-700 text-white px-5 py-2">
                        Bayar & Buat Slip
                    </button>
                </div>
            </form>
        </div>
    </div>
    
    <script>
        window.addEventListener('load', function() {
            const preloader = document.getElementById('preloader');
            // Tambahkan animasi keluar
            preloader.style.animation = 'stretchOut 0.5s ease forwards';
            // Sembunyikan setelah animasi selesai
            setTimeout(() => {
                preloader.style.display = 'none';
            }, 500);
        });
    </script>

</body>
</html>