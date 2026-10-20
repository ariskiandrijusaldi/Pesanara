<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Self-Order - HQ Coffee &amp; Bites</title>

        <script>document.documentElement.classList.add('js');</script>

        @fonts
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
        @vite(['resources/css/app.css', 'resources/js/app.js'])

        <style>
            .scrollbar-none {
                -ms-overflow-style: none;
                scrollbar-width: none;
            }

            .scrollbar-none::-webkit-scrollbar {
                display: none;
            }

            .hq-toast {
                position: fixed;
                bottom: 1.5rem;
                left: 50%;
                transform: translateX(-50%) translateY(1rem);
                background: #111827;
                color: #fff;
                font-size: 11px;
                font-weight: 600;
                padding: 0.65rem 1.1rem;
                border-radius: 0.75rem;
                box-shadow: 0 10px 25px rgba(17, 24, 39, 0.25);
                opacity: 0;
                pointer-events: none;
                transition: opacity 0.25s ease, transform 0.25s ease;
                z-index: 80;
                max-width: 90vw;
                text-align: center;
            }

            .hq-toast.is-show {
                opacity: 1;
                transform: translateX(-50%) translateY(0);
            }
        </style>
    </head>

    <body class="bg-indigo-50/30 text-gray-800 font-sans">

        <header class="site-header sticky top-0 z-50 bg-white border-b border-gray-100 px-4 sm:px-8 py-4 flex flex-wrap justify-between items-center gap-3">
            <div class="flex items-center space-x-3">
                <div class="bg-black text-white p-2 rounded-lg font-bold text-sm tracking-wider">HQ</div>
                <span class="font-bold text-lg text-gray-900">HQ Coffee &amp; Bites</span>
            </div>
            <nav class="hidden md:flex space-x-8 text-sm font-medium text-gray-600">
                <a href="{{ url('/landing') }}" class="text-indigo-600 font-semibold">Beranda</a>
                <a href="#" class="hover:text-indigo-600">Profil Cafe</a>
                <a href="#menu-grid" class="hover:text-indigo-600">Menu</a>
                <a href="#cara-pesan" class="hover:text-indigo-600">Cara Pesan</a>
                <a href="#" class="hover:text-indigo-600">Lokasi</a>
            </nav>
            <button id="btn-mulai-pesan" type="button" class="bg-indigo-600 text-white px-5 py-2.5 rounded-xl font-medium text-sm hover:bg-indigo-700 transition">
                <i class="fa-solid font-bold fa-qrcode mr-2"></i> Mulai Pesan
            </button>
        </header>

        <div class="max-w-7xl mx-auto p-4 sm:p-6 grid grid-cols-1 lg:grid-cols-3 gap-8">

            <div class="lg:col-span-2 space-y-6">

                <div class="bg-white rounded-2xl p-5 shadow-sm border border-indigo-50 flex flex-wrap items-center justify-between gap-4">
                    <div class="flex items-center space-x-4">
                        <div class="bg-indigo-100 text-indigo-700 p-3 rounded-2xl text-center min-w-[60px]">
                            <span class="text-xs uppercase font-semibold block">MEJA</span>
                            <span class="text-2xl font-black">01</span>
                        </div>
                        <div>
                            <div class="flex items-center space-x-2">
                                <h2 class="text-xl font-bold text-gray-900">Self-Order HQ Coffee</h2>
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-emerald-100 text-emerald-800">
                                    <span class="w-1.5 h-1.5 bg-emerald-500 rounded-full mr-1.5"></span> Dine-In Aktif
                                </span>
                            </div>
                            <p class="text-xs text-gray-500 mt-1">Pesan menu favorit langsung dari ponsel atau tablet meja Anda tanpa perlu antre.</p>
                        </div>
                    </div>
                    <div class="hidden sm:flex items-center space-x-3">
                        <div class="relative">
                            <i class="fa-solid fa-magnifying-glass absolute left-3 top-3 text-gray-400 text-sm"></i>
                            <input id="menu-search" type="text" placeholder="Cari kopi, pastry, rice bowl..."
                                class="pl-9 pr-4 py-2 bg-gray-50 border border-gray-200 rounded-xl text-sm w-64 focus:outline-none focus:ring-2 focus:ring-indigo-500">
                        </div>
                        <div class="bg-indigo-50 text-indigo-700 px-3 py-2 rounded-xl text-xs font-medium flex items-center">
                            <i class="fa-regular fa-clock mr-1.5"></i> Estimasi: 10-15 Menit
                        </div>
                    </div>
                </div>

                <div id="kategori-bar" class="flex space-x-2 overflow-x-auto pb-2 scrollbar-none">
                    <button type="button" data-filter="semua" class="kategori-btn bg-indigo-600 text-white px-4 py-2 rounded-xl text-sm font-medium whitespace-nowrap">Semua Menu</button>
                    <button type="button" data-filter="signature" class="kategori-btn bg-white text-gray-600 hover:bg-gray-50 px-4 py-2 rounded-xl text-sm font-medium border border-gray-100 whitespace-nowrap">Signature Coffee</button>
                    <button type="button" data-filter="noncoffee" class="kategori-btn bg-white text-gray-600 hover:bg-gray-50 px-4 py-2 rounded-xl text-sm font-medium border border-gray-100 whitespace-nowrap">Non-Coffee &amp; Tea</button>
                    <button type="button" data-filter="pastry" class="kategori-btn bg-white text-gray-600 hover:bg-gray-50 px-4 py-2 rounded-xl text-sm font-medium border border-gray-100 whitespace-nowrap">Artisanal Bites &amp; Pastry</button>
                    <button type="button" data-filter="main" class="kategori-btn bg-white text-gray-600 hover:bg-gray-50 px-4 py-2 rounded-xl text-sm font-medium border border-gray-100 whitespace-nowrap">Main Course</button>
                </div>

                <div class="bg-gradient-to-r from-indigo-600 to-indigo-500 rounded-2xl p-6 text-white shadow-md flex flex-wrap justify-between items-center gap-4 relative overflow-hidden">
                    <div class="z-10 max-w-md">
                        <span class="bg-white/20 text-white text-xs px-3 py-1 rounded-full font-semibold uppercase tracking-wider">Combo Hemat Meja</span>
                        <h3 class="text-xl font-bold mt-2">Paket Siang: Kopi Aren + Rice Bowl Ayam Teriyaki</h3>
                        <p class="text-xs text-indigo-100 mt-1">Dapatkan potongan Rp 7.000 otomatis untuk pemesanan kombinasi kopi dan makanan utama.</p>
                    </div>
                    <button id="btn-tambah-combo" type="button" class="z-10 bg-white text-indigo-600 font-bold px-4 py-2.5 rounded-xl text-xs shadow hover:bg-indigo-50 transition">
                        + Tambah Combo (Rp 50.000)
                    </button>
                </div>

                <div id="menu-grid" class="grid grid-cols-1 sm:grid-cols-2 gap-4">

                    <div class="menu-card bg-white rounded-2xl p-4 border border-gray-100 shadow-sm flex flex-col justify-between" data-category="signature" data-nama="Kopi Susu Aren HQ">
                        <div class="flex space-x-3">
                            <div class="relative">
                                <img src="https://via.placeholder.com/100" class="w-24 h-24 rounded-xl object-cover" alt="Kopi Susu">
                                <span class="absolute top-1 left-1 bg-indigo-600 text-white text-[10px] px-1.5 py-0.5 rounded font-semibold">BEST SELLER</span>
                            </div>
                            <div class="flex-1">
                                <h4 class="font-bold text-gray-900 text-sm">Kopi Susu Aren HQ</h4>
                                <p class="text-xs text-gray-500 mt-1 line-clamp-2">Double espresso blend Mandheling &amp; Kerinci dengan gula aren organik...</p>
                                <div class="mt-2 flex space-x-1">
                                    <span class="bg-gray-100 text-gray-600 text-[10px] px-2 py-0.5 rounded-md font-medium">SIGNATURE</span>
                                    <span class="bg-gray-100 text-gray-600 text-[10px] px-2 py-0.5 rounded-md font-medium">Dine-in / Takeaway</span>
                                </div>
                            </div>
                        </div>
                        <div class="flex justify-between items-center mt-4 pt-2 border-t border-gray-50">
                            <div>
                                <span class="text-[10px] text-gray-400 font-semibold block">HARGA</span>
                                <span class="font-bold text-indigo-600 text-sm">Rp 22.000</span>
                            </div>
                            <button type="button" data-id="kopi" data-nama="Kopi Susu Aren HQ" data-harga="22000" data-catatan="Less Sugar, Normal Ice"
                                class="btn-tambah bg-indigo-600 text-white text-xs font-semibold px-4 py-1.5 rounded-lg hover:bg-indigo-700 transition">+ Tambah</button>
                        </div>
                    </div>

                    <div class="menu-card bg-white rounded-2xl p-4 border border-gray-100 shadow-sm flex flex-col justify-between" data-category="signature" data-nama="Sea Salt Latte">
                        <div class="flex space-x-3">
                            <div class="relative">
                                <img src="https://via.placeholder.com/100" class="w-24 h-24 rounded-xl object-cover" alt="Sea Salt Latte">
                                <span class="absolute top-1 left-1 bg-amber-500 text-white text-[10px] px-1.5 py-0.5 rounded font-semibold">BARISTA PICK</span>
                            </div>
                            <div class="flex-1">
                                <h4 class="font-bold text-gray-900 text-sm">Sea Salt Latte</h4>
                                <p class="text-xs text-gray-500 mt-1 line-clamp-2">Double shot espresso, creamy fresh milk berpadu savory sea salt cold...</p>
                                <div class="mt-2 flex space-x-1">
                                    <span class="bg-gray-100 text-gray-600 text-[10px] px-2 py-0.5 rounded-md font-medium">SPECIALTY</span>
                                </div>
                            </div>
                        </div>
                        <div class="flex justify-between items-center mt-4 pt-2 border-t border-gray-50">
                            <div>
                                <span class="text-[10px] text-gray-400 font-semibold block">HARGA</span>
                                <span class="font-bold text-indigo-600 text-sm">Rp 28.000</span>
                            </div>
                            <button type="button" data-id="latte" data-nama="Sea Salt Latte" data-harga="28000" data-catatan="Normal Ice"
                                class="btn-tambah bg-indigo-600 text-white text-xs font-semibold px-4 py-1.5 rounded-lg hover:bg-indigo-700 transition">+ Tambah</button>
                        </div>
                    </div>

                </div>

                <p id="menu-empty" class="hidden text-center text-xs text-gray-400 bg-white rounded-2xl border border-gray-100 py-8">
                    Menu pada kategori ini belum tersedia. Coba pilih kategori lain.
                </p>

            </div>

            <div class="space-y-4">
                <div class="bg-white rounded-2xl p-5 shadow-sm border border-gray-100">
                    <div class="flex justify-between items-center pb-4 border-b border-gray-100">
                        <div class="flex items-center space-x-2">
                            <div class="p-2 bg-indigo-50 text-indigo-600 rounded-lg"><i class="fa-solid fa-basket-shopping"></i></div>
                            <div>
                                <h3 class="font-bold text-gray-900 text-sm">Pesanan Kamu</h3>
                                <span class="text-xs text-gray-400">Meja 01 • Dine In</span>
                            </div>
                        </div>
                        <span id="cart-badge" class="bg-indigo-50 text-indigo-600 text-xs font-bold px-2.5 py-1 rounded-full">3 Item</span>
                    </div>

                    <div id="cart-items" class="py-4 space-y-4 border-b border-gray-100">
                        <div class="cart-item bg-gray-50 p-3 rounded-xl" data-id="kopi" data-harga="22000">
                            <div class="flex justify-between text-sm font-bold">
                                <span class="item-nama">Kopi Susu Aren HQ</span>
                                <div class="flex items-center space-x-2">
                                    <button type="button" class="qty-minus w-5 h-5 bg-white rounded flex items-center justify-center text-xs border">-</button>
                                    <span class="qty-label text-xs">1</span>
                                    <button type="button" class="qty-plus w-5 h-5 bg-white rounded flex items-center justify-center text-xs border">+</button>
                                </div>
                            </div>
                            <div class="line-total text-xs text-indigo-600 font-semibold mt-0.5">Rp 22.000</div>
                            <div class="flex justify-between items-center mt-2 text-[11px] text-gray-400">
                                <span class="item-catatan">Less Sugar, Normal Ice</span>
                                <button type="button" class="remove-item text-rose-500 font-semibold hover:underline">HAPUS</button>
                            </div>
                        </div>

                        <div class="cart-item bg-gray-50 p-3 rounded-xl" data-id="rice" data-harga="35000">
                            <div class="flex justify-between text-sm font-bold">
                                <span class="item-nama">Rice Bowl Ayam Teriyaki</span>
                                <div class="flex items-center space-x-2">
                                    <button type="button" class="qty-minus w-5 h-5 bg-white rounded flex items-center justify-center text-xs border">-</button>
                                    <span class="qty-label text-xs">1</span>
                                    <button type="button" class="qty-plus w-5 h-5 bg-white rounded flex items-center justify-center text-xs border">+</button>
                                </div>
                            </div>
                            <div class="line-total text-xs text-indigo-600 font-semibold mt-0.5">Rp 35.000</div>
                            <div class="flex justify-between items-center mt-2 text-[11px] text-gray-400">
                                <span class="item-catatan">Telur Setengah Matang</span>
                                <button type="button" class="remove-item text-rose-500 font-semibold hover:underline">HAPUS</button>
                            </div>
                        </div>
                    </div>

                    <p id="cart-empty" class="hidden py-6 text-center text-xs text-gray-400">Belum ada menu yang dipilih. Tambahkan menu favoritmu.</p>

                    <div class="py-3">
                        <label for="catatan-barista" class="text-xs font-semibold text-gray-500 block mb-1">CATATAN UNTUK BARISTA / DAPUR</label>
                        <input id="catatan-barista" type="text" placeholder="Contoh: Tolong sediakan sendok tambahan..."
                            class="w-full text-xs p-2.5 bg-gray-50 border border-gray-200 rounded-xl focus:outline-none">
                    </div>

                    <div class="py-2">
                        <span class="text-xs font-semibold text-gray-500 block mb-2">PILIH METODE PEMBAYARAN</span>
                        <div class="grid grid-cols-2 gap-2">
                            <button type="button" data-metode="qris" class="metode-btn bg-indigo-600 text-white py-2 rounded-xl text-xs font-semibold flex items-center justify-center">
                                <i class="fa-solid fa-qrcode mr-1.5"></i> QRIS Meja
                            </button>
                            <button type="button" data-metode="kasir" class="metode-btn bg-gray-100 text-gray-600 py-2 rounded-xl text-xs font-semibold flex items-center justify-center hover:bg-gray-200">
                                <i class="fa-solid fa-cash-register mr-1.5"></i> Bayar Kasir
                            </button>
                        </div>
                    </div>

                    <div class="py-3 border-t border-gray-100 text-xs space-y-1.5">
                        <div class="flex justify-between text-gray-500">
                            <span id="subtotal-label">Subtotal (3 item)</span>
                            <span id="subtotal-value" class="font-semibold text-gray-800">Rp 81.000</span>
                        </div>
                        <div class="flex justify-between text-gray-500">
                            <span>Pajak Restoran PB1(10%)</span>
                            <span id="tax-value" class="font-semibold text-gray-800">Rp 8.100</span>
                        </div>
                        <div class="flex justify-between text-emerald-600">
                            <span>Diskon Promo Dine-in</span>
                            <span id="discount-value" class="font-semibold">- Rp 9.900</span>
                        </div>
                        <div class="flex justify-between items-center pt-2 text-sm font-bold border-t border-gray-100">
                            <div>
                                <span>TOTAL PEMBAYARAN</span>
                                <span class="block text-[10px] text-indigo-600 font-normal">TERMASUK PB1</span>
                            </div>
                            <span id="total-value" class="text-lg text-indigo-600">Rp 79.200</span>
                        </div>
                    </div>

                    <button id="btn-bayar" type="button" class="w-full bg-indigo-600 text-white font-bold py-3 rounded-xl text-xs hover:bg-indigo-700 transition mt-2 flex justify-center items-center">
                        <i class="fa-regular fa-circle-check mr-2"></i> <span id="btn-bayar-text">Lanjut Pembayaran QRIS (Rp 79.200)</span>
                    </button>
                    <span class="text-[10px] text-gray-400 text-center block mt-2">Pesanan langsung diteruskan ke barista meja 01</span>
                </div>

                <div class="bg-white rounded-2xl p-4 border border-gray-100 shadow-sm flex justify-between items-center">
                    <div class="flex items-center space-x-3">
                        <div class="p-2 bg-indigo-50 text-indigo-600 rounded-xl"><i class="fa-solid fa-bell"></i></div>
                        <div>
                            <h4 class="text-xs font-bold text-gray-800">Butuh Bantuan Staff?</h4>
                            <p class="text-[10px] text-gray-400">Panggil pelayan ke Meja 01</p>
                        </div>
                    </div>
                    <button id="btn-panggil" type="button" class="border border-indigo-600 text-indigo-600 text-xs font-bold px-3 py-1.5 rounded-lg hover:bg-indigo-50">Panggil</button>
                </div>
            </div>

        </div>

        <div id="hq-toast" class="hq-toast" role="status" aria-live="polite"></div>

        <script>
            document.addEventListener('DOMContentLoaded', function () {
                const rupiah = (n) => 'Rp ' + n.toLocaleString('id-ID');

                const cartItems = document.getElementById('cart-items');
                const cartEmpty = document.getElementById('cart-empty');
                const cartBadge = document.getElementById('cart-badge');
                const subtotalLabel = document.getElementById('subtotal-label');
                const subtotalValue = document.getElementById('subtotal-value');
                const taxValue = document.getElementById('tax-value');
                const discountValue = document.getElementById('discount-value');
                const totalValue = document.getElementById('total-value');
                const btnBayar = document.getElementById('btn-bayar');
                const btnBayarText = document.getElementById('btn-bayar-text');
                const toastEl = document.getElementById('hq-toast');
                let metode = 'qris';
                let toastTimer;

                function toast(pesan) {
                    toastEl.textContent = pesan;
                    toastEl.classList.add('is-show');
                    clearTimeout(toastTimer);
                    toastTimer = setTimeout(() => toastEl.classList.remove('is-show'), 2600);
                }

                function recompute() {
                    const items = Array.from(cartItems.querySelectorAll('.cart-item'));
                    let jumlah = 0;
                    let subtotal = 0;

                    items.forEach((item) => {
                        const qty = parseInt(item.querySelector('.qty-label').textContent, 10);
                        const harga = parseInt(item.dataset.harga, 10);
                        jumlah += qty;
                        subtotal += qty * harga;
                        item.querySelector('.line-total').textContent = rupiah(qty * harga);
                    });

                    const kosong = items.length === 0;
                    cartEmpty.classList.toggle('hidden', !kosong);
                    cartItems.classList.toggle('hidden', kosong);

                    const pajak = Math.round(subtotal * 0.1);
                    const diskon = Math.round(subtotal * 0.1);
                    const total = subtotal + pajak - diskon;

                    cartBadge.textContent = jumlah + ' Item';
                    subtotalLabel.textContent = 'Subtotal (' + jumlah + ' item)';
                    subtotalValue.textContent = rupiah(subtotal);
                    taxValue.textContent = rupiah(pajak);
                    discountValue.textContent = '- ' + rupiah(diskon);
                    totalValue.textContent = rupiah(total);
                    btnBayarText.textContent = 'Lanjut Pembayaran QRIS (' + rupiah(total) + ')';
                    btnBayar.disabled = kosong;
                    btnBayar.classList.toggle('bg-indigo-600', !kosong);
                    btnBayar.classList.toggle('hover:bg-indigo-700', !kosong);
                    btnBayar.classList.toggle('bg-gray-300', kosong);
                    btnBayar.classList.toggle('cursor-not-allowed', kosong);
                }

                function buatItemCart({ id, nama, harga, catatan }) {
                    const el = document.createElement('div');
                    el.className = 'cart-item bg-gray-50 p-3 rounded-xl';
                    el.dataset.id = id;
                    el.dataset.harga = harga;
                    el.innerHTML =
                        '<div class="flex justify-between text-sm font-bold">' +
                            '<span class="item-nama"></span>' +
                            '<div class="flex items-center space-x-2">' +
                                '<button type="button" class="qty-minus w-5 h-5 bg-white rounded flex items-center justify-center text-xs border">-</button>' +
                                '<span class="qty-label text-xs">1</span>' +
                                '<button type="button" class="qty-plus w-5 h-5 bg-white rounded flex items-center justify-center text-xs border">+</button>' +
                            '</div>' +
                        '</div>' +
                        '<div class="line-total text-xs text-indigo-600 font-semibold mt-0.5"></div>' +
                        '<div class="flex justify-between items-center mt-2 text-[11px] text-gray-400">' +
                            '<span class="item-catatan"></span>' +
                            '<button type="button" class="remove-item text-rose-500 font-semibold hover:underline">HAPUS</button>' +
                        '</div>';
                    el.querySelector('.item-nama').textContent = nama;
                    el.querySelector('.item-catatan').textContent = catatan;
                    cartItems.appendChild(el);
                }

                cartItems.addEventListener('click', function (e) {
                    const item = e.target.closest('.cart-item');
                    if (!item) return;

                    if (e.target.classList.contains('qty-plus')) {
                        const label = item.querySelector('.qty-label');
                        label.textContent = parseInt(label.textContent, 10) + 1;
                        recompute();
                    } else if (e.target.classList.contains('qty-minus')) {
                        const label = item.querySelector('.qty-label');
                        const qty = parseInt(label.textContent, 10);
                        if (qty > 1) {
                            label.textContent = qty - 1;
                            recompute();
                        }
                    } else if (e.target.classList.contains('remove-item')) {
                        item.remove();
                        recompute();
                    }
                });

                document.querySelectorAll('.btn-tambah').forEach((btn) => {
                    btn.addEventListener('click', function () {
                        const id = this.dataset.id;
                        const existing = cartItems.querySelector('.cart-item[data-id="' + id + '"]');
                        if (existing) {
                            const label = existing.querySelector('.qty-label');
                            label.textContent = parseInt(label.textContent, 10) + 1;
                        } else {
                            buatItemCart({
                                id,
                                nama: this.dataset.nama,
                                harga: this.dataset.harga,
                                catatan: this.dataset.catatan,
                            });
                        }
                        recompute();
                        toast(this.dataset.nama + ' ditambahkan ke pesanan');
                    });
                });

                document.getElementById('btn-tambah-combo').addEventListener('click', function () {
                    const existing = cartItems.querySelector('.cart-item[data-id="combo"]');
                    if (existing) {
                        const label = existing.querySelector('.qty-label');
                        label.textContent = parseInt(label.textContent, 10) + 1;
                    } else {
                        buatItemCart({
                            id: 'combo',
                            nama: 'Paket Siang (Kopi Aren + Rice Bowl)',
                            harga: 50000,
                            catatan: 'Combo Hemat - potongan Rp 7.000 otomatis',
                        });
                    }
                    recompute();
                    toast('Paket Siang Combo ditambahkan ke pesanan');
                });

                const kategoriBtns = document.querySelectorAll('.kategori-btn');
                const menuCards = document.querySelectorAll('.menu-card');
                const menuEmpty = document.getElementById('menu-empty');
                let filterAktif = 'semua';
                let kataKunci = '';

                function terapkanFilterMenu() {
                    let terlihat = 0;
                    menuCards.forEach((card) => {
                        const cocokKategori = filterAktif === 'semua' || card.dataset.category === filterAktif;
                        const cocokCari = card.dataset.nama.toLowerCase().includes(kataKunci);
                        const tampil = cocokKategori && cocokCari;
                        card.classList.toggle('hidden', !tampil);
                        if (tampil) terlihat++;
                    });
                    menuEmpty.classList.toggle('hidden', terlihat > 0);
                }

                kategoriBtns.forEach((btn) => {
                    btn.addEventListener('click', function () {
                        filterAktif = this.dataset.filter;
                        kategoriBtns.forEach((b) => {
                            const aktif = b === this;
                            b.classList.toggle('bg-indigo-600', aktif);
                            b.classList.toggle('text-white', aktif);
                            b.classList.toggle('bg-white', !aktif);
                            b.classList.toggle('text-gray-600', !aktif);
                            b.classList.toggle('border', !aktif);
                            b.classList.toggle('border-gray-100', !aktif);
                        }, this);
                        terapkanFilterMenu();
                    });
                });

                document.getElementById('menu-search').addEventListener('input', function () {
                    kataKunci = this.value.trim().toLowerCase();
                    terapkanFilterMenu();
                });

                document.querySelectorAll('.metode-btn').forEach((btn) => {
                    btn.addEventListener('click', function () {
                        metode = this.dataset.metode;
                        document.querySelectorAll('.metode-btn').forEach((b) => {
                            const aktif = b === this;
                            b.classList.toggle('bg-indigo-600', aktif);
                            b.classList.toggle('text-white', aktif);
                            b.classList.toggle('bg-gray-100', !aktif);
                            b.classList.toggle('text-gray-600', !aktif);
                            b.classList.toggle('hover:bg-gray-200', !aktif);
                        }, this);
                    });
                });

                btnBayar.addEventListener('click', function () {
                    if (this.disabled) return;
                    if (metode === 'qris') {
                        window.location.href = '{{ route('pembayaran-qris') }}';
                    } else {
                        toast('Pembayaran diproses di kasir — silakan tunggu konfirmasi petugas (demo)');
                    }
                });

                document.getElementById('btn-panggil').addEventListener('click', function () {
                    toast('Panggilan staff dikirim ke Meja 01 (demo)');
                });

                document.getElementById('btn-mulai-pesan').addEventListener('click', function () {
                    document.getElementById('menu-grid').scrollIntoView({ behavior: 'smooth', block: 'start' });
                });

                recompute();
            });
        </script>

    </body>
</html>
