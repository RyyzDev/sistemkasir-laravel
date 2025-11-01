      <!-- Tab Laporan -->
       <div x-show="activeTab === 'laporan'" x-init="if (activeTab === 'laporan') fetchSalesData()" class="space-y-6">
          <div>
            <h2 class="text-3xl font-bold gradient-text mb-2">📊 Laporan Penjualan</h2>
            <p class="text-gray-500">Analisis dan laporan penjualan lengkap</p>
          </div>


          <!-- Filter Periode -->
          <div class="card p-6">
            <div class="flex gap-4 flex-wrap items-center">
              <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">Periode</label>
                <select x-model="reportPeriod" @change="fetchSalesData()" class="input-field px-4 py-2">
                  <option value="hari" selected>Hari Ini</option>
                  <option value="minggu">7 Hari Terakhir</option>
                  <option value="bulan">Perbulan</option>
                  <option value="tahun">Pertahun</option>
                </select>
              </div>
              <div x-show="reportPeriod === 'bulan'">
                <label class="block text-sm font-semibold text-gray-700 mb-2">Bulan</label>
                <select x-model="selectedMonth" @change="fetchSalesData()" class="input-field px-4 py-2">
                  <option value="0">Januari</option>
                  <option value="1">Februari</option>
                  <option value="2">Maret</option>
                  <option value="3">April</option>
                  <option value="4">Mei</option>
                  <option value="5">Juni</option>
                  <option value="6">Juli</option>
                  <option value="7">Agustus</option>
                  <option value="8">September</option>
                  <option value="9">Oktober</option>
                  <option value="10">November</option>
                  <option value="11">Desember</option>
                </select>
              </div>
              <div x-show="reportPeriod != 'hari' && reportPeriod != 'minggu'">
                <label class="block text-sm font-semibold text-gray-700 mb-2">Tahun</label>
                <select x-model="selectedYear" @change="fetchSalesData()" class="input-field px-4 py-2">
                  <option value="2024">2024</option>
                  <option value="2025">2025</option>
                </select>
              </div>
              <div class="ml-auto">
                <label class="block text-sm font-semibold text-gray-700 mb-2">&nbsp;</label>
                <button @click="window.location.reload();" class="action-btn px-6 py-2 bg-gradient-to-r from-blue-500 to-blue-600 text-white font-semibold rounded-lg shadow-lg hover:shadow-xl">
                  🔄 Refresh Data
                </button>
              </div>
            </div>
          </div>

          <!-- Kartu Statistik -->
          <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
            <div class="stat-card success">
              <h3>Total Penjualan</h3>
              <div class="value" x-text="formatRupiah(getTotalSales())"></div>
              <p class="text-sm mt-2">📈 Periode terpilih</p>
            </div>
            
            <div class="stat-card info">
              <h3>Total Transaksi</h3>
              <div class="value" x-text="getTotalTransactions()"></div>
              <p class="text-sm mt-2">🛒 Transaksi berhasil</p>
            </div>
            
            <div class="stat-card warning">
              <h3>Rata-rata Transaksi</h3>
              <div class="value" x-text="formatRupiah(getAverageTransaction())"></div>
              <p class="text-sm mt-2">💰 Per transaksi</p>
            </div>
            
            <div class="stat-card danger">
              <h3>Produk Terjual</h3>
              <div class="value" x-text="salesData.reduce((sum, s) => sum + s.quantity, 0)"></div>
              <p class="text-sm mt-2">📦 Total item</p>
            </div>
          </div>

          <!-- Grafik -->
          <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            <!-- Line Chart -->
            <div class="card p-6">
              <h3 class="text-lg font-bold text-gray-800 mb-4">📈 Tren Penjualan Harian</h3>
              <div style="position: relative; height: 300px;">
                <canvas id="lineChart"></canvas>
              </div>
            </div>

            <!-- Bar Chart -->
            <div class="card p-6">
              <h3 class="text-lg font-bold text-gray-800 mb-4">📊 Penjualan per Produk</h3>
              <div style="position: relative; height: 300px;">
                <canvas id="barChart"></canvas>
              </div>
            </div>
          </div>

          <!-- Pie Chart & Top Products -->
          <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            <!-- Pie Chart -->
            <div class="card p-6">
              <h3 class="text-lg font-bold text-gray-800 mb-4">🥧 Metode Pembayaran</h3>
              <div style="position: relative; height: 100%;">
                <canvas id="pieChart"></canvas>
              </div>
            </div>

            <!-- Top Products -->
            <div class="card p-6">
              <h3 class="text-lg font-bold text-gray-800 mb-4">🏆 Produk Terlaris</h3>
              <div class="space-y-4">
                <template x-for="(product, index) in Object.entries(getProductSalesData()).sort((a,b) => b[1] - a[1]).slice(0, 5)" :key="index">
                  <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                    <div class="flex items-center gap-3">
                      <div class="w-8 h-8 rounded-full bg-gradient-to-br from-purple-400 to-pink-500 flex items-center justify-center text-white font-bold text-sm" x-text="index + 1"></div>
                      <span class="font-semibold text-gray-800" x-text="product[0]"></span>
                    </div>
                    <span class="font-bold text-purple-600" x-text="formatRupiah(product[1])"></span>
                  </div>
                </template>
              </div>
            </div>
          </div>

          <!-- Tabel Detail Transaksi -->
          <div class="card overflow-hidden">
            <div class="p-6 border-b border-gray-200 flex justify-between items-center">
              <h3 class="text-xl font-bold text-gray-800">📋 Detail Transaksi</h3>
              <button @click="exportToCSV()" class="action-btn px-4 py-2 bg-gradient-to-r from-green-500 to-green-600 text-white font-semibold rounded-lg shadow-lg hover:shadow-xl">
                📥 Export Excel
              </button>
            </div>
            <div class="table-container">
              <table class="w-full text-sm">
                <thead>
                  <tr>
                    <th class="py-4 px-6 text-left font-semibold">Tanggal</th>
                    <th class="py-4 px-6 text-left font-semibold">Produk</th>
                    <th class="py-4 px-6 text-center font-semibold">Qty</th>
                    <th class="py-4 px-6 text-right font-semibold">Total</th>
                    <th class="py-4 px-6 text-center font-semibold">Metode</th>
                  </tr>
                </thead>
                <tbody>
                  <template x-for="sale in salesData" :key="sale.date + sale.product">
                    <tr>
                      <td class="py-4 px-6 text-gray-600" x-text="new Date(sale.date).toLocaleDateString('id-ID')"></td>
                      <td class="py-4 px-6 font-semibold text-gray-800" x-text="sale.product"></td>
                      <td class="py-4 px-6 text-center" x-text="sale.quantity"></td>
                      <td class="py-4 px-6 text-right font-bold text-purple-600" x-text="formatRupiah(sale.total)"></td>
                      <td class="py-4 px-6 text-center">
                        <span class="badge" 
                          :class="{
                            'bg-green-100 text-green-700': sale.method === 'Cash',
                            'bg-blue-100 text-blue-700': sale.method === 'QRIS',
                            'bg-purple-100 text-purple-700': sale.method === 'Debit'
                          }"
                          x-text="sale.method"></span>
                      </td>
                    </tr>
                  </template>
                  <tr x-show="salesData.length === 0">
                    <td colspan="5" class="py-12 text-center">
                      <div class="flex flex-col items-center text-gray-400">
                        <div class="text-5xl mb-3">📊</div>
                        <p class="font-semibold">Belum ada data</p>
                        <p class="text-sm">Pilih periode untuk melihat laporan</p>
                      </div>
                    </td>
                  </tr>
                </tbody>
              </table>
            </div>
          </div>
        </div>