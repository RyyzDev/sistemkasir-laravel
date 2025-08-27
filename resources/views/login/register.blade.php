<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>register Sistem Kasir</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="{{asset('css/style.css')}}">
</head>
<body class="min-h-screen flex items-center justify-center bg-gradient-to-br from-indigo-500 via-purple-600 to-pink-500">
 <div id="preloader">
    <img src="{{asset('images/fachri.jpg')}}" alt="Logo" id="preloader-img">
    <h2 class="text-2xl md:text-3xl font-bold text-black">SISTEM KASIR</h2>
    <h4 class="text-sm text-black-100 mt-1">Tunggu sebentar!</h4>
    <div class="dots">
      <div class="dot"></div>
      <div class="dot"></div>
      <div class="dot"></div>
    </div>
  </div>
    <div class="w-full max-w-md bg-white rounded-2xl shadow-2xl overflow-hidden">
        <!-- Header -->
        <div class="bg-gradient-to-r from-indigo-600 to-purple-600 p-6 text-center">
            <h1 class="text-2xl md:text-3xl font-bold text-white">Sistem Kasir</h1>
            <p class="text-sm text-indigo-100 mt-1">Silakan daftar untuk melanjutkan</p>
        </div>

        <!-- Form -->
        <div class="p-8">
         <form action="" method="POST" class="space-y-6">
                @csrf
                 <!-- Email -->
                <div>
                    <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Nama Lengkap</label>
                    <input type="text" id="name" name="name" required autofocus
                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:outline-none text-gray-700">
                </div>


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
                <button type="submit"
                        class="w-full bg-gradient-to-r from-indigo-600 to-purple-600 text-white font-semibold py-3 rounded-lg shadow-md hover:opacity-90 transition duration-300">
                    Register
                </button>
            </form>

              <div class="bg-gray-50 text-center p-4 text-sm text-red-500">
           cuma uji coba, langsung Login aja pakai akun yang di sediakan yaa!
        </div>
        </div>

        <!-- Footer -->
        <div class="bg-gray-50 text-center p-4 text-sm text-gray-500">
            &copy;  RyyzDev - All Rights Reserved
        </div>
    </div>
    <script src="{{asset('js/script.js')}}"></script>
</body>
</html>
