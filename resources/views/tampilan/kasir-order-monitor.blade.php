<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Kasir &amp; Order Monitor - HQ Coffee &amp; Bites</title>

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
                    <span class="text-[10px] text-indigo-600 font-medium">KASIR &amp; ORDER MONITOR (DINE-IN ONLY)</span>
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
                            <span class="text-xl font-black text-gray-900">6 <span class="text-xs font-normal text-gray-500">Meja</span></span>
                        </div>
                    </div>
                    <span class="bg-indigo-100 text-indigo-700 font-bold px-2 py-0.5 rounded text-[10px]">Live</span>
                </div>

                <div class="bg-white p-4 rounded-2xl border border-gray-100 shadow-sm flex items-center justify-between">
                    <div class="flex items-center space-x-3">
                        <div class="p-3 bg-amber-50 text-amber-600 rounded-xl"><i class="fa-solid fa-receipt text-lg"></i></div>
                        <div>
                            <span class="text-gray-400 font-semibold block">MENUNGGU VERIFIKASI</span>
                            <span class="text-xl font-black text-gray-900">2 <span class="text-xs font-normal text-gray-500">Meja</span></span>
                        </div>
                    </div>
                    <span class="bg-amber-100 text-amber-700 font-bold px-2 py-0.5 rounded text-[10px]">Perlu Cek</span>
                </div>

                <div class="bg-white p-4 rounded-2xl border border-gray-100 shadow-sm flex items-center justify-between">
                    <div class="flex items-center space-x-3">
                        <div class="p-3 bg-purple-50 text-purple-600 rounded-xl"><i class="fa-solid fa-utensils text-lg"></i></div>
                        <div>
                            <span class="text-gray-400 font-semibold block">DIPROSES DAPUR</span>
                            <span class="text-xl font-black text-gray-900">3 <span class="text-xs font-normal text-gray-500">Meja</span></span>
                        </div>
                    </div>
                    <span class="bg-purple-100 text-purple-700 font-bold px-2 py-0.5 rounded text-[10px]">Memasak</span>
                </div>

                <div class="bg-white p-4 rounded-2xl border border-gray-100 shadow-sm flex items-center justify-between">
                    <div class="flex items-center space-x-3">
                        <div class="p-3 bg-emerald-50 text-emerald-600 rounded-xl"><i class="fa-solid fa-circle-check text-lg"></i></div>
                        <div>
                            <span class="text-gray-400 font-semibold block">SELESAI HARI INI</span>
                            <span class="text-xl font-black text-gray-900">48 <span class="text-xs font-normal text-gray-500">Order</span></span>
                        </div>
                    </div>
                    <span class="bg-emerald-100 text-emerald-700 font-bold px-2 py-0.5 rounded text-[10px]">100% Lunas</span>
                </div>
            </div>

            <div class="flex flex-wrap items-center justify-between gap-3 bg-white p-3 rounded-2xl border border-gray-100">
                <div id="status-tabs" class="flex flex-wrap items-center gap-2">
                    <button type="button" data-filter="semua" class="status-btn bg-indigo-600 text-white font-bold px-3 py-1.5 rounded-xl">Semua <span class="bg-white text-indigo-600 px-1.5 py-0.5 rounded-full text-[10px]">8</span></button>
                    <button type="button" data-filter="verifikasi" class="status-btn bg-gray-50 text-gray-600 hover:bg-gray-100 font-medium px-3 py-1.5 rounded-xl border border-gray-100"><span class="inline-block w-1.5 h-1.5 bg-amber-500 rounded-full mr-1"></span>Menunggu Verifikasi <span class="bg-amber-100 text-amber-700 px-1.5 py-0.5 rounded-full text-[10px]">2</span></button>
                    <button type="button" data-filter="dapur" class="status-btn bg-gray-50 text-gray-600 hover:bg-gray-100 font-medium px-3 py-1.5 rounded-xl border border-gray-100"><i class="fa-solid fa-utensils mr-1"></i>Diproses Dapur <span class="bg-purple-100 text-purple-700 px-1.5 py-0.5 rounded-full text-[10px]">3</span></button>
                    <button type="button" data-filter="siap" class="status-btn bg-gray-50 text-gray-600 hover:bg-gray-100 font-medium px-3 py-1.5 rounded-xl border border-gray-100"><i class="fa-solid fa-bell-concierge mr-1"></i>Siap Diantar <span class="bg-blue-100 text-blue-700 px-1.5 py-0.5 rounded-full text-[10px]">1</span></button>
                    <button type="button" data-filter="selesai" class="status-btn bg-gray-50 text-gray-600 hover:bg-gray-100 font-medium px-3 py-1.5 rounded-xl border border-gray-100"><i class="fa-regular fa-circle-check mr-1"></i>Selesai</button>
                </div>

                <div class="flex flex-wrap items-center gap-3">
                    <div class="relative">
                        <i class="fa-solid fa-magnifying-glass absolute left-3 top-2.5 text-gray-400"></i>
                        <input id="order-search" type="text" placeholder="Cari no meja/cor..."
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

                        {{-- MEJA 03 : menunggu verifikasi QRIS --}}
                        <div class="order-card bg-white rounded-2xl p-4 border border-amber-200 shadow-sm space-y-3 cursor-pointer"
                            data-status="verifikasi" data-floor="1" data-meja="03" data-order="#ORD-0845"
                            data-pemesan="Hendra S." data-total="Rp 101.000"
                            data-pay-status="pending" data-pay-time="10:40:55 WIB"
                            data-pay-method="QRIS GPN (GoPay/BCA)" data-rrn="RRN-99203172681">
                            <div class="flex flex-wrap justify-between items-start gap-2">
                                <div class="flex items-center space-x-3">
                                    <span class="card-meja bg-indigo-100 text-indigo-700 font-bold px-3 py-1 rounded-xl text-xs">MEJA 03</span>
                                    <div>
                                        <span class="card-order font-bold text-gray-900">#ORD-0845</span>
                                        <span class="card-chip bg-amber-100 text-amber-800 font-bold text-[9px] px-2 py-0.5 rounded-full ml-2">PESANAN BARU</span>
                                        <p class="text-[10px] text-gray-400 mt-0.5">1 menit yang lalu • 10:41 WIB • Pemesan: Hendra S.</p>
                                    </div>
                                </div>
                                <span class="card-status bg-amber-100 text-amber-800 text-[10px] font-bold px-2.5 py-1 rounded-lg"><i class="fa-solid fa-receipt mr-1"></i> Menunggu Verifikasi QRIS</span>
                            </div>

                            <div class="space-y-2 border-t border-b border-gray-50 py-3">
                                <div class="flex justify-between font-medium">
                                    <span>2x Kopi Susu Aren HQ <span class="block text-[10px] text-gray-400 font-normal">Catatan: 1 Less Sugar, 1 Normal Ice; Less Ice</span></span>
                                    <span class="font-bold text-gray-800">Rp 44.000</span>
                                </div>
                                <div class="flex justify-between font-medium">
                                    <span>1x Rice Bowl Ayam Teriyaki <span class="block text-[10px] text-gray-400 font-normal">Catatan: Telur 3/4 matang, sambal dipisah</span></span>
                                    <span class="font-bold text-gray-800">Rp 35.000</span>
                                </div>
                                <div class="flex justify-between font-medium">
                                    <span>1x Cinnamon Roll Homemade <span class="block text-[10px] text-gray-400 font-normal">Catatan: Panaskan hangat di microwave</span></span>
                                    <span class="font-bold text-gray-800">Rp 22.000</span>
                                </div>
                            </div>

                            <div class="bg-indigo-50/50 p-2.5 rounded-xl flex flex-wrap justify-between items-center gap-2">
                                <span class="text-indigo-700 font-semibold text-[11px]"><i class="fa-solid fa-receipt mr-1"></i> Bukti Bayar QRIS: <strong>Rp 101.000</strong></span>
                                <button type="button" class="btn-cek-bukti bg-white border border-indigo-200 text-indigo-600 font-bold px-3 py-1 rounded-lg hover:bg-indigo-50"><i class="fa-solid fa-eye mr-1"></i> Cek Bukti QRIS</button>
                            </div>

                            <div class="flex flex-wrap justify-between items-center gap-2 pt-1">
                                <span class="font-bold text-sm">Total: <strong class="text-indigo-600 text-base">Rp 101.000</strong> <span class="text-gray-400 font-normal text-xs">(3 Item / 4 Porsi)</span></span>
                                <div class="card-action flex space-x-2">
                                    <button type="button" class="btn-tolak border border-rose-200 text-rose-600 font-bold px-3 py-1.5 rounded-xl hover:bg-rose-50"><i class="fa-regular fa-circle-xmark mr-1"></i> Tolak / Batal</button>
                                    <button type="button" class="btn-cetak bg-indigo-600 text-white font-bold px-4 py-1.5 rounded-xl hover:bg-indigo-700"><i class="fa-solid fa-print mr-1"></i> Cetak Struk</button>
                                </div>
                            </div>
                        </div>

                        {{-- MEJA 01 : diproses dapur --}}
                        <div class="order-card bg-white rounded-2xl p-4 border border-gray-100 shadow-sm space-y-3 cursor-pointer"
                            data-status="dapur" data-floor="1" data-meja="01" data-order="#ORD-0842"
                            data-pemesan="Barista Bar 1" data-total="Rp 77.000"
                            data-pay-status="lunas" data-pay-time="10:33:20 WIB"
                            data-pay-method="QRIS GPN (GoPay)" data-rrn="RRN-99203158442">
                            <div class="flex flex-wrap justify-between items-start gap-2">
                                <div class="flex items-center space-x-3">
                                    <span class="card-meja bg-indigo-100 text-indigo-700 font-bold px-3 py-1 rounded-xl text-xs">MEJA 01</span>
                                    <div>
                                        <span class="card-order font-bold text-gray-900">#ORD-0842</span>
                                        <span class="card-chip bg-purple-100 text-purple-800 font-bold text-[9px] px-2 py-0.5 rounded-full ml-2">DIPROSES DAPUR</span>
                                        <p class="text-[10px] text-gray-400 mt-0.5">8 menit yang lalu • 10:34 WIB • Barista Bar 1</p>
                                    </div>
                                </div>
                                <span class="card-status bg-emerald-100 text-emerald-800 text-[10px] font-bold px-2.5 py-1 rounded-lg"><i class="fa-solid fa-check mr-1"></i> Lunas (QRIS Terverifikasi)</span>
                            </div>

                            <div class="space-y-2 border-t border-b border-gray-50 py-3">
                                <div class="flex justify-between"><span>1x Sea Salt Latte (Normal Sweet)</span><span class="item-price text-gray-600">Rp 28.000</span></div>
                                <div class="flex justify-between"><span>1x French Fries Truffle</span><span class="item-price text-gray-600">Rp 25.000</span></div>
                                <div class="flex justify-between"><span>1x Thai Green Tea</span><span class="item-price text-gray-600">Rp 24.000</span></div>
                            </div>

                            <div class="flex flex-wrap justify-between items-center gap-2 pt-1">
                                <span class="font-bold text-sm">Total: <strong class="text-indigo-600 text-base">Rp 77.000</strong></span>
                                <div class="card-action">
                                    <button type="button" class="btn-advance bg-indigo-600 text-white font-bold px-4 py-2 rounded-xl hover:bg-indigo-700">
                                        Ubah ke: "Siap Diantar" <i class="fa-solid fa-bell ml-1"></i>
                                    </button>
                                </div>
                            </div>
                        </div>

                        {{-- MEJA 07 : siap diantar --}}
                        <div class="order-card bg-white rounded-2xl p-4 border border-gray-100 shadow-sm space-y-3 cursor-pointer"
                            data-status="siap" data-floor="2" data-meja="07" data-order="#ORD-0840"
                            data-pemesan="Walter Standby" data-total="Rp 92.000"
                            data-pay-status="lunas" data-pay-time="10:26:10 WIB"
                            data-pay-method="Tunai (Kasir)" data-rrn="-">
                            <div class="flex flex-wrap justify-between items-start gap-2">
                                <div class="flex items-center space-x-3">
                                    <span class="card-meja bg-indigo-100 text-indigo-700 font-bold px-3 py-1 rounded-xl text-xs">MEJA 07</span>
                                    <div>
                                        <span class="card-order font-bold text-gray-900">#ORD-0840</span>
                                        <span class="card-chip bg-blue-100 text-blue-800 font-bold text-[9px] px-2 py-0.5 rounded-full ml-2">SIAP DIANTAR</span>
                                        <p class="text-[10px] text-gray-400 mt-0.5">16 menit yang lalu • 10:26 WIB • Walter Standby</p>
                                    </div>
                                </div>
                                <span class="card-status bg-emerald-100 text-emerald-800 text-[10px] font-bold px-2.5 py-1 rounded-lg"><i class="fa-solid fa-money-bill-wave mr-1"></i> Lunas (Kasir Tunai)</span>
                            </div>

                            <div class="space-y-2 border-t border-b border-gray-50 py-3">
                                <div class="flex justify-between"><span>2x Kopi Susu Aren HQ</span><span class="item-price text-gray-600">Rp 44.000</span></div>
                                <div class="flex justify-between"><span>2x Croissant Butter Premium</span><span class="item-price text-gray-600">Rp 48.000</span></div>
                            </div>

                            <div class="flex flex-wrap justify-between items-center gap-2 pt-1">
                                <span class="font-bold text-sm">Total: <strong class="text-indigo-600 text-base">Rp 92.000</strong></span>
                                <div class="card-action">
                                    <button type="button" class="btn-finish bg-emerald-500 text-white font-bold px-4 py-2 rounded-xl hover:bg-emerald-600">
                                        <i class="fa-solid fa-circle-check mr-1"></i> Tandai 'Selesai' (Meja Bersih)
                                    </button>
                                </div>
                            </div>
                        </div>

                        {{-- MEJA 05 : belum bayar (bayar di kasir) --}}
                        <div class="order-card bg-white rounded-2xl p-4 border border-gray-100 shadow-sm space-y-3 cursor-pointer"
                            data-status="verifikasi" data-floor="2" data-meja="05" data-order="#ORD-0846"
                            data-pemesan="Tamu Memilih Bayar di Kasir" data-total="Rp 60.000"
                            data-pay-status="belum" data-pay-time="-"
                            data-pay-method="Bayar di Kasir (Tunai / EDC)" data-rrn="-">
                            <div class="flex flex-wrap justify-between items-start gap-2">
                                <div class="flex items-center space-x-3">
                                    <span class="card-meja bg-rose-100 text-rose-700 font-bold px-3 py-1 rounded-xl text-xs">MEJA 05</span>
                                    <div>
                                        <span class="card-order font-bold text-gray-900">#ORD-0846</span>
                                        <span class="card-chip bg-rose-100 text-rose-800 font-bold text-[9px] px-2 py-0.5 rounded-full ml-2">BELUM BAYAR</span>
                                        <p class="text-[10px] text-gray-400 mt-0.5">3 menit yang lalu • 10:39 WIB • Tamu Memilih Bayar di Kasir</p>
                                    </div>
                                </div>
                                <span class="card-status bg-rose-100 text-rose-700 text-[10px] font-bold px-2.5 py-1 rounded-lg"><i class="fa-solid fa-hand-holding-dollar mr-1"></i> Pilih Bayar di Kasir</span>
                            </div>

                            <div class="space-y-2 border-t border-b border-gray-50 py-3">
                                <div class="flex justify-between"><span>1x HQ Mixed Salad Bowl</span><span class="item-price text-gray-600">Rp 32.000</span></div>
                                <div class="flex justify-between"><span>1x Chicken Wrap Tortilla</span><span class="item-price text-gray-600">Rp 28.000</span></div>
                            </div>

                            <div class="flex flex-wrap justify-between items-center gap-2 pt-1">
                                <span class="font-bold text-sm">Total: <strong class="text-indigo-600 text-base">Rp 60.000</strong></span>
                                <div class="card-action">
                                    <button type="button" class="btn-terima bg-indigo-600 text-white font-bold px-4 py-2 rounded-xl hover:bg-indigo-700">
                                        <i class="fa-solid fa-cash-register mr-1"></i> Terima Pembayaran Tunai / EDC di Kasir
                                    </button>
                                </div>
                            </div>
                        </div>

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
                                <span class="font-bold text-indigo-900 text-xs"><i class="fa-solid fa-shield-check mr-1"></i> VERIFIKASI BUKTI TRANSFER QRIS</span>
                                <span id="pay-match" class="text-emerald-600 font-bold text-xs">Cocok : Rp 101.000</span>
                            </div>
                            <div class="text-[10px] space-y-1 text-gray-500 pt-1 border-t border-indigo-100/60">
                                <div class="flex justify-between"><span>Waktu Transaksi:</span><span id="pay-time" class="font-semibold text-gray-700">10:40:55 WIB</span></div>
                                <div class="flex justify-between"><span>Metode Bayar:</span><span id="pay-method" class="font-semibold text-gray-700">QRIS GPN (GoPay/BCA)</span></div>
                                <div class="flex justify-between"><span>Nomor RRN / Ref:</span><span id="pay-rrn" class="font-semibold text-gray-700">RRN-99203172681</span></div>
                                <div id="pay-integrasi-row" class="flex justify-between text-emerald-600 font-bold"><span>Status Integrasi:</span><span id="pay-integrasi"><i class="fa-solid fa-check mr-1"></i> Sesuai Tagihan</span></div>
                            </div>
                        </div>

                        <button type="button" class="btn-cetak w-full bg-indigo-600 text-white font-bold py-2.5 rounded-xl hover:bg-indigo-700 text-xs">
                            <i class="fa-solid fa-print mr-1"></i> Cetak Struk
                        </button>

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
            </div>
        </div>

        <div id="hq-toast" class="hq-toast" role="status" aria-live="polite"></div>

        <script>
            document.addEventListener('DOMContentLoaded', function () {
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
                const orderCards = Array.from(document.querySelectorAll('.order-card'));
                const ordersEmpty = document.getElementById('orders-empty');
                const statusBtns = document.querySelectorAll('.status-btn');
                const floorBtns = document.querySelectorAll('.floor-btn');
                const searchInput = document.getElementById('order-search');
                let filterStatus = 'semua';
                let filterFloor = 'semua';

                function terapkanFilter() {
                    const kata = searchInput.value.trim().toLowerCase();
                    let terlihat = 0;
                    orderCards.forEach((card) => {
                        const cocokStatus = filterStatus === 'semua' || card.dataset.status === filterStatus;
                        const cocokFloor = filterFloor === 'semua' || card.dataset.floor === filterFloor;
                        const teksCari = ('meja ' + card.dataset.meja + ' ' + card.dataset.order + ' ' + card.dataset.pemesan).toLowerCase();
                        const tampil = cocokStatus && cocokFloor && teksCari.includes(kata);
                        card.classList.toggle('hidden', !tampil);
                        if (tampil) terlihat++;
                    });
                    ordersEmpty.classList.toggle('hidden', terlihat > 0);
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

                const sideMeja = document.getElementById('side-meja');
                const sideMeta = document.getElementById('side-meta');
                const sideStatus = document.getElementById('side-status');
                const payMatch = document.getElementById('pay-match');
                const payTime = document.getElementById('pay-time');
                const payMethod = document.getElementById('pay-method');
                const payRrn = document.getElementById('pay-rrn');
                const payIntegrasi = document.getElementById('pay-integrasi');
                const payIntegrasiRow = document.getElementById('pay-integrasi-row');
                const stepper = document.getElementById('stepper');
                const statusIndex = { verifikasi: 1, dapur: 2, siap: 3, selesai: 4 };

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

                function pilihKartu(card) {
                    orderCards.forEach((c) => c.classList.toggle('is-selected', c === card));
                    sideMeja.textContent = 'MEJA ' + card.dataset.meja;
                    sideMeta.textContent = 'ID: ' + card.dataset.order + ' • Pelanggan: ' + card.dataset.pemesan;

                    const pay = card.dataset.payStatus;
                    const lunas = pay === 'lunas';
                    const belum = pay === 'belum';

                    sideStatus.textContent = lunas ? 'Lunas' : (belum ? 'Belum Bayar' : 'Perlu Verifikasi');
                    sideStatus.className = 'font-bold text-[10px] px-2 py-1 rounded-lg ' + (lunas
                        ? 'bg-emerald-100 text-emerald-800'
                        : (belum ? 'bg-rose-100 text-rose-700' : 'bg-amber-100 text-amber-800'));

                    payMatch.textContent = lunas ? 'Lunas : ' + card.dataset.total
                        : (belum ? 'Tagihan : ' + card.dataset.total : 'Cocok : ' + card.dataset.total);
                    payMatch.className = 'font-bold text-xs ' + (belum ? 'text-rose-600' : 'text-emerald-600');
                    payTime.textContent = card.dataset.payTime;
                    payMethod.textContent = card.dataset.payMethod;
                    payRrn.textContent = card.dataset.rrn;
                    payIntegrasi.innerHTML = lunas
                        ? '<i class="fa-solid fa-check mr-1"></i> Terverifikasi'
                        : (belum ? '<i class="fa-solid fa-hourglass-half mr-1"></i> Menunggu Pembayaran'
                            : '<i class="fa-solid fa-check mr-1"></i> Sesuai Tagihan');
                    payIntegrasiRow.className = 'flex justify-between font-bold ' + (belum ? 'text-rose-600' : 'text-emerald-600');

                    updateStepper(card.dataset.status);
                }

                pilihKartu(orderCards[0]);

                const proofModal = document.getElementById('proof-modal');
                const proofOrder = document.getElementById('proof-order');
                const proofTotal = document.getElementById('proof-total');
                const proofTime = document.getElementById('proof-time');
                const proofMethod = document.getElementById('proof-method');
                const proofRrn = document.getElementById('proof-rrn');
                const proofNote = document.getElementById('proof-note');

                function setModal(buka) { proofModal.classList.toggle('is-open', buka); }

                document.getElementById('btn-close-proof').addEventListener('click', () => setModal(false));
                proofModal.addEventListener('click', (e) => { if (e.target === proofModal) setModal(false); });
                document.addEventListener('keydown', (e) => { if (e.key === 'Escape') setModal(false); });

                // Ubah tampilan kartu (chip, badge status, status data)
                function ubahKartu(card, o) {
                    card.dataset.status = o.status;
                    if (o.payStatus) card.dataset.payStatus = o.payStatus;
                    const chip = card.querySelector('.card-chip');
                    chip.textContent = o.chip;
                    chip.className = 'card-chip font-bold text-[9px] px-2 py-0.5 rounded-full ml-2 ' + o.chipClass;
                    const st = card.querySelector('.card-status');
                    st.innerHTML = o.statusHtml;
                    st.className = 'card-status text-[10px] font-bold px-2.5 py-1 rounded-lg ' + o.statusClass;
                    const meja = card.querySelector('.card-meja');
                    meja.className = 'card-meja bg-indigo-100 text-indigo-700 font-bold px-3 py-1 rounded-xl text-xs';
                    if (o.actionHtml !== undefined) card.querySelector('.card-action').innerHTML = o.actionHtml;
                    if (card.classList.contains('is-selected')) pilihKartu(card);
                    terapkanFilter();
                }

                // Delegasi klik untuk seluruh halaman
                document.addEventListener('click', function (e) {
                    const btn = e.target.closest('button');
                    const card = e.target.closest('.order-card');

                    if (!btn) {
                        if (card && !e.target.closest('a')) pilihKartu(card);
                        return;
                    }

                    if (btn.classList.contains('btn-cek-bukti')) {
                        proofOrder.textContent = 'MEJA ' + card.dataset.meja + ' • ' + card.dataset.order;
                        proofTotal.textContent = card.dataset.total;
                        proofTime.textContent = card.dataset.payTime;
                        proofMethod.textContent = card.dataset.payMethod;
                        proofRrn.textContent = card.dataset.rrn;
                        proofNote.textContent = card.dataset.payStatus === 'lunas'
                            ? 'QRIS sudah terverifikasi — nominal sesuai tagihan.'
                            : 'Nominal cocok dengan tagihan — silakan verifikasi & cetak struk.';
                        setModal(true);
                    } else if (btn.classList.contains('btn-advance')) {
                        ubahKartu(card, {
                            status: 'siap', chip: 'SIAP DIANTAR', chipClass: 'bg-blue-100 text-blue-800',
                            statusHtml: '<i class="fa-solid fa-bell-concierge mr-1"></i> Siap Diantar',
                            statusClass: 'bg-blue-100 text-blue-800',
                            actionHtml: '<button type="button" class="btn-finish bg-emerald-500 text-white font-bold px-4 py-2 rounded-xl hover:bg-emerald-600"><i class="fa-solid fa-circle-check mr-1"></i> Tandai \'Selesai\' (Meja Bersih)</button>',
                        });
                        toast('Pesanan ' + card.dataset.order + ' diubah ke: Siap Diantar');
                    } else if (btn.classList.contains('btn-finish')) {
                        ubahKartu(card, {
                            status: 'selesai', chip: 'SELESAI', chipClass: 'bg-emerald-100 text-emerald-800',
                            statusHtml: '<i class="fa-solid fa-check mr-1"></i> Selesai (Meja Bersih)',
                            statusClass: 'bg-emerald-100 text-emerald-800', actionHtml: '',
                        });
                        toast('Pesanan ' + card.dataset.order + ' ditandai selesai');
                    } else if (btn.classList.contains('btn-terima')) {
                        card.dataset.payTime = '10:42:00 WIB';
                        ubahKartu(card, {
                            status: 'dapur', payStatus: 'lunas', chip: 'DIPROSES DAPUR', chipClass: 'bg-purple-100 text-purple-800',
                            statusHtml: '<i class="fa-solid fa-money-bill-wave mr-1"></i> Lunas (Kasir Tunai)',
                            statusClass: 'bg-emerald-100 text-emerald-800',
                            actionHtml: '<button type="button" class="btn-advance bg-indigo-600 text-white font-bold px-4 py-2 rounded-xl hover:bg-indigo-700">Ubah ke: "Siap Diantar" <i class="fa-solid fa-bell ml-1"></i></button>',
                        });
                        toast('Pembayaran ' + card.dataset.order + ' diterima, pesanan diteruskan ke dapur (demo)');
                    } else if (btn.classList.contains('btn-tolak')) {
                        const c = card || document.querySelector('.order-card.is-selected');
                        toast('Pesanan ' + (c ? c.dataset.order : '') + ' ditandai ditolak (demo — tidak ada perubahan nyata)');
                    } else if (btn.classList.contains('btn-cetak')) {
                        const c = card || document.querySelector('.order-card.is-selected') || orderCards[0];
                        toast('Struk ' + c.dataset.order + ' dikirim ke printer (demo)');
                    } else if (btn.classList.contains('btn-kot')) {
                        toast('KOT dikirim ke dapur/bar (demo)');
                    }
                });
            });
        </script>

    </body>
</html>