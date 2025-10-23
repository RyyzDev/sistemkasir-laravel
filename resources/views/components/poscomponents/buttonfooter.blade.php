 <!-- Footer - PENTING: Harus dalam scope x-data yang sama -->
      <div class="bottom-menu flex text-white text-sm font-semibold">
        <button @click="tab = 'produk'" :class="tab === 'produk' ? 'active' : ''" class="menu-item flex-1">
          📦 Produk
        </button>
        <button @click="tab = 'supplier'" :class="tab === 'supplier' ? 'active' : ''" class="menu-item flex-1">
          🚚 Supplier
        </button>
        <button @click="tab = 'stock'" :class="tab === 'stock' ? 'active' : ''" class="menu-item flex-1">
          📊 Stock
        </button>
      </div>