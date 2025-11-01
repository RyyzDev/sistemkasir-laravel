<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Sistem Kasir</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="{{asset('css/style.css')}}">
</head>
<body class="min-h-screen flex items-center justify-center bg-gradient-to-br from-indigo-500 via-purple-600 to-pink-500">
    <div class="w-full max-w-md bg-white rounded-2xl shadow-2xl overflow-hidden">
        <!-- Header -->
        <div class="bg-gradient-to-r from-indigo-600 to-purple-600 p-6 text-center">
            <h1 class="text-2xl md:text-3xl font-bold text-white">Sistem Kasir</h1>
            <p class="text-sm text-indigo-100 mt-1">Silakan login untuk melanjutkan</p>
            <p class="text-sm text-indigo-100 mt-1">GUNAKAN AKUN INI!:</p>
            <p class="text-sm text-indigo-100 mt-1">
                email       : admin@admin.com <br>
                password    : admin1234
            </p>
        </div>



@if ($errors->any())
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <ul class="mb-0">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif


        <!-- Form -->
        <div class="p-8">
         <form action="/login" method="POST" class="space-y-6">
                @csrf
                <!-- Email -->
                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                    <input type="email" id="email" name="email" required autofocus
                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:outline-none text-gray-700">
                </div>

                <!-- Password -->
                <div>
                    <label for="password" class="block text-sm font-medium text-gray-700 mb-1">Password</label>
                    <input type="password" id="password" name="password" required
                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:outline-none text-gray-700">
                </div>

                <!-- Submit -->
                <div>
                    <button type="submit"
                            class="w-full bg-gradient-to-r from-indigo-600 to-purple-600 text-white font-semibold py-3 rounded-lg shadow-md hover:opacity-90 transition duration-300">
                        Masuk
                    </button>
                </div>
                <div class="mt-auto">
                     <a href="/register"
                            class="w-full bg-gradient-to-r from-white-600 to-blue-600 text-white font-semibold py-3 rounded-lg shadow-md hover:opacity-90 transition duration-300">
                        Belum Punya Akun? Daftar Disini!
                    </a>
                </div>
            </form>
        </div>

        <!-- Footer -->
        <div class="bg-gray-50 text-center p-4 text-sm text-gray-500">
            &copy;2025 <a href="https://github.com/RyyzDev" target="__blank">RyyzDev</a> - All Rights Reserved
        </div>
    </div>
    <script src="{{asset('js/script.js')}}"></script>
</body>
</html>
