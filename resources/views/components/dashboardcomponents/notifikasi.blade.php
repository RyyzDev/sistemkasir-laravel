{{-- Notifikasi Sukses--}}
@if(session()->has('success'))
<div x-data="{ open: true }" x-show="open" 
     x-transition:enter="transition ease-out duration-300 transform origin-top-right"
     x-transition:enter-start="opacity-0 scale-90"
     x-transition:enter-end="opacity-100 scale-100"
     x-transition:leave="transition ease-in duration-300 transform origin-top-right"
     x-transition:leave-start="opacity-100 scale-100"
     x-transition:leave-end="opacity-0 scale-90"
     x-init="setTimeout(() => { open = false }, 5000)" 
     
     class="fixed top-5 right-5 bg-green-500 text-white p-5 rounded-lg shadow-xl z-50 text-lg">
    <div class="flex items-center justify-between">
        <p>{{ session('success') }}</p>
        <button @click="open = false" class="ml-4 text-white hover:text-green-800 font-bold text-xl">&times;</button>
    </div>
</div>
@endif

{{-- Notifikasi Error--}}
@if(session()->has('error'))
<div x-data="{ open: true }" x-show="open" 
     x-transition:enter="transition ease-out duration-300 transform origin-top-right"
     x-transition:enter-start="opacity-0 scale-90"
     x-transition:enter-end="opacity-100 scale-100"
     x-transition:leave="transition ease-in duration-300 transform origin-top-right"
     x-transition:leave-start="opacity-100 scale-100"
     x-transition:leave-end="opacity-0 scale-90"
     x-init="setTimeout(() => { open = false }, 5000)" 
     
     class="fixed top-5 right-5 bg-red-500 text-white p-5 rounded-lg shadow-xl z-50 text-lg">
    <div class="flex items-center justify-between">
        <p>{{ session('error') }}</p>
        <button @click="open = false" class="ml-4 text-white hover:text-red-800 font-bold text-xl">&times;</button>
    </div>
</div>
@endif