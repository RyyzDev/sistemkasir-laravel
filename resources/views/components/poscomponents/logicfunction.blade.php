<!-- Main Content -->
      <div class="flex-1 overflow-hidden flex flex-col" x-data="{
        tab: 'produk',
        cartItems: [],
        modal: '',
        searchQuery: '',
        showSuccess: false,
        totalBayar: 0,
        kembalian: 0,
        products: {{ Js::from($products) }},
        deskripsi: [''],
        reportPeriod: 'hari',
        selectedMonth: new Date().getMonth(),
        selectedYear: new Date().getFullYear(),
        charts: {},

        get searchResults() {
            if (this.searchQuery === '') {
                return this.products;
            }
            return this.products.filter(p => 
                p.nama.toLowerCase().includes(this.searchQuery.toLowerCase())
            );
        },

      salesData: [],

      exportToCSV() {
        let csvContent = 'data:text/csv;charset=utf-8,';
        
        // Tambahkan header
        const headers = ['Tanggal', 'Produk', 'Qty', 'Total', 'Metode'];
        csvContent += headers.join(',') + '\n';

        // Tambahkan baris data
        this.salesData.forEach(sale => {
            const row = [
                new Date(sale.date).toLocaleDateString('id-ID'),
                sale.product,
                sale.quantity,
                sale.total, // Mungkin perlu penyesuaian jika Anda ingin nilai mentah tanpa format rupiah
                sale.method
            ].join(',');
            csvContent += row + '\n';
        });

        // Buat tautan unduhan
        const encodedUri = encodeURI(csvContent);
        const link = document.createElement('a');
        link.setAttribute('href', encodedUri);
        link.setAttribute('download', 'detail_transaksi.csv');
        document.body.appendChild(link);
        link.click();
        document.body.removeChild(link);
      },

      get searchResults() {
          if (this.searchQuery === '') {
              return this.products;
          }
          return this.products.filter(p => 
              p.nama.toLowerCase().includes(this.searchQuery.toLowerCase())
          );
      },
      
      getTotalSales() {
        return this.salesData.reduce((sum, sale) => sum + sale.total, 0);
      },
      
      getTotalTransactions() {
        return this.salesData.length;
      },
      
      getAverageTransaction() {
        return this.getTotalTransactions() > 0 ? Math.round(this.getTotalSales() / this.getTotalTransactions()) : 0;
      },
      
      getDailySalesData() {
        const groupedData = {};
        this.salesData.forEach(sale => {
          if (!groupedData[sale.date]) {
            groupedData[sale.date] = 0;
          }
          groupedData[sale.date] += sale.total;
        });
        return groupedData;
      },
      
      getProductSalesData() {
        const groupedData = {};
        this.salesData.forEach(sale => {
          if (!groupedData[sale.product]) {
            groupedData[sale.product] = 0;
          }
          groupedData[sale.product] += sale.total;
        });
        return groupedData;
      },
      
      getPaymentMethodData() {
        const groupedData = {};
        this.salesData.forEach(sale => {
          if (!groupedData[sale.method]) {
            groupedData[sale.method] = 0;
          }
          groupedData[sale.method] += sale.total;
        });
        return groupedData;
      },
      
      async fetchSalesData() {
        try {
          const params = new URLSearchParams({
            period: this.reportPeriod,
            month: parseInt(this.selectedMonth) + 1,
            year: this.selectedYear
          });
          
          const response = await fetch(`{{ route('sales.report') }}?${params}`, {
            method: 'GET',
            headers: {
              'Content-Type': 'application/json',
              'Accept': 'application/json',
              'X-CSRF-TOKEN': document.querySelector('meta[name=csrf-token]').content
            }
          });
          
          if (!response.ok) {
            throw new Error('Gagal mengambil data');
          }
          
          const data = await response.json();
          
          if (data.success && data.sales) {
            this.salesData = data.sales;
          }
          
          this.initCharts();
          
        } catch (error) {
          console.error('Error fetching sales data:', error);
          alert('Gagal memuat data laporan. Menggunakan data dummy.');
          this.salesData = [
            { date: '2024-10-01', product: 'Produk 1', quantity: 5, total: 250000, method: 'Cash' },
            { date: '2024-10-02', product: 'Produk 2', quantity: 3, total: 225000, method: 'QRIS' },
            { date: '2024-10-03', product: 'Produk 3', quantity: 2, total: 200000, method: 'Cash' },
          ];
          this.initCharts();
        }
      },
      
      initCharts() {
        this.$nextTick(() => {
          this.drawBarChart();
          this.drawLineChart();
          this.drawPieChart();
        });
      },
      
      drawBarChart() {
        const ctx = document.getElementById('barChart');
        if (!ctx) return;
        
        if (this.charts.bar) {
          this.charts.bar.destroy();
        }
        
        const productData = this.getProductSalesData();
        this.charts.bar = new Chart(ctx, {
          type: 'bar',
          data: {
            labels: Object.keys(productData),
            datasets: [{
              label: 'Penjualan per Produk',
              data: Object.values(productData),
              backgroundColor: [
                'rgba(102, 126, 234, 0.8)',
                'rgba(118, 75, 162, 0.8)',
                'rgba(244, 63, 94, 0.8)',
              ],
              borderColor: [
                'rgba(102, 126, 234, 1)',
                'rgba(118, 75, 162, 1)',
                'rgba(244, 63, 94, 1)',
              ],
              borderWidth: 2,
              borderRadius: 8,
            }]
          },
          options: {
            responsive: true,
            maintainAspectRatio: true,
            plugins: {
              legend: {
                display: true,
                position: 'top',
              }
            },
            scales: {
              y: {
                beginAtZero: true,
                ticks: {
                  callback: function(value) {
                    return 'Rp ' + value.toLocaleString('id-ID');
                  }
                }
              }
            }
          }
        });
      },


      
      drawLineChart() {
        const ctx = document.getElementById('lineChart');
        if (!ctx) return;
        
        if (this.charts.line) {
          this.charts.line.destroy();
        }
        
        const dailyData = this.getDailySalesData();
        this.charts.line = new Chart(ctx, {
          type: 'line',
          data: {
            labels: Object.keys(dailyData).sort(),
            datasets: [{
              label: 'Penjualan Harian',
              data: Object.keys(dailyData).sort().map(date => dailyData[date]),
              borderColor: 'rgba(102, 126, 234, 1)',
              backgroundColor: 'rgba(102, 126, 234, 0.1)',
              borderWidth: 3,
              fill: true,
              tension: 0.4,
              pointBackgroundColor: 'rgba(102, 126, 234, 1)',
              pointBorderColor: '#fff',
              pointBorderWidth: 2,
              pointRadius: 5,
              pointHoverRadius: 7,
            }]
          },
          options: {
            responsive: true,
            maintainAspectRatio: true,
            plugins: {
              legend: {
                display: true,
                position: 'top',
              }
            },
            scales: {
              y: {
                beginAtZero: true,
                ticks: {
                  callback: function(value) {
                    return 'Rp ' + value.toLocaleString('id-ID');
                  }
                }
              }
            }
          }
        });
      },
      
      drawPieChart() {
        const ctx = document.getElementById('pieChart');
        if (!ctx) return;
        
        if (this.charts.pie) {
          this.charts.pie.destroy();
        }
        
        const methodData = this.getPaymentMethodData();
        this.charts.pie = new Chart(ctx, {
          type: 'doughnut',
          data: {
            labels: Object.keys(methodData),
            datasets: [{
              data: Object.values(methodData),
              backgroundColor: [
                'rgba(102, 126, 234, 0.8)',
                'rgba(118, 75, 162, 0.8)',
                'rgba(244, 63, 94, 0.8)',
                'rgba(16, 185, 129, 0.8)',
              ],
              borderColor: [
                'rgba(102, 126, 234, 1)',
                'rgba(118, 75, 162, 1)',
                'rgba(244, 63, 94, 1)',
                'rgba(16, 185, 129, 1)',
              ],
              borderWidth: 2,
            }]
          },
          options: {
            responsive: true,
            maintainAspectRatio: true,
            plugins: {
              legend: {
                display: true,
                position: 'bottom',
              }
            }
          }
        });
      },


        addToCart(product) {
            const existingItem = this.cartItems.find(item => item.id === product.id);
            if (existingItem) {
                if (existingItem.quantity < product.qty) {
                    existingItem.quantity += 1;
                    existingItem.subtotal = existingItem.quantity * existingItem.price;
                } else {
                    alert('Quantity melebihi stok yang tersedia!');
                    return;
                }
            } else {
                this.cartItems.push({
                    id: product.id,
                    nama: product.nama_produk,
                    kode: product.kode_produk,
                    price: product.price,
                    quantity: 1,
                    subtotal: product.price,
                    maxStock: product.qty
                });
            }

            this.modal = '';
        },
        updateQuantity(itemId, newQty) {
            const item = this.cartItems.find(i => i.id === itemId);
            if (item) {
                if (newQty <= 0) {
                    this.removeFromCart(itemId);
                } else if (newQty <= item.maxStock) {
                    item.quantity = parseInt(newQty);
                    item.subtotal = item.quantity * item.price;
                } else {
                    alert('Quantity melebihi stok yang tersedia!');
                }
            }
        },
        removeFromCart(itemId) {
            this.cartItems = this.cartItems.filter(item => item.id !== itemId);
        },
        getTotal() {
            return this.cartItems.reduce((total, item) => total + item.subtotal, 0);
        },

        async prosesPembayaran() {
    const total = this.getTotal();
    if (this.totalBayar < total) {
        alert('Jumlah bayar kurang dari total!');
        return;
    }
    this.kembalian = this.totalBayar - total;
    
    const paymentMethodSelect = document.querySelector('select[name=payment_method]');
    const paymentMethod = paymentMethodSelect ? paymentMethodSelect.value : 'Cash';
    
    const items = this.cartItems.map(item => ({
        id: item.id,
        quantity: item.quantity
    }));
    
    try {
        const csrfToken = document.querySelector('meta[name=csrf-token]');
        const response = await fetch('/transactions', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': csrfToken ? csrfToken.content : '',
                'Accept': 'application/json'
            },
            body: JSON.stringify({
                items: items,
                payment_method: paymentMethod,
                amount_paid: this.totalBayar
            })
        });
        
        // CEK APAKAH RESPONSE BENAR-BENAR JSON
        const contentType = response.headers.get('content-type');
        if (!contentType || !contentType.includes('application/json')) {
            const textResponse = await response.text();
            console.error('Response bukan JSON:', textResponse);
            alert('Server error: Response tidak valid. Cek console untuk detail.');
            return;
        }
        
        const result = await response.json();
        
        if (result.success) {
            this.showSuccess = true;
            this.products = this.products.map(p => {
                const cartItem = this.cartItems.find(ci => ci.id === p.id);
                if (cartItem) {
                    return { ...p, qty: p.qty - cartItem.quantity };
                }
                return p;
            });
        } else {
            alert('Transaksi gagal: ' + result.message);
        }
    } catch (error) {
        console.error('Error detail:', error);
        alert('Terjadi kesalahan: ' + error.message);
    }
},
        formatRupiah(amount) {
            return new Intl.NumberFormat('id-ID', { 
                style: 'currency', 
                currency: 'IDR', 
                minimumFractionDigits: 0, 
                maximumFractionDigits: 0 
            }).format(amount);
        },
        clearTransaction() {
            if (confirm('Apakah Anda yakin ingin membatalkan semua transaksi?')) {
                this.cartItems = [];
                this.modal = '';
            }
        },
        successClearTransaction(){
          this.cartItems = [];
          this.modal = '';
          this.totalBayar = 0;
          this.kembalian = 0;
        },
        printStruk() {
            // Kita cetak elemen di modal (dengan ID 'printArea')
            window.print();
        },
    }">