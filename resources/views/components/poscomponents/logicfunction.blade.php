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

        get searchResults() {
            if (this.searchQuery === '') {
                return this.products;
            }
            return this.products.filter(p => 
                p.nama.toLowerCase().includes(this.searchQuery.toLowerCase())
            );
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
                    nama: product.nama,
                    kode: product.kode,
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
                'Accept': 'application/json'  // TAMBAHKAN INI
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
        }
    }">