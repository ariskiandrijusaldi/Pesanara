<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Update Stok Menu — HQ Coffee & Bites</title>

        @fonts
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>

    @php
        // Ganti dengan data dari database (mis. $menus = Menu::paginate(8))
        $totalCatalog = 28;
        $hiddenLow = 1; // item menipis yang ada di halaman lain

        $categories = [
            ['label' => 'Semua Kategori', 'count' => 28],
            ['label' => 'Kopi & Espresso', 'count' => 10],
            ['label' => 'Non-Kopi & Teh', 'count' => 6],
            ['label' => 'Makanan Berat', 'count' => 7],
            ['label' => 'Camilan & Bites', 'count' => 5],
        ];

        $menus = [
            ['name' => 'Kopi Susu Aren HQ', 'best' => true, 'category' => 'Kopi & Espresso', 'sku' => 'HQ-CF-01', 'price' => 22000, 'stock' => 24, 'qr' => true, 'image' => 'kopi-susu-aren.jpg'],
            ['name' => 'Cinnamon Roll Homemade', 'category' => 'Camilan & Bites', 'sku' => 'HQ-BK-03', 'price' => 22000, 'stock' => 2, 'qr' => true, 'image' => 'cinnamon-roll.jpg'],
            ['name' => 'Croissant Butter Premium', 'category' => 'Camilan & Bites', 'sku' => 'HQ-BK-01', 'price' => 24000, 'stock' => 0, 'qr' => false, 'image' => 'croissant.jpg'],
            ['name' => 'Rice Bowl Ayam Teriyaki', 'category' => 'Makanan Berat', 'sku' => 'HQ-FD-02', 'price' => 35000, 'stock' => 8, 'qr' => true, 'image' => 'rice-bowl.jpg'],
            ['name' => 'Belgian Choco Cream', 'category' => 'Non-Kopi & Teh', 'sku' => 'HQ-NK-02', 'price' => 26000, 'stock' => 15, 'qr' => true, 'image' => 'belgian-choco.jpg'],
            ['name' => 'Sea Salt Latte', 'category' => 'Kopi & Espresso', 'sku' => 'HQ-CF-04', 'price' => 28000, 'stock' => 18, 'qr' => true, 'image' => 'sea-salt-latte.jpg'],
            ['name' => 'French Fries Truffle', 'category' => 'Camilan & Bites', 'sku' => 'HQ-SN-01', 'price' => 25000, 'stock' => 12, 'qr' => true, 'image' => 'fries-truffle.jpg'],
            ['name' => 'Thai Green Tea', 'category' => 'Non-Kopi & Teh', 'sku' => 'HQ-NK-05', 'price' => 24000, 'stock' => 20, 'qr' => true, 'image' => 'thai-green-tea.jpg'],
        ];
    @endphp

    <body class="min-h-screen overflow-x-hidden bg-[#FAFAFC] font-sans text-slate-600 antialiased">

        {{-- ===================== TOPBAR ===================== --}}
        <header class="border-b border-[#ECE9F6] bg-white">
            <div class="mx-auto flex max-w-6xl items-center justify-between gap-4 px-5 py-3 sm:px-6 lg:px-8">
                <a href="#" class="flex items-center gap-2.5">
                    <span class="grid h-9 w-9 place-items-center rounded-xl bg-[#7C3AED] text-white shadow-md shadow-[#7C3AED]/30">
                        <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                            <path d="M4 8h12v5a4 4 0 0 1-4 4H8a4 4 0 0 1-4-4V8Z" />
                            <path d="M16 9h1.5a2.5 2.5 0 0 1 0 5H16" />
                            <path d="M7 4.5v1.5M10 3.5v2.5M13 4.5v1.5" />
                        </svg>
                    </span>
                    <span class="leading-tight">
                        <span class="block text-sm font-bold text-[#1B1338]">HQ Coffee &amp; Bites</span>
                        <span class="block text-[10px] font-semibold uppercase tracking-wider text-[#7C3AED]">Kasir &amp; Operasional</span>
                    </span>
                </a>

                <div class="flex items-center gap-3">
                    <button type="button" class="rounded-full bg-[#7C3AED] px-4 py-1.5 text-xs font-semibold text-white transition hover:bg-[#6D28D9]">
                        Tutup Shift
                    </button>
                    <div class="flex items-center gap-2.5 rounded-full bg-[#F3F0FD] py-1 pl-1 pr-3">
                        <span class="grid h-7 w-7 place-items-center rounded-full bg-[#7C3AED] text-white">
                            <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                                <circle cx="12" cy="8" r="4" />
                                <path d="M4 21a8 8 0 0 1 16 0" />
                            </svg>
                        </span>
                        <span class="hidden text-right leading-tight sm:block">
                            <span class="block text-xs font-semibold text-[#1B1338]">Siti Nurhaliza</span>
                            <span class="block text-[10px] text-slate-500">Cashier #02</span>
                        </span>
                    </div>
                </div>
            </div>
        </header>

        <main class="mx-auto max-w-6xl px-5 py-8 sm:px-6 lg:px-8">

            {{-- ===================== JUDUL ===================== --}}
            <div class="flex items-center gap-2">
                <span class="rounded-full bg-[#EDE9FE] px-2.5 py-1 text-[10px] font-bold uppercase tracking-wider text-[#6D28D9]">Inventaris Live Menu</span>
                <span class="text-xs text-slate-500">Terminal Kasir v2.4</span>
            </div>
            <h1 class="mt-3 text-4xl font-bold tracking-tight text-[#1B1338] sm:text-5xl">Update Stok Menu</h1>
            <p class="mt-3 max-w-md text-sm leading-relaxed text-slate-500">
                Sinkronisasi real-time langsung ke smartphone pemesanan QR pelanggan di setiap meja dalam hitungan milidetik.
            </p>

            {{-- Status bar --}}
            <div class="mt-5 flex flex-wrap items-center gap-x-4 gap-y-2 rounded-2xl border border-[#ECE9F6] bg-[#F7F5FE] px-4 py-2.5 text-xs">
                <span class="inline-flex items-center gap-1.5 font-semibold text-[#6D28D9]"><span class="h-1.5 w-1.5 rounded-full bg-[#7C3AED]"></span>Online System</span>
                <span class="text-slate-600"><b class="text-[#1B1338]">{{ $totalCatalog }}</b> Menu Terdaftar</span>
                <span class="inline-flex items-center gap-1.5 text-slate-600"><span class="h-1.5 w-1.5 rounded-full bg-[#7C3AED]"></span><b id="bar-low" class="text-[#1B1338]">0</b> Menipis</span>
                <span class="inline-flex items-center gap-1.5 text-slate-600"><span class="h-1.5 w-1.5 rounded-full bg-red-500"></span><b id="bar-out" class="text-red-600">0</b> Habis</span>
            </div>

            {{-- ===================== KARTU RINGKASAN ===================== --}}
            <section class="mt-6 grid gap-4 sm:grid-cols-2 lg:grid-cols-4" aria-label="Ringkasan stok">
                <article class="rounded-2xl border border-[#ECE9F6] bg-white p-5 shadow-sm">
                    <div class="flex items-start justify-between">
                        <p class="text-[10px] font-bold uppercase tracking-wider text-slate-500">Total Menu Aktif</p>
                        <span class="grid h-9 w-9 place-items-center rounded-xl bg-[#EDE9FE] text-[#7C3AED]">
                            <svg class="h-4.5 w-4.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M7 3v8a2 2 0 0 0 2 2v8M5 3v5M9 3v5M17 21V3c-2 2-3 5-3 8h3" /></svg>
                        </span>
                    </div>
                    <p class="mt-4 flex items-baseline gap-1.5"><span class="text-4xl font-bold text-[#1B1338]">{{ $totalCatalog }}</span><span class="text-sm text-slate-600">Item Katalog</span></p>
                    <p class="mt-2 inline-flex items-center gap-1 text-xs font-medium text-[#6D28D9]">
                        <svg class="h-3.5 w-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><circle cx="12" cy="12" r="9" /><path d="m9 12 2 2 4-4" /></svg>
                        Semua kategori aktif
                    </p>
                </article>

                <article class="rounded-2xl border border-[#ECE9F6] bg-white p-5 shadow-sm">
                    <div class="flex items-start justify-between">
                        <p class="text-[10px] font-bold uppercase tracking-wider text-slate-500">Stok Tersedia Normal</p>
                        <span class="grid h-9 w-9 place-items-center rounded-xl bg-[#EDE9FE] text-[#7C3AED]">
                            <svg class="h-4.5 w-4.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><circle cx="12" cy="12" r="9" /><path d="m9 12 2 2 4-4" /></svg>
                        </span>
                    </div>
                    <p class="mt-4 flex items-baseline gap-1.5"><span id="card-normal" class="text-4xl font-bold text-[#1B1338]">0</span><span class="text-sm text-slate-600">Menu (Aman)</span></p>
                    <div class="mt-3 h-1.5 w-full overflow-hidden rounded-full bg-[#EDE9FE]">
                        <div id="card-normal-bar" class="h-full rounded-full bg-[#7C3AED] transition-all duration-300" style="width: 0%"></div>
                    </div>
                </article>

                <article class="rounded-2xl border border-[#ECE9F6] bg-white p-5 shadow-sm">
                    <div class="flex items-start justify-between">
                        <p class="text-[10px] font-bold uppercase tracking-wider text-slate-500">Peringatan Menipis</p>
                        <span class="grid h-9 w-9 place-items-center rounded-xl bg-[#EDE9FE] text-[#7C3AED]">
                            <svg class="h-4.5 w-4.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M12 9v4m0 4h.01M10.3 3.9 1.8 18a2 2 0 0 0 1.7 3h17a2 2 0 0 0 1.7-3L13.7 3.9a2 2 0 0 0-3.4 0Z" /></svg>
                        </span>
                    </div>
                    <p class="mt-4 flex items-baseline gap-1.5"><span id="card-low" class="text-4xl font-bold text-[#7C3AED]">0</span><span class="text-sm text-slate-600">Perlu Restock</span></p>
                    <p class="mt-2 text-xs font-medium text-[#6D28D9]"><span class="font-bold">!</span> Di bawah batas minimum (&lt; 5)</p>
                </article>

                <article class="rounded-2xl border border-[#ECE9F6] bg-white p-5 shadow-sm">
                    <div class="flex items-start justify-between">
                        <p class="text-[10px] font-bold uppercase tracking-wider text-slate-500">Stok Habis (Sold Out)</p>
                        <span class="grid h-9 w-9 place-items-center rounded-xl bg-red-50 text-red-500">
                            <svg class="h-4.5 w-4.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><circle cx="12" cy="12" r="9" /><path d="m5.6 5.6 12.8 12.8" /></svg>
                        </span>
                    </div>
                    <p class="mt-4 flex items-baseline gap-1.5"><span id="card-out" class="text-4xl font-bold text-red-600">0</span><span class="text-sm text-slate-600">Terkunci QR</span></p>
                    <p id="card-out-names" class="mt-2 truncate text-xs font-medium text-red-600">—</p>
                </article>
            </section>

            {{-- ===================== PENCARIAN & FILTER ===================== --}}
            <section class="mt-6 rounded-2xl border border-[#ECE9F6] bg-white p-4 shadow-sm">
                <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
                    <label class="relative block w-full sm:max-w-sm">
                        <span class="sr-only">Cari menu</span>
                        <svg class="pointer-events-none absolute left-3 top-1/2 h-4 w-4 -translate-y-1/2 text-slate-400" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><circle cx="11" cy="11" r="7" /><path d="m20 20-3.5-3.5" /></svg>
                        <input id="search" type="search" placeholder="Cari nama menu, barcode, atau SKU..." class="w-full rounded-xl border-0 bg-[#F3F0FD] py-2.5 pl-9 pr-12 text-sm text-[#1B1338] placeholder:text-slate-400 focus:outline-none focus:ring-2 focus:ring-[#7C3AED]/40">
                        <kbd class="absolute right-3 top-1/2 -translate-y-1/2 rounded bg-white px-1.5 py-0.5 text-[10px] font-semibold text-slate-400">⌘K</kbd>
                    </label>

                    <a href="#" class="inline-flex items-center justify-center gap-2 rounded-xl bg-[#7C3AED] px-5 py-2.5 text-sm font-semibold text-white shadow-md shadow-[#7C3AED]/25 transition hover:bg-[#6D28D9]">
                        <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><circle cx="12" cy="12" r="9" /><path d="M12 8v8M8 12h8" /></svg>
                        Tambah Menu Baru
                    </a>
                </div>

                <div class="mt-3 flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
                    <div id="category-filters" class="flex flex-wrap gap-2">
                        @foreach ($categories as $i => $cat)
                            <button type="button" data-category="{{ $i === 0 ? 'all' : $cat['label'] }}"
                                class="cat-btn rounded-full px-3.5 py-1.5 text-xs font-semibold transition {{ $i === 0 ? 'bg-[#7C3AED] text-white' : 'bg-[#F3F0FD] text-[#6D28D9] hover:bg-[#E6DFFB]' }}">
                                {{ $cat['label'] }} ({{ $cat['count'] }})
                            </button>
                        @endforeach
                    </div>
                    <label class="flex items-center gap-2 text-xs text-slate-500">
                        Status:
                        <select id="status-filter" class="rounded-full border-0 bg-[#F3F0FD] py-1.5 pl-3 pr-8 text-xs font-semibold text-[#1B1338] focus:outline-none focus:ring-2 focus:ring-[#7C3AED]/40">
                            <option value="all">Semua Status</option>
                            <option value="ok">Tersedia</option>
                            <option value="low">Menipis</option>
                            <option value="out">Sold Out</option>
                        </select>
                    </label>
                </div>
            </section>

            {{-- ===================== TABEL STOK ===================== --}}
            <section class="mt-6 overflow-hidden rounded-2xl border border-[#ECE9F6] bg-white shadow-sm">
                <div class="overflow-x-auto">
                    <div class="min-w-[760px]">
                        <div class="grid grid-cols-[2.2fr_1fr_1.3fr_1.4fr] items-center border-b border-[#ECE9F6] bg-[#F7F5FE] px-5 py-3 text-[10px] font-bold uppercase tracking-wider text-slate-500">
                            <span>Informasi Produk &amp; Harga</span>
                            <span class="text-center">Status</span>
                            <span class="text-center">Stok Terbuka</span>
                            <span class="text-right">Aksi QR &amp; Kasir</span>
                        </div>

                        <ul id="stock-list" class="divide-y divide-[#F1EEFA]">
                            @foreach ($menus as $m)
                                <li class="stock-row grid grid-cols-[2.2fr_1fr_1.3fr_1.4fr] items-center px-5 py-3 transition-colors"
                                    data-name="{{ $m['name'] }}"
                                    data-sku="{{ $m['sku'] }}"
                                    data-category="{{ $m['category'] }}"
                                    data-stock="{{ $m['stock'] }}"
                                    data-qr="{{ $m['qr'] ? '1' : '0' }}">

                                    {{-- Produk --}}
                                    <div class="flex items-center gap-3">
                                        <div class="relative grid h-10 w-10 shrink-0 place-items-center overflow-hidden rounded-lg bg-gradient-to-b from-[#F1ECFE] to-[#F8F6FF] text-[#7C3AED]/40">
                                            <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M4 8h12v5a4 4 0 0 1-4 4H8a4 4 0 0 1-4-4V8Z" /><path d="M16 9h1.5a2.5 2.5 0 0 1 0 5H16" /></svg>
                                            <img src="{{ asset('images/menu/' . $m['image']) }}" alt="{{ $m['name'] }}" class="absolute inset-0 h-full w-full object-cover" onerror="this.remove()">
                                        </div>
                                        <div class="min-w-0">
                                            <p class="flex items-center gap-1.5 text-sm font-semibold text-[#1B1338]">
                                                <span class="truncate">{{ $m['name'] }}</span>
                                                @if (!empty($m['best']))
                                                    <span class="rounded bg-[#EDE9FE] px-1 py-px text-[8px] font-bold uppercase text-[#6D28D9]">Best</span>
                                                @endif
                                            </p>
                                            <p class="text-[11px] text-slate-500">{{ $m['category'] }} • SKU: {{ $m['sku'] }}</p>
                                            <p class="text-[11px] font-bold text-[#7C3AED]">Rp {{ number_format($m['price'], 0, ',', '.') }}</p>
                                        </div>
                                    </div>

                                    {{-- Status --}}
                                    <div class="text-center">
                                        <span class="status-badge inline-block rounded-full px-2.5 py-1 text-[10px] font-bold uppercase tracking-wide"></span>
                                    </div>

                                    {{-- Stok --}}
                                    <div class="flex items-center justify-center gap-2">
                                        <button type="button" class="btn-minus grid h-6 w-6 place-items-center rounded-full border border-[#E4DFF3] text-slate-600 transition hover:bg-[#F3F0FD]" aria-label="Kurangi stok {{ $m['name'] }}">−</button>
                                        <div class="w-14 rounded-lg border border-[#E4DFF3] bg-white py-1 text-center">
                                            <span class="stock-value block text-base font-bold leading-none text-[#1B1338]">0</span>
                                            <span class="block text-[9px] text-slate-400">porsi</span>
                                        </div>
                                        <button type="button" class="btn-plus grid h-6 w-6 place-items-center rounded-full border border-[#E4DFF3] text-slate-600 transition hover:bg-[#F3F0FD]" aria-label="Tambah stok {{ $m['name'] }}">+</button>
                                    </div>

                                    {{-- Aksi --}}
                                    <div class="flex items-center justify-end gap-2.5">
                                        <button type="button" class="quick-restock hidden rounded-md bg-[#EDE9FE] px-2 py-1 text-[10px] font-bold text-[#6D28D9] transition hover:bg-[#DDD3FB]" data-amount="10">+10 Restock</button>
                                        <button type="button" class="quick-open hidden rounded-md bg-[#7C3AED] px-2 py-1 text-[10px] font-bold text-white transition hover:bg-[#6D28D9]" data-amount="3">Buka (+3)</button>

                                        <div class="flex flex-col items-center gap-0.5">
                                            <button type="button" role="switch" aria-checked="false" class="qr-switch relative h-5 w-9 rounded-full bg-slate-200 transition-colors" aria-label="Buka di QR {{ $m['name'] }}">
                                                <span class="absolute left-0.5 top-0.5 h-4 w-4 rounded-full bg-white shadow transition-transform"></span>
                                            </button>
                                            <span class="qr-label text-[9px] text-slate-500">Buka di QR</span>
                                        </div>

                                        <button type="button" class="btn-save grid h-6 w-6 place-items-center rounded-full border border-[#E4DFF3] text-[#7C3AED] transition hover:bg-[#F3F0FD]" aria-label="Simpan {{ $m['name'] }}">
                                            <svg class="h-3.5 w-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="m5 12 5 5 9-10" /></svg>
                                        </button>
                                    </div>
                                </li>
                            @endforeach
                        </ul>

                        <p id="empty-state" class="hidden px-5 py-10 text-center text-sm text-slate-500">Tidak ada menu yang cocok. Ubah kata kunci atau filter.</p>
                    </div>
                </div>

                {{-- Pagination --}}
                <div class="flex flex-col items-center justify-between gap-3 border-t border-[#ECE9F6] bg-[#F7F5FE] px-5 py-3 text-xs text-slate-500 sm:flex-row">
                    <p>Menampilkan <span id="shown-count">{{ count($menus) }}</span> dari {{ $totalCatalog }} Menu Terdaftar</p>
                    <nav class="flex items-center gap-1" aria-label="Halaman">
                        <span class="px-2 text-slate-400">Sebelumnya</span>
                        <a href="#" aria-current="page" class="grid h-6 w-6 place-items-center rounded-md bg-white font-bold text-[#7C3AED] shadow-sm">1</a>
                        <a href="#" class="grid h-6 w-6 place-items-center rounded-md hover:bg-white">2</a>
                        <a href="#" class="grid h-6 w-6 place-items-center rounded-md hover:bg-white">3</a>
                        <a href="#" class="rounded-md bg-white px-2.5 py-1 font-semibold text-[#1B1338] shadow-sm">Berikutnya</a>
                    </nav>
                </div>
            </section>

            {{-- Info koneksi QR --}}
            <aside class="mt-4 flex items-start gap-3 rounded-2xl border border-[#E4DFF3] bg-[#F3F0FD] p-4">
                <span class="grid h-10 w-10 shrink-0 place-items-center rounded-xl bg-[#7C3AED] text-white">
                    <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M3 7V5a2 2 0 0 1 2-2h2M17 3h2a2 2 0 0 1 2 2v2M21 17v2a2 2 0 0 1-2 2h-2M7 21H5a2 2 0 0 1-2-2v-2M8 12h8" /></svg>
                </span>
                <div>
                    <p class="text-sm font-bold text-[#1B1338]">Koneksi QR Meja Real-time</p>
                    <p class="mt-0.5 text-xs leading-relaxed text-slate-600">Item dengan stok '0' atau switch OFF otomatis diberi label abu-abu "Habis" pada HP tamu meja 1–18.</p>
                </div>
            </aside>
        </main>

        {{-- ===================== FOOTER ===================== --}}
        <footer class="mt-10 border-t border-[#ECE9F6] bg-white">
            <div class="mx-auto flex max-w-6xl flex-col items-center justify-between gap-2 px-5 py-4 text-[11px] text-slate-500 sm:flex-row sm:px-6 lg:px-8">
                <p><span class="mr-2 font-bold text-[#7C3AED]">HQ</span>© {{ date('Y') }} HQ Coffee &amp; Bites. Terminal Operasional &amp; Kasir Terpadu v2.4</p>
                <p class="flex items-center gap-3">
                    <span>Status Jaringan: Optimal</span>
                    <span>•</span>
                    <span>Thermal Printer: Terhubung</span>
                    <span>•</span>
                    <span>Support Kasir: ext 104</span>
                </p>
            </div>
        </footer>

        {{-- ===================== SCRIPT ===================== --}}
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                const LOW_LIMIT = 5;                       // stok <= 5 dianggap menipis
                const TOTAL = {{ $totalCatalog }};
                const HIDDEN_LOW = {{ $hiddenLow }};       // menipis di halaman lain
                const rows = Array.from(document.querySelectorAll('.stock-row'));
                const q = (id) => document.getElementById(id);

                let activeCategory = 'all';

                const state = (stock, qr) => (stock <= 0 || !qr ? 'out' : stock <= LOW_LIMIT ? 'low' : 'ok');

                function renderRow(row) {
                    const stock = parseInt(row.dataset.stock, 10);
                    const qr = row.dataset.qr === '1';
                    const st = state(stock, qr);

                    row.dataset.state = st;
                    row.querySelector('.stock-value').textContent = stock;
                    row.classList.toggle('bg-red-50/60', st === 'out');

                    const badge = row.querySelector('.status-badge');
                    badge.className = 'status-badge inline-block rounded-full px-2.5 py-1 text-[10px] font-bold uppercase tracking-wide ' +
                        (st === 'out' ? 'bg-orange-100 text-orange-600' : 'bg-[#EDE9FE] text-[#6D28D9]');
                    badge.textContent = st === 'out' ? 'Sold Out' : st === 'low' ? 'Sisa ' + stock : 'Tersedia';

                    row.querySelector('.stock-value').classList.toggle('text-red-600', stock === 0);

                    const sw = row.querySelector('.qr-switch');
                    sw.setAttribute('aria-checked', qr ? 'true' : 'false');
                    sw.classList.toggle('bg-[#7C3AED]', qr);
                    sw.classList.toggle('bg-slate-200', !qr);
                    sw.firstElementChild.classList.toggle('translate-x-4', qr);

                    const label = row.querySelector('.qr-label');
                    label.textContent = qr ? 'Buka di QR' : 'Terkunci QR';
                    label.classList.toggle('text-red-500', !qr);

                    row.querySelector('.quick-restock').classList.toggle('hidden', st !== 'low');
                    row.querySelector('.quick-open').classList.toggle('hidden', stock !== 0);
                }

                function renderSummary() {
                    const states = rows.map((r) => r.dataset.state);
                    const out = states.filter((s) => s === 'out').length;
                    const low = states.filter((s) => s === 'low').length + HIDDEN_LOW;
                    const normal = TOTAL - out - low;

                    q('bar-low').textContent = low;
                    q('bar-out').textContent = out;
                    q('card-low').textContent = low;
                    q('card-out').textContent = out;
                    q('card-normal').textContent = normal;
                    q('card-normal-bar').style.width = Math.round((normal / TOTAL) * 100) + '%';

                    const names = rows.filter((r) => r.dataset.state === 'out').map((r) => r.dataset.name);
                    q('card-out-names').textContent = names.length ? names.join(', ') : 'Tidak ada';
                }

                function applyFilters() {
                    const term = q('search').value.trim().toLowerCase();
                    const status = q('status-filter').value;
                    let shown = 0;

                    rows.forEach((row) => {
                        const matchText = !term || row.dataset.name.toLowerCase().includes(term) || row.dataset.sku.toLowerCase().includes(term);
                        const matchCat = activeCategory === 'all' || row.dataset.category === activeCategory;
                        const matchStatus = status === 'all' || row.dataset.state === status;
                        const visible = matchText && matchCat && matchStatus;
                        row.classList.toggle('hidden', !visible);
                        if (visible) shown++;
                    });

                    q('shown-count').textContent = shown;
                    q('empty-state').classList.toggle('hidden', shown > 0);
                }

                function update(row, stock, qr) {
                    row.dataset.stock = Math.max(0, stock);
                    if (qr !== undefined) row.dataset.qr = qr ? '1' : '0';
                    renderRow(row);
                    renderSummary();
                    applyFilters();
                }

                rows.forEach((row) => {
                    const stock = () => parseInt(row.dataset.stock, 10);

                    row.querySelector('.btn-plus').addEventListener('click', () => update(row, stock() + 1));
                    row.querySelector('.btn-minus').addEventListener('click', () => update(row, stock() - 1));

                    row.querySelector('.qr-switch').addEventListener('click', () => update(row, stock(), row.dataset.qr !== '1'));

                    [['.quick-restock'], ['.quick-open']].forEach(([sel]) => {
                        const btn = row.querySelector(sel);
                        btn.addEventListener('click', () => update(row, stock() + parseInt(btn.dataset.amount, 10), true));
                    });

                    row.querySelector('.btn-save').addEventListener('click', function () {
                        // TODO: kirim ke backend, mis. fetch('/stok/' + id, { method: 'PATCH', body: JSON.stringify({ stock, qr }) })
                        this.classList.add('bg-[#7C3AED]', 'text-white');
                        setTimeout(() => this.classList.remove('bg-[#7C3AED]', 'text-white'), 700);
                    });

                    renderRow(row);
                });

                document.querySelectorAll('.cat-btn').forEach((btn) => {
                    btn.addEventListener('click', () => {
                        activeCategory = btn.dataset.category;
                        document.querySelectorAll('.cat-btn').forEach((b) => {
                            const on = b === btn;
                            b.classList.toggle('bg-[#7C3AED]', on);
                            b.classList.toggle('text-white', on);
                            b.classList.toggle('bg-[#F3F0FD]', !on);
                            b.classList.toggle('text-[#6D28D9]', !on);
                        });
                        applyFilters();
                    });
                });

                q('search').addEventListener('input', applyFilters);
                q('status-filter').addEventListener('change', applyFilters);

                document.addEventListener('keydown', (e) => {
                    if ((e.metaKey || e.ctrlKey) && e.key.toLowerCase() === 'k') {
                        e.preventDefault();
                        q('search').focus();
                    }
                });

                renderSummary();
                applyFilters();
            });
        </script>
    </body>
</html>