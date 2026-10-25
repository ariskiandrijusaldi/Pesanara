<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Kasir &amp; Order Monitor - HQ Coffee &amp; Bites</title>
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <script>document.documentElement.classList.add('js');</script>

        @fonts
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
        @vite(['resources/css/app.css', 'resources/js/app.js'])

        <style>
            .hq-toast {
                position: fixed; bottom: 1.5rem; left: 50%;
                transform: translateX(-50%) translateY(1rem);
                background: #111827; color: #fff; font-size: 11px; font-weight: 600;
                padding: 0.65rem 1.1rem; border-radius: 0.75rem;
                box-shadow: 0 10px 25px rgba(17, 24, 39, 0.25);
                opacity: 0; pointer-events: none;
                transition: opacity 0.25s ease, transform 0.25s ease;
                z-index: 80; max-width: 90vw; text-align: center;
            }
            .hq-toast.is-show { opacity: 1; transform: translateX(-50%) translateY(0); }

            .hq-modal {
                position: fixed; inset: 0; z-index: 70; display: grid; place-items: center;
                background: rgba(17, 24, 39, 0.55); padding: 1rem;
                opacity: 0; pointer-events: none; transition: opacity 0.2s ease;
            }
            .hq-modal.is-open { opacity: 1; pointer-events: auto; }

            .order-card.is-selected { border-color: #6366f1; box-shadow: 0 0 0 3px rgba(99, 102, 241, 0.15); }
            .item-price { font-family: ui-monospace, SFMono-Regular, Menlo, monospace; }
        </style>
    </head>

    <body class="bg-indigo-50/20 text-gray-800 font-sans text-xs">

        <header class="site-header sticky top-0 z-50 bg-white border-b border-gray-100 px-4 sm:px-6 py-3 flex flex-wrap justify-between items-center gap-3">
            <div class="flex items-center space-x-3">
                <div class="bg-indigo-600 text-white p-1.5 rounded-lg font-bold">HQ</div>
                <div>
                    <h1 class="font-bold text-sm text-gray-900">HQ Coffee &amp; Bites</h1>
                    <span class="text-[10px] text-indigo-600 font-medium">KASIR &amp; ORDER MONITOR (DINE-IN &amp; TAKEAWAY)</span>
                </div>
            </div>

            <div class="flex flex-wrap items-center gap-2 sm:gap-3">
                <span class="text-gray-500 font-medium"><i class="fa-regular fa-clock mr-1"></i> <span id="live-clock">10:42 WIB</span></span>
                <span class="bg-emerald-100 text-emerald-700 px-2.5 py-1 rounded-full text-[10px] font-semibold flex items-center">
                    <span class="w-1.5 h-1.5 bg-emerald-500 rounded-full mr-1.5"></span> Realtime Sync Aktif
                </span>
                <button id="btn-audio" type="button" class="bg-indigo-50 text-indigo-600 px-3 py-1.5 rounded-lg font-semibold hover:bg-indigo-100">
                    <i class="fa-solid fa-volume-high mr-1"></i> Notifikasi Audio: ON
                </button>
                <button id="btn-shift" type="button" class="bg-rose-50 text-rose-600 px-3 py-1.5 rounded-lg font-semibold hover:bg-rose-100">
                    <i class="fa-solid fa-power-off mr-1"></i> Tutup Shift
                </button>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="bg-gray-100 text-gray-600 px-3 py-1.5 rounded-lg font-semibold hover:bg-gray-200">
                        <i class="fa-solid fa-right-from-bracket mr-1"></i> Keluar
                    </button>
                </form>
                <div class="bg-indigo-600 text-white w-7 h-7 rounded-full flex items-center justify-center font-bold" title="{{ auth()->user()->name }}">{{ strtoupper(substr(auth()->user()->name, 0, 2)) }}</div>
            </div>
        </header>

        <div class="p-4 sm:p-6 max-w-[1600px] mx-auto space-y-6">

            <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                <div class="bg-white p-4 rounded-2xl border border-gray-100 shadow-sm flex items-center justify-between">
                    <div class="flex items-center space-x-3">
                        <div class="p-3 bg-indigo-50 text-indigo-600 rounded-xl"><i class="fa-solid fa-chair text-lg"></i></div>
                        <div>
                            <span class="text-gray-400 font-semibold block">PESANAN AKTIF</span>
                            <span id="stat-aktif" class="text-xl font-black text-gray-900">{{ $counts['aktif'] }} <span class="text-xs font-normal text-gray-500">Order</span></span>
                        </div>
                    </div>
                    <span class="bg-indigo-100 text-indigo-700 font-bold px-2 py-0.5 rounded text-[10px]">Live</span>
                </div>

                <div class="bg-white p-4 rounded-2xl border border-gray-100 shadow-sm flex items-center justify-between">
                    <div class="flex items-center space-x-3">
                        <div class="p-3 bg-amber-50 text-amber-600 rounded-xl"><i class="fa-solid fa-receipt text-lg"></i></div>
                        <div>
                            <span class="text-gray-400 font-semibold block">MENUNGGU VERIFIKASI</span>
                            <span id="stat-verifikasi" class="text-xl font-black text-gray-900">{{ $counts['verifikasi'] }} <span class="text-xs font-normal text-gray-500">Order</span></span>
                        </div>
                    </div>
                    <span class="bg-amber-100 text-amber-700 font-bold px-2 py-0.5 rounded text-[10px]">Perlu Cek</span>
                </div>

                <div class="bg-white p-4 rounded-2xl border border-gray-100 shadow-sm flex items-center justify-between">
                    <div class="flex items-center space-x-3">
                        <div class="p-3 bg-purple-50 text-purple-600 rounded-xl"><i class="fa-solid fa-utensils text-lg"></i></div>
                        <div>
                            <span class="text-gray-400 font-semibold block">DIPROSES DAPUR</span>
                            <span id="stat-dapur" class="text-xl font-black text-gray-900">{{ $counts['dapur'] }} <span class="text-xs font-normal text-gray-500">Order</span></span>
                        </div>
                    </div>
                    <span class="bg-purple-100 text-purple-700 font-bold px-2 py-0.5 rounded text-[10px]">Memasak</span>
                </div>

                <div class="bg-white p-4 rounded-2xl border border-gray-100 shadow-sm flex items-center justify-between">
                    <div class="flex items-center space-x-3">
                        <div class="p-3 bg-emerald-50 text-emerald-600 rounded-xl"><i class="fa-solid fa-circle-check text-lg"></i></div>
                        <div>
                            <span class="text-gray-400 font-semibold block">SELESAI HARI INI</span>
                            <span id="stat-selesai" class="text-xl font-black text-gray-900">{{ $counts['selesai'] }} <span class="text-xs font-normal text-gray-500">Order</span></span>
                        </div>
                    </div>
                    <span class="bg-emerald-100 text-emerald-700 font-bold px-2 py-0.5 rounded text-[10px]">100% Lunas</span>
                </div>
            </div>

            <div class="flex flex-wrap items-center justify-between gap-3 bg-white p-3 rounded-2xl border border-gray-100">
                <div id="status-tabs" class="flex flex-wrap items-center gap-2">
                    <button type="button" data-filter="semua" class="status-btn bg-indigo-600 text-white font-bold px-3 py-1.5 rounded-xl">Semua <span id="badge-semua" class="bg-white text-indigo-600 px-1.5 py-0.5 rounded-full text-[10px]">{{ $counts['total'] }}</span></button>
                    <button type="button" data-filter="verifikasi" class="status-btn bg-gray-50 text-gray-600 hover:bg-gray-100 font-medium px-3 py-1.5 rounded-xl border border-gray-100"><span class="inline-block w-1.5 h-1.5 bg-amber-500 rounded-full mr-1"></span>Menunggu Verifikasi <span id="badge-verifikasi" class="bg-amber-100 text-amber-700 px-1.5 py-0.5 rounded-full text-[10px]">{{ $counts['verifikasi'] }}</span></button>
                    <button type="button" data-filter="dapur" class="status-btn bg-gray-50 text-gray-600 hover:bg-gray-100 font-medium px-3 py-1.5 rounded-xl border border-gray-100"><i class="fa-solid fa-utensils mr-1"></i>Diproses Dapur <span id="badge-dapur" class="bg-purple-100 text-purple-700 px-1.5 py-0.5 rounded-full text-[10px]">{{ $counts['dapur'] }}</span></button>
                    <button type="button" data-filter="siap" class="status-btn bg-gray-50 text-gray-600 hover:bg-gray-100 font-medium px-3 py-1.5 rounded-xl border border-gray-100"><i class="fa-solid fa-bell-concierge mr-1"></i>Siap Diantar / Dipanggil <span id="badge-siap" class="bg-blue-100 text-blue-700 px-1.5 py-0.5 rounded-full text-[10px]">{{ $counts['siap'] }}</span></button>
                    <button type="button" data-filter="selesai" class="status-btn bg-gray-50 text-gray-600 hover:bg-gray-100 font-medium px-3 py-1.5 rounded-xl border border-gray-100"><i class="fa-regular fa-circle-check mr-1"></i>Selesai</button>
                </div>

                <div class="flex flex-wrap items-center gap-3">
                    <div id="type-toggle" class="bg-gray-100 p-1 rounded-xl flex space-x-1">
                        <button type="button" data-type="semua" class="type-btn bg-white font-bold px-2.5 py-1 rounded-lg shadow-sm">Semua</button>
                        <button type="button" data-type="dine-in" class="type-btn text-gray-500 font-medium px-2.5 py-1 rounded-lg"><i class="fa-solid fa-utensils mr-1"></i>Dine-in</button>
                        <button type="button" data-type="takeaway" class="type-btn text-gray-500 font-medium px-2.5 py-1 rounded-lg"><i class="fa-solid fa-bag-shopping mr-1"></i>Takeaway</button>
                    </div>

                    <div class="relative">
                        <i class="fa-solid fa-magnifying-glass absolute left-3 top-2.5 text-gray-400"></i>
                        <input id="order-search" type="text" placeholder="Cari no meja/cor/takeaway..."
                            class="pl-8 pr-3 py-1.5 bg-gray-50 border border-gray-200 rounded-xl text-xs w-48 focus:outline-none">
                    </div>
                    <div id="floor-toggle" class="bg-gray-100 p-1 rounded-xl flex space-x-1">
                        <button type="button" data-floor="semua" class="floor-btn bg-white font-bold px-2.5 py-1 rounded-lg shadow-sm">Semua Meja</button>
                        <button type="button" data-floor="1" class="floor-btn text-gray-500 font-medium px-2.5 py-1 rounded-lg">Lantai 1</button>
                        <button type="button" data-floor="2" class="floor-btn text-gray-500 font-medium px-2.5 py-1 rounded-lg">Lantai 2</button>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

                <div class="lg:col-span-2 space-y-4">

                    <div class="flex justify-between items-center text-xs font-bold text-gray-600 px-1">
                        <span><i class="fa-solid fa-qrcode text-indigo-600 mr-1"></i> Antrean Pesanan Masuk (Scan Meja)</span>
                        <span class="text-gray-400 font-normal">Urut berdasarkan: Terbaru</span>
                    </div>

                    <div id="orders-list" class="space-y-4">
                        @include('tampilan.partials.order-cards', ['orders' => $orders])
                    </div>

                    <p id="orders-empty" class="hidden text-center text-xs text-gray-400 bg-white rounded-2xl border border-gray-100 py-8">
                        Tidak ada pesanan yang cocok dengan filter saat ini.
                    </p>

                </div>

                <div class="space-y-4">

                    <div class="bg-white rounded-2xl p-4 border border-gray-100 shadow-sm space-y-4">
                        <div class="flex justify-between items-center pb-3 border-b border-gray-100">
                            <div>
                                <span id="side-meja" class="bg-indigo-100 text-indigo-700 font-bold px-2 py-0.5 rounded text-[10px]">MEJA 03</span>
                                <h3 class="font-bold text-gray-900 text-sm mt-1">Detail Pesanan Terpilih</h3>
                                <p id="side-meta" class="text-[10px] text-gray-400">ID: #ORD-0845 • Pelanggan: Hendra S.</p>
                            </div>
                            <span id="side-status" class="bg-amber-100 text-amber-800 font-bold text-[10px] px-2 py-1 rounded-lg">Perlu Verifikasi</span>
                        </div>

                        <div class="bg-indigo-50/50 p-3 rounded-xl space-y-2 border border-indigo-100">
                            <div class="flex justify-between items-center">
                                <span id="pay-panel-title" class="font-bold text-indigo-900 text-xs"><i class="fa-solid fa-shield-check mr-1"></i> VERIFIKASI BUKTI TRANSFER QRIS</span>
                                <span id="pay-match" class="text-emerald-600 font-bold text-xs">Cocok : Rp 101.000</span>
                            </div>
                            <div class="text-[10px] space-y-1 text-gray-500 pt-1 border-t border-indigo-100/60">
                                <div class="flex justify-between"><span>Waktu Transaksi:</span><span id="pay-time" class="font-semibold text-gray-700">10:40:55 WIB</span></div>
                                <div class="flex justify-between"><span>Metode Bayar:</span><span id="pay-method" class="font-semibold text-gray-700">QRIS GPN (GoPay/BCA)</span></div>
                                <div class="flex justify-between"><span>Nomor RRN / Ref:</span><span id="pay-rrn" class="font-semibold text-gray-700">RRN-99203172681</span></div>
                                <div id="pay-integrasi-row" class="flex justify-between text-emerald-600 font-bold"><span>Status Integrasi:</span><span id="pay-integrasi"><i class="fa-solid fa-check mr-1"></i> Sesuai Tagihan</span></div>
                            </div>
                        </div>

                        <div id="side-action-container" class="space-y-2">
                            <button type="button" id="side-main-btn" class="btn-verif-qris w-full bg-emerald-600 text-white font-bold py-2.5 rounded-xl hover:bg-emerald-700 text-xs shadow-sm shadow-emerald-200 transition flex items-center justify-center gap-2">
                                <i class="fa-solid fa-circle-check text-sm"></i> Verifikasi QRIS &amp; Kirim ke Dapur
                            </button>
                            <button type="button" class="btn-cetak w-full bg-gray-100 hover:bg-gray-200 text-gray-700 font-bold py-2 rounded-xl text-xs flex items-center justify-center gap-1.5 transition">
                                <i class="fa-solid fa-print"></i> Cetak Struk
                            </button>
                        </div>

                        <div class="pt-2">
                            <span class="text-[10px] font-bold text-gray-400 block mb-2 uppercase">Alur Status Pesanan</span>
                            <div id="stepper" class="grid grid-cols-4 gap-1 text-center font-bold text-[9px]">
                                <span data-step="1" class="bg-indigo-600 text-white py-1.5 rounded-lg">1. Verifikasi</span>
                                <span data-step="2" class="bg-gray-100 text-gray-500 py-1.5 rounded-lg">2. Dapur</span>
                                <span data-step="3" class="bg-gray-100 text-gray-500 py-1.5 rounded-lg">3. Diantar</span>
                                <span data-step="4" class="bg-gray-100 text-gray-500 py-1.5 rounded-lg">4. Selesai</span>
                            </div>
                        </div>

                        <div class="flex space-x-2 pt-2">
                            <button type="button" class="btn-kot flex-1 bg-gray-50 hover:bg-gray-100 text-gray-700 font-bold py-2 rounded-xl text-xs"><i class="fa-solid fa-print mr-1"></i> Cetak KOT</button>
                            <button type="button" class="btn-tolak flex-1 bg-rose-50 hover:bg-rose-100 text-rose-600 font-bold py-2 rounded-xl text-xs"><i class="fa-solid fa-xmark mr-1"></i> Batal</button>
                        </div>
                    </div>

                    <div class="bg-white rounded-2xl p-4 border border-gray-100 shadow-sm flex flex-wrap justify-between items-center gap-3">
                        <div class="flex items-center space-x-3">
                            <div class="p-2.5 bg-indigo-50 text-indigo-600 rounded-xl"><i class="fa-solid fa-boxes-stacked text-base"></i></div>
                            <div>
                                <h4 class="font-bold text-gray-800 text-xs">Manajemen Stok Menu</h4>
                                <p class="text-[10px] text-gray-400">Kelola ketersediaan &amp; porsi</p>
                            </div>
                        </div>
                        <a href="{{ route('stok-menu') }}" class="bg-indigo-50 hover:bg-indigo-100 text-indigo-600 font-bold px-3 py-1.5 rounded-xl text-xs flex items-center">
                            Buka Kelola Stok <i class="fa-solid fa-arrow-right ml-1"></i>
                        </a>
                    </div>

                </div>

            </div>

        </div>

        <footer class="text-center text-[10px] text-gray-400 py-4 border-t border-gray-100 mt-8 flex flex-wrap justify-between gap-2 px-4 sm:px-8">
            <span>Terminal Kasir #01 • Outlet Jakarta Selatan • Sistem Monitor QR Dine-In v3.2 • <span class="text-emerald-500 font-semibold">● Server Live</span></span>
            <span>Pusat Bantuan Kasir: ext 104 • <strong>© 2024 HQ COFFEE &amp; BITES</strong></span>
        </footer>

        <div id="proof-modal" class="hq-modal" role="dialog" aria-modal="true" aria-label="Bukti pembayaran QRIS">
            <div class="bg-white rounded-2xl p-5 w-full max-w-sm space-y-3">
                <div class="flex justify-between items-center border-b border-gray-100 pb-2">
                    <span class="font-bold text-xs text-gray-900"><i class="fa-solid fa-receipt text-indigo-600 mr-1"></i> Bukti Pembayaran QRIS</span>
                    <button type="button" id="btn-close-proof" class="text-gray-400 hover:text-gray-600" aria-label="Tutup"><i class="fa-solid fa-xmark"></i></button>
                </div>
                <div class="bg-indigo-50/60 rounded-xl p-3 space-y-1.5 text-[11px]">
                    <div class="flex justify-between"><span class="text-gray-500">Meja / Order:</span><span id="proof-order" class="font-bold text-gray-800">MEJA 03 • #ORD-0845</span></div>
                    <div class="flex justify-between"><span class="text-gray-500">Nominal Tagihan:</span><span id="proof-total" class="font-bold text-gray-800">Rp 101.000</span></div>
                    <div class="flex justify-between"><span class="text-gray-500">Waktu Transaksi:</span><span id="proof-time" class="font-semibold text-gray-700">10:40:55 WIB</span></div>
                    <div class="flex justify-between"><span class="text-gray-500">Metode Bayar:</span><span id="proof-method" class="font-semibold text-gray-700">QRIS GPN (GoPay/BCA)</span></div>
                    <div class="flex justify-between"><span class="text-gray-500">Nomor RRN / Ref:</span><span id="proof-rrn" class="font-semibold text-gray-700">RRN-99203172681</span></div>
                </div>
                <p id="proof-note" class="text-[10px] text-emerald-600 font-bold text-center">Nominal cocok dengan tagihan — silakan verifikasi & cetak struk.</p>
                <div class="pt-2 flex space-x-2">
                    <button type="button" id="btn-modal-close" class="flex-1 bg-gray-100 hover:bg-gray-200 text-gray-700 font-bold py-2 rounded-xl text-xs">Tutup</button>
                    <button type="button" id="btn-modal-verif" data-action="verifikasi" class="flex-1 btn-verif-qris bg-emerald-600 hover:bg-emerald-700 text-white font-bold py-2 rounded-xl text-xs shadow-sm flex items-center justify-center gap-1.5">
                        <i class="fa-solid fa-circle-check"></i> Verifikasi QRIS
                    </button>
                </div>
            </div>
        </div>

        <div id="hq-toast" class="hq-toast" role="status" aria-live="polite"></div>

        <script>
            document.addEventListener('DOMContentLoaded', function () {
                const csrfToken = document.querySelector('meta[name="csrf-token"]').content;
                const feedUrl = @json(route('kasir-order-monitor.feed'));
                const ordersBaseUrl = @json(url('/orders'));

                const toastEl = document.getElementById('hq-toast');
                let toastTimer;

                function toast(pesan) {
                    toastEl.textContent = pesan;
                    toastEl.classList.add('is-show');
                    clearTimeout(toastTimer);
                    toastTimer = setTimeout(() => toastEl.classList.remove('is-show'), 2800);
                }

                const clockEl = document.getElementById('live-clock');
                function updateClock() {
                    const jam = new Intl.DateTimeFormat('id-ID', {
                        hour: '2-digit', minute: '2-digit', hour12: false, timeZone: 'Asia/Jakarta',
                    }).format(new Date());
                    clockEl.textContent = jam.replace('.', ':') + ' WIB';
                }
                updateClock();
                setInterval(updateClock, 30000);

                const btnAudio = document.getElementById('btn-audio');
                let audioOn = true;
                btnAudio.addEventListener('click', function () {
                    audioOn = !audioOn;
                    this.innerHTML = audioOn
                        ? '<i class="fa-solid fa-volume-high mr-1"></i> Notifikasi Audio: ON'
                        : '<i class="fa-solid fa-volume-xmark mr-1"></i> Notifikasi Audio: OFF';
                    this.classList.toggle('bg-indigo-50', audioOn);
                    this.classList.toggle('text-indigo-600', audioOn);
                    this.classList.toggle('bg-gray-100', !audioOn);
                    this.classList.toggle('text-gray-500', !audioOn);
                    toast(audioOn ? 'Notifikasi audio diaktifkan' : 'Notifikasi audio dinonaktifkan');
                });

                document.getElementById('btn-shift').addEventListener('click', function () {
                    toast('Tutup shift memerlukan konfirmasi supervisor (demo)');
                });

                const ordersList = document.getElementById('orders-list');
                const ordersEmpty = document.getElementById('orders-empty');
                const statusBtns = document.querySelectorAll('.status-btn');
                const floorBtns = document.querySelectorAll('.floor-btn');
                const typeBtns = document.querySelectorAll('.type-btn');
                const searchInput = document.getElementById('order-search');
                let filterStatus = 'semua';
                let filterFloor = 'semua';
                let filterType = 'semua';
                let currentCards = [];
                let selectedCode = null;
                let lastHtml = null;

                const sideMeja = document.getElementById('side-meja');
                const sideMeta = document.getElementById('side-meta');
                const sideStatus = document.getElementById('side-status');
                const payPanelTitle = document.getElementById('pay-panel-title');
                const payMatch = document.getElementById('pay-match');
                const payTime = document.getElementById('pay-time');
                const payMethod = document.getElementById('pay-method');
                const payRrn = document.getElementById('pay-rrn');
                const payIntegrasi = document.getElementById('pay-integrasi');
                const payIntegrasiRow = document.getElementById('pay-integrasi-row');
                const stepper = document.getElementById('stepper');
                const statusIndex = { verifikasi: 1, dapur: 2, siap: 3, selesai: 4, batal: 1 };

                function terapkanFilter() {
                    const kata = searchInput.value.trim().toLowerCase();
                    let terlihat = 0;

                    currentCards.forEach((card) => {
                        const cocokStatus = filterStatus === 'semua' || card.dataset.status === filterStatus;
                        const cocokFloor = filterFloor === 'semua' || card.dataset.floor === filterFloor;
                        const cocokType = filterType === 'semua' || card.dataset.type === filterType;
                        const teksCari = ('meja ' + card.dataset.meja + ' ' + card.dataset.order + ' ' + card.dataset.pemesan + ' ' + card.dataset.type).toLowerCase();
                        const tampil = cocokStatus && cocokFloor && cocokType && teksCari.includes(kata);
                        card.classList.toggle('hidden', !tampil);
                        if (tampil) terlihat++;
                    });

                    if (currentCards.length === 0) {
                        ordersEmpty.textContent = 'Belum ada pesanan masuk. Pesanan pelanggan akan muncul otomatis di sini.';
                        ordersEmpty.classList.remove('hidden');
                    } else {
                        ordersEmpty.textContent = 'Tidak ada pesanan yang cocok dengan filter saat ini.';
                        ordersEmpty.classList.toggle('hidden', terlihat > 0);
                    }
                }

                statusBtns.forEach((btn) => {
                    btn.addEventListener('click', function () {
                        filterStatus = this.dataset.filter;
                        statusBtns.forEach((b) => {
                            const aktif = b === this;
                            b.classList.toggle('bg-indigo-600', aktif);
                            b.classList.toggle('text-white', aktif);
                            b.classList.toggle('font-bold', aktif);
                            b.classList.toggle('bg-gray-50', !aktif);
                            b.classList.toggle('text-gray-600', !aktif);
                            b.classList.toggle('font-medium', !aktif);
                            b.classList.toggle('border', !aktif);
                            b.classList.toggle('border-gray-100', !aktif);
                        });
                        terapkanFilter();
                    });
                });

                typeBtns.forEach((btn) => {
                    btn.addEventListener('click', function () {
                        filterType = this.dataset.type;
                        typeBtns.forEach((b) => {
                            const aktif = b === this;
                            b.classList.toggle('bg-white', aktif);
                            b.classList.toggle('font-bold', aktif);
                            b.classList.toggle('shadow-sm', aktif);
                            b.classList.toggle('text-gray-500', !aktif);
                            b.classList.toggle('font-medium', !aktif);
                        });
                        terapkanFilter();
                    });
                });

                floorBtns.forEach((btn) => {
                    btn.addEventListener('click', function () {
                        filterFloor = this.dataset.floor;
                        floorBtns.forEach((b) => {
                            const aktif = b === this;
                            b.classList.toggle('bg-white', aktif);
                            b.classList.toggle('font-bold', aktif);
                            b.classList.toggle('shadow-sm', aktif);
                            b.classList.toggle('text-gray-500', !aktif);
                            b.classList.toggle('font-medium', !aktif);
                        });
                        terapkanFilter();
                    });
                });

                searchInput.addEventListener('input', terapkanFilter);

                function updateStepper(status) {
                    const aktif = statusIndex[status] || 1;
                    stepper.querySelectorAll('[data-step]').forEach((step) => {
                        const nomor = parseInt(step.dataset.step, 10);
                        const sudah = nomor < aktif;
                        const current = nomor === aktif;
                        step.classList.toggle('bg-indigo-600', current);
                        step.classList.toggle('text-white', current);
                        step.classList.toggle('bg-indigo-100', sudah);
                        step.classList.toggle('text-indigo-700', sudah);
                        step.classList.toggle('bg-gray-100', !current && !sudah);
                        step.classList.toggle('text-gray-500', !current && !sudah);
                    });
                }

                function clearSidePanel() {
                    selectedCode = null;
                    sideMeja.textContent = '-';
                    sideMeja.className = 'bg-gray-100 text-gray-500 font-bold px-2 py-0.5 rounded text-[10px]';
                    sideMeta.textContent = 'Belum ada pesanan terpilih';
                    sideStatus.textContent = '-';
                    sideStatus.className = 'bg-gray-100 text-gray-500 font-bold text-[10px] px-2 py-1 rounded-lg';
                    payMatch.textContent = '-';
                    payTime.textContent = '-';
                    payMethod.textContent = '-';
                    payRrn.textContent = '-';
                    payIntegrasi.textContent = '-';
                    updateStepper(null);
                    const sideMainBtn = document.getElementById('side-main-btn');
                    if (sideMainBtn) sideMainBtn.style.display = 'none';
                }

                function updateSideActions(card) {
                    const sideMainBtn = document.getElementById('side-main-btn');
                    if (!sideMainBtn) return;
                    const st = card.dataset.status;
                    const pay = card.dataset.payStatus;
                    const isTakeaway = card.dataset.type === 'takeaway';

                    sideMainBtn.removeAttribute('data-action');
                    sideMainBtn.disabled = false;

                    if (st === 'verifikasi') {
                        if (pay === 'pending') {
                            sideMainBtn.className = 'btn-verif-qris w-full bg-emerald-600 text-white font-bold py-2.5 rounded-xl hover:bg-emerald-700 text-xs shadow-sm shadow-emerald-200 transition flex items-center justify-center gap-2';
                            sideMainBtn.innerHTML = '<i class="fa-solid fa-circle-check text-sm"></i> Verifikasi QRIS &amp; Kirim ke Dapur';
                            sideMainBtn.dataset.action = 'verifikasi';
                            sideMainBtn.style.display = '';
                        } else if (pay === 'belum') {
                            sideMainBtn.className = 'btn-terima w-full bg-indigo-600 text-white font-bold py-2.5 rounded-xl hover:bg-indigo-700 text-xs shadow-sm flex items-center justify-center gap-2';
                            sideMainBtn.innerHTML = '<i class="fa-solid fa-cash-register text-sm"></i> Terima Pembayaran Tunai &amp; Kirim ke Dapur';
                            sideMainBtn.dataset.action = 'terima';
                            sideMainBtn.style.display = '';
                        } else {
                            sideMainBtn.style.display = 'none';
                        }
                    } else if (st === 'dapur') {
                        sideMainBtn.className = 'btn-advance w-full ' + (isTakeaway ? 'bg-amber-600 hover:bg-amber-700' : 'bg-indigo-600 hover:bg-indigo-700') + ' text-white font-bold py-2.5 rounded-xl text-xs shadow-sm flex items-center justify-center gap-2';
                        sideMainBtn.innerHTML = isTakeaway
                            ? '<i class="fa-solid fa-bullhorn text-sm"></i> Ubah ke Siap (Panggil Kasir)'
                            : '<i class="fa-solid fa-bell-concierge text-sm"></i> Ubah ke Siap (Antar ke Meja)';
                        sideMainBtn.dataset.action = 'advance';
                        sideMainBtn.style.display = '';
                    } else if (st === 'siap') {
                        sideMainBtn.className = 'btn-finish w-full bg-emerald-600 text-white font-bold py-2.5 rounded-xl hover:bg-emerald-700 text-xs shadow-sm flex items-center justify-center gap-2';
                        sideMainBtn.innerHTML = '<i class="fa-solid fa-circle-check text-sm"></i> Tandai Selesai';
                        sideMainBtn.dataset.action = 'finish';
                        sideMainBtn.style.display = '';
                    } else {
                        sideMainBtn.style.display = 'none';
                    }
                }

                function pilihKartu(card) {
                    if (!card) {
                        clearSidePanel();
                        return;
                    }

                    selectedCode = card.dataset.order;
                    currentCards.forEach((c) => c.classList.toggle('is-selected', c === card));
                    const isTakeaway = card.dataset.type === 'takeaway';
                    sideMeja.textContent = isTakeaway ? card.dataset.meja : 'MEJA ' + card.dataset.meja;
                    sideMeja.className = isTakeaway
                        ? 'bg-amber-100 text-amber-800 font-bold px-2 py-0.5 rounded text-[10px]'
                        : 'bg-indigo-100 text-indigo-700 font-bold px-2 py-0.5 rounded text-[10px]';

                    sideMeta.textContent = 'ID: ' + card.dataset.order + ' • Pelanggan: ' + card.dataset.pemesan;

                    const pay = card.dataset.payStatus;
                    const lunas = pay === 'lunas';
                    const belum = pay === 'belum';

                    sideStatus.textContent = lunas ? 'Lunas' : (belum ? 'Belum Bayar' : 'Perlu Verifikasi');
                    sideStatus.className = 'font-bold text-[10px] px-2 py-1 rounded-lg ' + (lunas
                        ? 'bg-emerald-100 text-emerald-800'
                        : (belum ? 'bg-rose-100 text-rose-700' : 'bg-amber-100 text-amber-800'));

                    if (payPanelTitle) {
                        payPanelTitle.innerHTML = belum
                            ? '<i class="fa-solid fa-cash-register mr-1"></i> PEMBAYARAN DI KASIR'
                            : '<i class="fa-solid fa-shield-check mr-1"></i> VERIFIKASI BUKTI TRANSFER QRIS';
                    }

                    payMatch.textContent = lunas ? 'Lunas : ' + card.dataset.total
                        : (belum ? 'Tagihan : ' + card.dataset.total : 'Cocok : ' + card.dataset.total);
                    payMatch.className = 'font-bold text-xs ' + (belum ? 'text-rose-600' : 'text-emerald-600');
                    payTime.textContent = card.dataset.payTime;
                    payMethod.textContent = card.dataset.payMethod;
                    payRrn.textContent = card.dataset.rrn;
                    payIntegrasi.innerHTML = lunas
                        ? '<i class="fa-solid fa-check mr-1"></i> Terverifikasi'
                        : (belum ? '<i class="fa-solid fa-hourglass-half mr-1"></i> Menunggu Pembayaran'
                            : '<i class="fa-solid fa-check mr-1"></i> Menunggu Verifikasi');
                    payIntegrasiRow.className = 'flex justify-between font-bold ' + (belum ? 'text-rose-600' : 'text-emerald-600');

                    updateStepper(card.dataset.status);
                    updateSideActions(card);
                }

                function updateStatCounts(counts) {
                    if (!counts) return;

                    const statAktif = document.getElementById('stat-aktif');
                    if (statAktif) statAktif.innerHTML = counts.aktif + ' <span class="text-xs font-normal text-gray-500">Order</span>';
                    const statVerif = document.getElementById('stat-verifikasi');
                    if (statVerif) statVerif.innerHTML = counts.verifikasi + ' <span class="text-xs font-normal text-gray-500">Order</span>';
                    const statDapur = document.getElementById('stat-dapur');
                    if (statDapur) statDapur.innerHTML = counts.dapur + ' <span class="text-xs font-normal text-gray-500">Order</span>';
                    const statSelesai = document.getElementById('stat-selesai');
                    if (statSelesai) statSelesai.innerHTML = counts.selesai + ' <span class="text-xs font-normal text-gray-500">Order</span>';

                    const badgeSemua = document.getElementById('badge-semua');
                    if (badgeSemua) badgeSemua.textContent = counts.total;
                    const badgeVerif = document.getElementById('badge-verifikasi');
                    if (badgeVerif) badgeVerif.textContent = counts.verifikasi;
                    const badgeDapur = document.getElementById('badge-dapur');
                    if (badgeDapur) badgeDapur.textContent = counts.dapur;
                    const badgeSiap = document.getElementById('badge-siap');
                    if (badgeSiap) badgeSiap.textContent = counts.siap;
                }

                function bindCards() {
                    currentCards = Array.from(ordersList.querySelectorAll('.order-card'));

                    if (currentCards.length === 0) {
                        clearSidePanel();
                    } else {
                        const match = selectedCode
                            ? currentCards.find((c) => c.dataset.order === selectedCode)
                            : null;
                        pilihKartu(match || currentCards[0]);
                    }

                    terapkanFilter();
                }

                const proofModal = document.getElementById('proof-modal');
                const proofOrder = document.getElementById('proof-order');
                const proofTotal = document.getElementById('proof-total');
                const proofTime = document.getElementById('proof-time');
                const proofMethod = document.getElementById('proof-method');
                const proofRrn = document.getElementById('proof-rrn');
                const proofNote = document.getElementById('proof-note');
                const btnModalVerif = document.getElementById('btn-modal-verif');

                function setModal(buka) { proofModal.classList.toggle('is-open', buka); }

                document.getElementById('btn-close-proof').addEventListener('click', () => setModal(false));
                const btnModalClose = document.getElementById('btn-modal-close');
                if (btnModalClose) btnModalClose.addEventListener('click', () => setModal(false));
                proofModal.addEventListener('click', (e) => { if (e.target === proofModal) setModal(false); });
                document.addEventListener('keydown', (e) => { if (e.key === 'Escape') setModal(false); });

                const actionMessages = {
                    verifikasi: 'Pembayaran QRIS berhasil diverifikasi. Pesanan dikirim ke dapur.',
                    terima: 'Pembayaran kasir diterima. Pesanan dikirim ke dapur.',
                    advance: 'Status pesanan diperbarui menjadi siap.',
                    finish: 'Pesanan ditandai selesai.',
                    cancel: 'Pesanan telah dibatalkan.',
                };

                async function sendAction(card, action, btn) {
                    const target = card || currentCards.find((c) => c.classList.contains('is-selected'));
                    if (!target) return;

                    if (action === 'cancel' && !window.confirm('Batalkan pesanan ' + target.dataset.order + '?')) {
                        return;
                    }

                    const code = target.dataset.order.replace(/^#/, '');
                    if (btn) btn.disabled = true;

                    try {
                        const response = await fetch(ordersBaseUrl + '/' + encodeURIComponent(code), {
                            method: 'PATCH',
                            headers: {
                                'Content-Type': 'application/json',
                                'Accept': 'application/json',
                                'X-CSRF-TOKEN': csrfToken,
                            },
                            body: JSON.stringify({ action }),
                        });

                        if (!response.ok) throw new Error('request failed');

                        toast(actionMessages[action] || 'Status pesanan diperbarui.');
                        selectedCode = target.dataset.order;
                        if (action === 'verifikasi' || action === 'terima') setModal(false);
                        await refreshFeed(true);
                    } catch (error) {
                        toast('Gagal memproses pesanan. Silakan coba lagi.');
                        if (btn) btn.disabled = false;
                    }
                }

                document.addEventListener('click', function (e) {
                    const btn = e.target.closest('button');
                    const card = e.target.closest('.order-card');

                    if (!btn) {
                        if (card && !e.target.closest('a')) pilihKartu(card);
                        return;
                    }

                    if (btn.dataset.action) {
                        sendAction(card, btn.dataset.action, btn);
                        return;
                    }

                    if (btn.classList.contains('btn-cek-bukti')) {
                        if (!card) return;
                        proofOrder.textContent = (card.dataset.type === 'takeaway' ? card.dataset.meja : 'MEJA ' + card.dataset.meja) + ' • ' + card.dataset.order;
                        proofTotal.textContent = card.dataset.total;
                        proofTime.textContent = card.dataset.payTime;
                        proofMethod.textContent = card.dataset.payMethod;
                        proofRrn.textContent = card.dataset.rrn;
                        const isLunas = card.dataset.payStatus === 'lunas';
                        proofNote.textContent = isLunas
                            ? 'QRIS sudah terverifikasi — nominal sesuai tagihan.'
                            : 'Nominal cocok dengan tagihan — silakan klik tombol verifikasi di bawah.';
                        if (btnModalVerif) btnModalVerif.classList.toggle('hidden', isLunas);
                        setModal(true);
                    } else if (btn.classList.contains('btn-cetak')) {
                        const target = card || currentCards.find((c) => c.classList.contains('is-selected'));
                        if (target) toast('Struk ' + target.dataset.order + ' dikirim ke printer thermal kasir');
                    } else if (btn.classList.contains('btn-kot')) {
                        toast('KOT dapur berhasil dicetak');
                    } else if (btn.classList.contains('btn-panggil-counter')) {
                        const target = card || currentCards.find((c) => c.classList.contains('is-selected'));
                        if (target) {
                            toast('🔔 Panggilan Kasir: "Pesanan ' + target.dataset.order + ' atas nama ' + target.dataset.pemesan + ' silakan ambil di counter kasir!"');
                        }
                    }
                });

                async function refreshFeed(force) {
                    try {
                        const response = await fetch(feedUrl, { headers: { 'Accept': 'application/json' } });
                        if (!response.ok) return;
                        const data = await response.json();

                        if (force || data.html !== lastHtml) {
                            lastHtml = data.html;
                            ordersList.innerHTML = data.html;
                            bindCards();
                        }

                        updateStatCounts(data.counts);
                    } catch (error) {
                        // retry on next poll
                    }
                }

                bindCards();
                refreshFeed(true);
                setInterval(() => refreshFeed(false), 4000);
            });
        </script>


    </body>
</html>