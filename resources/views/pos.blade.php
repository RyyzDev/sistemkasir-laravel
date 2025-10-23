<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>Kasir v2</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <script src="//unpkg.com/alpinejs" defer></script>
  <link rel="stylesheet" href="{{asset('css/style.css')}}">
</head>
<body>
  <div class="max-w-7xl mx-auto my-6">
    <div class="app-container" style="height: 95vh; display: flex; flex-direction: column;">
      
      <!-- Header -->
      <div class="top-bar px-8 py-4 flex justify-between items-center">
        <div class="flex items-center gap-3">
          <div class="w-12 h-12 bg-gradient-to-br from-purple-400 to-pink-500 rounded-lg flex items-center justify-center shadow-lg">
            <span class="text-white font-bold text-xl">R</span>
          </div>
          <div>
            <h1 class="text-white font-bold text-xl">Sistem Kasir</h1>
            <p class="text-gray-300 text-xs">By: Ryyz Developer</p>
          </div>
        </div>

        <div class="text-right text-gray-300 text-sm">
          <p id="current-time" class="text-white font-semibold"></p>
          <p class="text-xs">Welcome</p>
        </div>
      </div>

      @include('components.poscomponents.logicfunction')

     @include('components.poscomponents.tabpos')

    @include('components.poscomponents.popupmodal')

     @include('components.poscomponents.buttonfooter')
    </div>
  </div>
        

  <script>
    function updateTime() {
      const now = new Date();
      document.getElementById('current-time').textContent = now.toLocaleTimeString('id-ID', {
        hour: '2-digit',
        minute: '2-digit',
        second: '2-digit'
      });
    }
    updateTime();
    setInterval(updateTime, 1000);
  </script>
</body>
</html>