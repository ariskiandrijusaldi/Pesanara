<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Self-Order — HQ Coffee | Pesanara</title>
        <meta name="description" content="Pesan menu HQ Coffee langsung dari meja kamu. Self-order cepat, bayar QRIS, tanpa antre.">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <script>document.documentElement.classList.add('js');</script>

        @fonts

        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>

    <body class="bg-[#FAFAFC] font-sans text-slate-600 antialiased">
        {{-- ===================== TOP BAR ===================== --}}
        <header class="site-header sticky top-0 z-40 border-b border-[#ECE9F6] bg-white/90 backdrop-blur-md">
            <div class="mx-auto flex max-w-7xl flex-col gap-3 px-4 py-3.5 sm:px-6 lg:flex-row lg:items-center lg:justify-between lg:gap-5 lg:px-8">
                {{-- Logo / Nomor Meja --}}
                <div class="flex items-center gap-3">
                    <span id="header-table-box" class="grid h-11 w-11 shrink-0 place-items-center rounded-2xl bg-[#7C3AED] text-xs font-bold leading-none tracking-wide text-white shadow-md shadow-[#7C3AED]/30">
                        MEJA<br>01
                    </span>
                    <div class="min-w-0">
                        <div class="flex flex-wrap items-center gap-2">
                            <h1 class="text-base font-bold tracking-tight text-[#1B1338] sm:text-lg">Self-Order HQ Coffee</h1>
                            <span id="header-order-badge" class="inline-flex items-center gap-1.5 rounded-full bg-[#ECFDF5] px-2.5 py-1 text-[11px] font-semibold text-[#059669] transition">
                                <span id="header-order-dot" class="h-1.5 w-1.5 animate-pulse rounded-full bg-[#10B981]"></span>
                                <span id="header-order-text">Dine-In Aktif</span>
                            </span>
                        </div>
                        <p id="header-order-desc" class="mt-0.5 text-xs text-slate-500">Pesan langsung dari meja, tanpa antre</p>
                    </div>
                </div>

                {{-- Search Bar & Info Estimasi --}}
                <div class="flex items-center gap-3">
                    <div class="relative flex-1 lg:w-80 lg:flex-none">
                        <svg class="pointer-events-none absolute left-3.5 top-1/2 h-4 w-4 -translate-y-1/2 text-slate-400" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                            <circle cx="11" cy="11" r="7" />
                            <path d="m20 20-3.5-3.5" />
                        </svg>
                        <input
                            id="menu-search"
                            type="search"
                            placeholder="Cari kopi, pastry, rice bowl..."
                            class="w-full rounded-full border border-[#E4DFF3] bg-white py-2.5 pl-10 pr-4 text-sm text-[#1B1338] placeholder:text-slate-400 focus:border-[#7C3AED] focus:outline-none focus:ring-2 focus:ring-[#7C3AED]/20"
                            aria-label="Cari menu"
                        >
                    </div>
                    <span class="inline-flex shrink-0 items-center gap-1.5 rounded-full border border-[#EDE9FE] bg-[#F3F0FD] px-3.5 py-2 text-xs font-semibold text-[#6D28D9]">
                        <svg class="h-3.5 w-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                            <circle cx="12" cy="12" r="9" />
                            <path d="M12 7v5l3 2" />
                        </svg>
                        Estimasi: 10–15 Menit
                    </span>
                </div>
            </div>
        </header>

        <main class="mx-auto flex max-w-7xl flex-col gap-6 px-4 py-6 sm:px-6 lg:flex-row lg:items-start lg:gap-7 lg:px-8">
            {{-- ================================================================== --}}
            {{-- KOLOM KIRI — KATEGORI & KATALOG MENU                                --}}
            {{-- ================================================================== --}}
            <div class="min-w-0 flex-1 lg:w-2/3">
                {{-- Kategori Filter (Tabs) --}}
                <div class="-mx-4 overflow-x-auto px-4 pb-1 sm:mx-0 sm:px-0">
                    <div class="flex w-max items-center gap-2 pb-2" role="tablist" aria-label="Filter kategori menu">
                        <button type="button" class="category-tab is-active whitespace-nowrap rounded-full bg-[#7C3AED] px-4 py-2 text-sm font-semibold text-white shadow-sm transition" data-category="all" role="tab" aria-selected="true">Semua Menu</button>
                        <button type="button" class="category-tab whitespace-nowrap rounded-full border border-[#E4DFF3] bg-white px-4 py-2 text-sm font-medium text-slate-600 transition hover:border-[#C9BFEA] hover:bg-[#F3F0FD] hover:text-[#6D28D9]" data-category="signature" role="tab" aria-selected="false">Signature Coffee</button>
                        <button type="button" class="category-tab whitespace-nowrap rounded-full border border-[#E4DFF3] bg-white px-4 py-2 text-sm font-medium text-slate-600 transition hover:border-[#C9BFEA] hover:bg-[#F3F0FD] hover:text-[#6D28D9]" data-category="noncoffee" role="tab" aria-selected="false">Non-Coffee &amp; Tea</button>
                        <button type="button" class="category-tab whitespace-nowrap rounded-full border border-[#E4DFF3] bg-white px-4 py-2 text-sm font-medium text-slate-600 transition hover:border-[#C9BFEA] hover:bg-[#F3F0FD] hover:text-[#6D28D9]" data-category="pastry" role="tab" aria-selected="false">Artisanal Bites &amp; Pastry</button>
                        <button type="button" class="category-tab whitespace-nowrap rounded-full border border-[#E4DFF3] bg-white px-4 py-2 text-sm font-medium text-slate-600 transition hover:border-[#C9BFEA] hover:bg-[#F3F0FD] hover:text-[#6D28D9]" data-category="main" role="tab" aria-selected="false">Main Course</button>
                    </div>
                </div>

                {{-- Banner Promo (Combo Hemat Meja) --}}
                <section class="reveal relative mt-5 overflow-hidden rounded-3xl bg-gradient-to-br from-[#7C3AED] to-[#4F46E5] p-6 text-white shadow-lg shadow-[#7C3AED]/25 sm:p-7">
                    <div class="absolute -right-10 -top-12 h-44 w-44 rounded-full bg-white/10 blur-2xl" aria-hidden="true"></div>
                    <div class="absolute -bottom-14 left-16 h-40 w-40 rounded-full bg-white/10 blur-2xl" aria-hidden="true"></div>

                    <div class="relative">
                        <span class="inline-flex items-center gap-1.5 rounded-full border border-white/25 bg-white/15 px-3 py-1 text-[11px] font-bold uppercase tracking-widest">
                            <svg class="h-3.5 w-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                                <path d="m12 3 2.4 4.9 5.4.8-3.9 3.8.9 5.4L12 15.4 7.2 17.9l.9-5.4L4.2 8.7l5.4-.8L12 3Z" />
                            </svg>
                            Combo Hemat Meja
                        </span>

                        <h2 class="mt-4 max-w-xl text-xl font-bold leading-snug tracking-tight sm:text-2xl">
                            Paket Siang: Kopi Aren + Rice Bowl Ayam Teriyaki
                        </h2>
                        <p class="mt-2 max-w-lg text-sm leading-relaxed text-white/75">
                            Hemat <span class="font-semibold text-white">Rp 9.900</span> khusus dine-in meja kamu — sudah termasuk satu Kopi Susu Aren HQ dan Rice Bowl Ayam Teriyaki.
                        </p>

                        <button
                            type="button"
                            id="combo-button"
                            class="mt-5 inline-flex items-center gap-2 rounded-full bg-white px-5 py-3 text-sm font-bold text-[#6D28D9] shadow-md transition hover:bg-[#F3F0FD] active:scale-[0.98]"
                        >
                            <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                                <path d="M12 5v14M5 12h14" />
                            </svg>
                            Tambah Combo (Rp 50.000)
                        </button>
                    </div>
                </section>

                {{-- Grid Kartu Produk --}}
                @php
                    $produk = [
                        [
                            'name' => 'Kopi Susu Aren HQ',
                            'desc' => 'Espresso pekat, susu segar, dan gula aren khas HQ.',
                            'price' => 22000,
                            'badge' => 'BEST SELLER',
                            'badge_color' => 'bg-[#7C3AED] text-white',
                            'tag' => 'SIGNATURE',
                            'category' => 'signature',
                            'icon' => 'coffee',
                            'gradient' => 'from-[#EDE9FE] to-[#F8F6FF]',
                        ],
                        [
                            'name' => 'Sea Salt Latte',
                            'desc' => 'Latte lembut dengan krim sea salt gurih di atasnya.',
                            'price' => 28000,
                            'badge' => 'BARISTA PICK',
                            'badge_color' => 'bg-[#0EA5E9] text-white',
                            'tag' => 'SPECIALTY',
                            'category' => 'signature',
                            'icon' => 'coffee',
                            'gradient' => 'from-[#E0F2FE] to-[#F8FBFF]',
                        ],
                        [
                            'name' => 'Thai Green Tea',
                            'desc' => 'Green tea Thailand creamy dengan aroma santan.',
                            'price' => 24000,
                            'badge' => 'FAVORIT',
                            'badge_color' => 'bg-[#F59E0B] text-white',
                            'tag' => 'SPECIALTY',
                            'category' => 'noncoffee',
                            'icon' => 'tea',
                            'gradient' => 'from-[#DCFCE7] to-[#F6FFF9]',
                        ],
                        [
                            'name' => 'Cinnamon Roll Homemade',
                            'desc' => 'Roti gulung kayu manis dengan cream cheese frosting.',
                            'price' => 22000,
                            'badge' => 'FAVORIT',
                            'badge_color' => 'bg-[#F59E0B] text-white',
                            'tag' => 'PASTRY',
                            'category' => 'pastry',
                            'icon' => 'pastry',
                            'gradient' => 'from-[#FEF3C7] to-[#FFFBF0]',
                        ],
                        [
                            'name' => 'Rice Bowl Ayam Teriyaki',
                            'desc' => 'Nasi hangat, ayam teriyaki glazed, telur, dan sayur.',
                            'price' => 35000,
                            'badge' => 'CHEF REC',
                            'badge_color' => 'bg-[#EF4444] text-white',
                            'tag' => 'MAIN',
                            'category' => 'main',
                            'icon' => 'bowl',
                            'gradient' => 'from-[#FEE2E2] to-[#FFF7F7]',
                        ],
                        [
                            'name' => 'Chicken Wrap Tortilla',
                            'desc' => 'Tortilla renyah berisi ayam grilled dan sayuran segar.',
                            'price' => 28000,
                            'badge' => 'CHEF REC',
                            'badge_color' => 'bg-[#EF4444] text-white',
                            'tag' => 'MAIN',
                            'category' => 'main',
                            'icon' => 'wrap',
                            'gradient' => 'from-[#FFEDD5] to-[#FFF9F2]',
                        ],
                        [
                            'name' => 'French Fries Truffle',
                            'desc' => 'Kentang goreng renyah dengan aroma truffle dan parmesan.',
                            'price' => 25000,
                            'badge' => 'FAVORIT',
                            'badge_color' => 'bg-[#F59E0B] text-white',
                            'tag' => 'BITES',
                            'category' => 'pastry',
                            'icon' => 'fries',
                            'gradient' => 'from-[#FDE68A] to-[#FFFBEA]',
                        ],
                        [
                            'name' => 'Croissant Butter',
                            'desc' => 'Croissant berlapis renyah dengan butter premium.',
                            'price' => 24000,
                            'badge' => 'BARISTA PICK',
                            'badge_color' => 'bg-[#0EA5E9] text-white',
                            'tag' => 'PASTRY',
                            'category' => 'pastry',
                            'icon' => 'pastry',
                            'gradient' => 'from-[#FEF3C7] to-[#FFFBF0]',
                        ],
                    ];
                @endphp

                <div id="product-grid" class="reveal stagger mt-6 grid grid-cols-1 gap-5 sm:grid-cols-2">
                    @foreach ($produk as $item)
                        <article
                            class="product-card group flex flex-col overflow-hidden rounded-2xl border border-[#ECE9F6] bg-white shadow-sm transition duration-300 hover:-translate-y-1 hover:shadow-[0_16px_40px_rgba(49,24,107,0.10)]"
                            data-category="{{ $item['category'] }}"
                            data-name="{{ strtolower($item['name']) }}"
                        >
                            {{-- Gambar Produk (Placeholder Gradasi + Ikon) --}}
                            <div class="relative">
                                <div class="grid aspect-square w-full place-items-center bg-gradient-to-br {{ $item['gradient'] }}">
                                    @switch ($item['icon'])
                                        @case ('coffee')
                                            <svg class="h-16 w-16 text-[#7C3AED]/45 transition duration-300 group-hover:scale-110" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.4" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                                                <path d="M4 8h12v5a4 4 0 0 1-4 4H8a4 4 0 0 1-4-4V8Z" />
                                                <path d="M16 9h1.5a2.5 2.5 0 0 1 0 5H16" />
                                                <path d="M7 4.5v1.5M10 3.5v2.5M13 4.5v1.5" />
                                            </svg>
                                        @break

                                        @case ('tea')
                                            <svg class="h-16 w-16 text-emerald-500/45 transition duration-300 group-hover:scale-110" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.4" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                                                <path d="M10 2h4M12 2v3" />
                                                <path d="M5 8h12v6a5 5 0 0 1-5 5h-2a5 5 0 0 1-5-5V8Z" />
                                                <path d="M17 9h1a2.5 2.5 0 0 1 0 5h-1" />
                                            </svg>
                                        @break

                                        @case ('pastry')
                                            <svg class="h-16 w-16 text-amber-500/45 transition duration-300 group-hover:scale-110" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.4" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                                                <path d="M4 14c0-4.4 3.6-8 8-8s8 3.6 8 8" />
                                                <path d="M3 14h18l-1.5 4.5a2 2 0 0 1-1.9 1.5H6.4a2 2 0 0 1-1.9-1.5L3 14Z" />
                                                <path d="M8.5 14V9.5M12 14V7M15.5 14V9.5" />
                                            </svg>
                                        @break

                                        @case ('bowl')
                                            <svg class="h-16 w-16 text-red-400/45 transition duration-300 group-hover:scale-110" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.4" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                                                <path d="M3 11h18a9 9 0 0 1-9 9 9 9 0 0 1-9-9Z" />
                                                <path d="M6 8c0-1.5 1-2.5 2-3M11 7c0-1.5 1-2.5 2-3M16 8c0-1.5 1-2.5 2-3" />
                                            </svg>
                                        @break

                                        @case ('wrap')
                                            <svg class="h-16 w-16 text-orange-400/50 transition duration-300 group-hover:scale-110" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.4" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                                                <path d="M4.5 9.5 12 3l7.5 6.5c1.7 1.5 1.7 4.2 0 5.7L12 21.5l-7.5-6.3c-1.7-1.5-1.7-4.2 0-5.7Z" />
                                                <path d="M8 12h8M9.5 15.5h5" />
                                            </svg>
                                        @break

                                        @default
                                            <svg class="h-16 w-16 text-amber-400/50 transition duration-300 group-hover:scale-110" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.4" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                                                <path d="M7 21h10M9 21l1-9M15 21l-1-9" />
                                                <path d="M8 12h8l-1.2-6.5a1.5 1.5 0 0 0-1.5-1.3h-2.6a1.5 1.5 0 0 0-1.5 1.3L8 12Z" />
                                                <path d="M9.5 8.5h5" />
                                            </svg>
                                    @endswitch
                                </div>

                                {{-- Badge Label di Atas Gambar --}}
                                <span class="absolute left-3 top-3 rounded-full px-2.5 py-1 text-[10px] font-bold uppercase tracking-wider shadow-sm {{ $item['badge_color'] }}">
                                    {{ $item['badge'] }}
                                </span>
                            </div>

                            <div class="flex flex-1 flex-col p-4">
                                <div class="flex items-start justify-between gap-3">
                                    <h3 class="text-sm font-bold text-[#1B1338] sm:text-base">{{ $item['name'] }}</h3>
                                    <span class="mt-0.5 shrink-0 rounded-full bg-[#F3F0FD] px-2 py-0.5 text-[10px] font-bold uppercase tracking-wider text-[#6D28D9]">
                                        {{ $item['tag'] }}
                                    </span>
                                </div>
                                <p class="mt-1.5 line-clamp-2 text-xs leading-relaxed text-slate-500 sm:text-sm">{{ $item['desc'] }}</p>

                                <div class="mt-auto flex items-center justify-between gap-3 pt-4">
                                    <p class="text-base font-extrabold tracking-tight text-[#1B1338]">
                                        Rp {{ number_format($item['price'], 0, ',', '.') }}
                                    </p>
                                    <button
                                        type="button"
                                        class="add-to-cart inline-flex items-center gap-1 rounded-full bg-[#7C3AED] px-4 py-2 text-xs font-bold text-white shadow-sm transition hover:bg-[#6D28D9] active:scale-95 sm:text-sm"
                                        data-name="{{ $item['name'] }}"
                                        data-price="{{ $item['price'] }}"
                                    >
                                        <svg class="h-3.5 w-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                                            <path d="M12 5v14M5 12h14" />
                                        </svg>
                                        Tambah
                                    </button>
                                </div>
                            </div>
                        </article>
                    @endforeach
                </div>

                <p id="product-empty" class="mt-8 hidden rounded-2xl border border-dashed border-[#E4DFF3] bg-white p-8 text-center text-sm text-slate-500">
                    Menu tidak ditemukan. Coba kata kunci atau kategori lain.
                </p>
            </div>

            {{-- ================================================================== --}}
            {{-- KOLOM KANAN — SIDEBAR RINGKASAN PESANAN                             --}}
            {{-- ================================================================== --}}
            <aside class="w-full lg:sticky lg:top-28 lg:h-fit lg:w-1/3">
                <div class="rounded-3xl border border-[#ECE9F6] bg-white p-5 shadow-[0_10px_40px_rgba(49,24,107,0.06)] sm:p-6">
                    {{-- Header Pesanan --}}
                    <div class="flex items-start justify-between gap-3 border-b border-[#ECE9F6] pb-4">
                        <div>
                            <h2 class="text-lg font-bold tracking-tight text-[#1B1338]">Pesanan Kamu</h2>
                            <p class="mt-0.5 text-xs font-medium text-slate-500">Meja 01 • Dine In</p>
                        </div>
                        <span id="item-count-badge" class="hidden shrink-0 rounded-full bg-[#7C3AED] px-3 py-1 text-xs font-bold text-white">0 Item</span>
                    </div>

                    {{-- Daftar Item Pesanan --}}
                    <div id="cart-items" class="mt-4 space-y-3">
                    </div>

                    <p id="cart-empty" class="mt-4 hidden rounded-2xl border border-dashed border-[#E4DFF3] bg-[#FAFAFC] p-6 text-center text-sm text-slate-500">
                        Keranjang masih kosong. Pilih menu favoritmu di samping.
                    </p>

                    {{-- Catatan Barista / Dapur --}}
                    <div class="mt-5">
                        <label for="order-note" class="text-xs font-bold uppercase tracking-wider text-slate-500">Catatan Barista / Dapur</label>
                        <textarea
                            id="order-note"
                            rows="2"
                            placeholder="Contoh: Tolong sediakan sendok tambahan..."
                            class="mt-2 w-full resize-none rounded-2xl border border-[#E4DFF3] bg-[#FAFAFC] px-4 py-3 text-sm text-[#1B1338] placeholder:text-slate-400 focus:border-[#7C3AED] focus:bg-white focus:outline-none focus:ring-2 focus:ring-[#7C3AED]/20"
                        ></textarea>
                    </div>

                    {{-- Pilihan Jenis Pemesanan (Dine-in / Takeaway) --}}
                    <div class="mt-5">
                        <div class="flex items-center justify-between">
                            <p class="text-xs font-bold uppercase tracking-wider text-slate-500">Jenis Pemesanan</p>
                            <span id="order-type-caption" class="text-[11px] font-semibold text-[#6D28D9]">Makan di Tempat</span>
                        </div>
                        <div class="mt-2 grid grid-cols-2 gap-3" role="radiogroup" aria-label="Pilih jenis pemesanan">
                            <button
                                type="button"
                                id="btn-type-dinein"
                                class="order-type-btn is-active flex flex-col items-start gap-1 rounded-2xl border-2 border-[#7C3AED] bg-[#F3F0FD] px-4 py-3 text-left transition"
                                data-type="dine-in"
                                role="radio"
                                aria-checked="true"
                            >
                                <span class="flex items-center gap-1.5 text-sm font-bold text-[#6D28D9]">
                                    <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                                        <path d="M3 2v7c0 1.1.9 2 2 2h4a2 2 0 0 0 2-2V2" />
                                        <path d="M7 2v20" />
                                        <path d="M21 15V2a5 5 0 0 0-5 5v6c0 1.1.9 2 2 2h3Zm0 0v7" />
                                    </svg>
                                    Dine-in
                                </span>
                                <span class="text-[11px] font-medium text-[#7C3AED]/70">Makan di Meja 01</span>
                            </button>

                            <button
                                type="button"
                                id="btn-type-takeaway"
                                class="order-type-btn flex flex-col items-start gap-1 rounded-2xl border-2 border-[#E4DFF3] bg-white px-4 py-3 text-left transition hover:border-[#C9BFEA]"
                                data-type="takeaway"
                                role="radio"
                                aria-checked="false"
                            >
                                <span class="flex items-center gap-1.5 text-sm font-bold text-slate-600">
                                    <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                                        <path d="M6 2 3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4Z" />
                                        <path d="M3 6h18" />
                                        <path d="M16 10a4 4 0 0 1-8 0" />
                                    </svg>
                                    Takeaway
                                </span>
                                <span class="text-[11px] font-medium text-slate-400">Bawa pulang / bungkus</span>
                            </button>
                        </div>

                        {{-- Alert info jika memilih Takeaway --}}
                        <div id="takeaway-notice" class="mt-2.5 hidden items-start gap-2.5 rounded-2xl border border-amber-200/80 bg-amber-50/80 p-3 text-xs leading-relaxed text-amber-900">
                            <svg class="mt-0.5 h-4 w-4 shrink-0 text-amber-600" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                                <circle cx="12" cy="12" r="10" />
                                <line x1="12" y1="8" x2="12" y2="12" />
                                <line x1="12" y1="16" x2="12.01" y2="16" />
                            </svg>
                            <div>
                                <p class="font-bold text-amber-950">Pesanan Bawa Pulang (Takeaway)</p>
                                <p class="mt-0.5 text-amber-800">Makanan &amp; minuman akan dibungkus rapi. Silakan ambil pesanan di counter pick-up saat nomor antrean dipanggil.</p>
                            </div>
                        </div>
                    </div>

                    {{-- Pilihan Metode Pembayaran --}}
                    <div class="mt-5">
                        <p class="text-xs font-bold uppercase tracking-wider text-slate-500">Metode Pembayaran</p>
                        <div class="mt-2 grid grid-cols-2 gap-3">
                            <button
                                type="button"
                                class="payment-method is-active flex flex-col items-start gap-1 rounded-2xl border-2 border-[#7C3AED] bg-[#F3F0FD] px-4 py-3 text-left transition"
                                data-method="qris"
                            >
                                <span class="flex items-center gap-1.5 text-sm font-bold text-[#6D28D9]">
                                    <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                                        <rect x="3" y="3" width="7" height="7" rx="1" />
                                        <rect x="14" y="3" width="7" height="7" rx="1" />
                                        <rect x="3" y="14" width="7" height="7" rx="1" />
                                        <path d="M14 14h3v3h-3zM20 14h1M14 20h3M20 17v4" />
                                    </svg>
                                    QRIS Meja
                                </span>
                                <span id="qris-subtitle" class="text-[11px] font-medium text-[#7C3AED]/70">Scan di meja</span>
                            </button>

                            <button
                                type="button"
                                class="payment-method flex flex-col items-start gap-1 rounded-2xl border-2 border-[#E4DFF3] bg-white px-4 py-3 text-left transition hover:border-[#C9BFEA]"
                                data-method="kasir"
                            >
                                <span class="flex items-center gap-1.5 text-sm font-bold text-slate-600">
                                    <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                                        <path d="M2 7h20v3a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V7Z" />
                                        <path d="M4 12v7a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2v-7" />
                                        <path d="M9 16h.01M15 16h.01" />
                                    </svg>
                                    Bayar Kasir
                                </span>
                                <span id="kasir-subtitle" class="text-[11px] font-medium text-slate-400">Ke depan kasir</span>
                            </button>
                        </div>
                    </div>

                    {{-- Rincian Ringkasan Harga --}}
                    <dl class="mt-5 space-y-2.5 border-t border-[#ECE9F6] pt-5 text-sm">
                        <div class="flex items-center justify-between">
                            <dt class="text-slate-500">Subtotal (<span id="summary-count">0</span> item)</dt>
                            <dd id="summary-subtotal" class="font-semibold text-[#1B1338]">Rp 0</dd>
                        </div>
                        <div class="flex items-center justify-between">
                            <dt class="text-slate-500">Pajak Restoran PB1 (10%)</dt>
                            <dd id="summary-tax" class="font-semibold text-[#1B1338]">Rp 0</dd>
                        </div>
                        <div id="packaging-row" class="hidden items-center justify-between">
                            <dt class="text-slate-500">Biaya Kantong/Kemasan</dt>
                            <dd class="font-semibold text-[#059669]">GRATIS</dd>
                        </div>
                        <div id="discount-row" class="flex items-center justify-between">
                            <dt id="discount-label" class="text-slate-500">Diskon Promo Dine-in</dt>
                            <dd id="summary-discount" class="font-semibold text-[#059669]">Rp 0</dd>
                        </div>

                        <div class="mt-3 flex items-end justify-between gap-3 rounded-2xl bg-[#F3F0FD] px-4 py-3.5">
                            <div>
                                <dt class="text-xs font-bold uppercase tracking-wider text-[#6D28D9]">Total Pembayaran</dt>
                                <dd class="mt-1 inline-flex items-center gap-1.5 rounded-full bg-white px-2 py-0.5 text-[10px] font-bold uppercase tracking-wider text-[#6D28D9] shadow-sm">
                                    Termasuk PPN
                                </dd>
                            </div>
                            <dd id="summary-total" class="text-2xl font-extrabold tracking-tight text-[#1B1338]">Rp 0</dd>
                        </div>
                    </dl>

                    {{-- Tombol Aksi Utama --}}
                    <button
                        type="button"
                        id="checkout-button"
                        class="mt-5 flex w-full items-center justify-center gap-2 rounded-2xl bg-[#7C3AED] px-5 py-4 text-sm font-bold text-white shadow-lg shadow-[#7C3AED]/30 transition hover:bg-[#6D28D9] active:scale-[0.99] sm:text-base"
                    >
                        <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                            <rect x="3" y="3" width="7" height="7" rx="1" />
                            <rect x="14" y="3" width="7" height="7" rx="1" />
                            <rect x="3" y="14" width="7" height="7" rx="1" />
                            <path d="M14 14h3v3h-3zM20 14h1M14 20h3M20 17v4" />
                        </svg>
                        <span id="checkout-label">Keranjang Kosong</span>
                    </button>
                    <p id="order-footer-note" class="mt-2.5 text-center text-xs leading-relaxed text-slate-500">
                        Pesanan langsung diteruskan ke barista meja 01
                    </p>

                    {{-- Card Bantuan Staff --}}
                    <div class="mt-5 flex items-center justify-between gap-3 rounded-2xl border border-[#EDE9FE] bg-[#F3F0FD] p-4">
                        <div class="min-w-0">
                            <p class="text-sm font-bold text-[#1B1338]">Butuh Bantuan Staff?</p>
                            <p class="mt-0.5 text-xs text-slate-500">Panggil pelayan ke Meja 01</p>
                        </div>
                        <button
                            type="button"
                            id="call-staff"
                            class="shrink-0 rounded-full bg-[#7C3AED] px-4 py-2 text-xs font-bold text-white transition hover:bg-[#6D28D9] active:scale-95"
                        >
                            Panggil
                        </button>
                    </div>
                </div>
            </aside>
        </main>

        {{-- ===================== SCRIPT INTERAKTIVITAS ===================== --}}
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                const formatRupiah = (value) => 'Rp ' + value.toLocaleString('id-ID');
                const DISCOUNT = 9900;

                const cartItemsWrap = document.getElementById('cart-items');
                const cartEmpty = document.getElementById('cart-empty');
                const itemCountBadge = document.getElementById('item-count-badge');
                const summaryCount = document.getElementById('summary-count');
                const summarySubtotal = document.getElementById('summary-subtotal');
                const summaryTax = document.getElementById('summary-tax');
                const summaryDiscount = document.getElementById('summary-discount');
                const summaryTotal = document.getElementById('summary-total');
                const checkoutLabel = document.getElementById('checkout-label');
                const discountLabel = document.getElementById('discount-label');
                const packagingRow = document.getElementById('packaging-row');

                const orderTypeCaption = document.getElementById('order-type-caption');
                const takeawayNotice = document.getElementById('takeaway-notice');
                const headerOrderBadge = document.getElementById('header-order-badge');
                const headerOrderDot = document.getElementById('header-order-dot');
                const headerOrderText = document.getElementById('header-order-text');
                const headerOrderDesc = document.getElementById('header-order-desc');
                const orderFooterNote = document.getElementById('order-footer-note');
                const orderNoteInput = document.getElementById('order-note');
                const qrisSubtitle = document.getElementById('qris-subtitle');
                const kasirSubtitle = document.getElementById('kasir-subtitle');

                let orderType = 'dine-in';
                let paymentMethod = 'qris';

                function recalcTotals() {
                    const items = cartItemsWrap.querySelectorAll('.cart-item');
                    let subtotal = 0;
                    let totalQty = 0;

                    items.forEach((item) => {
                        const price = parseInt(item.dataset.price, 10);
                        const qty = parseInt(item.querySelector('.qty').textContent, 10);
                        subtotal += price * qty;
                        totalQty += qty;
                        item.querySelector('.item-price').textContent = formatRupiah(price * qty);
                    });

                    const isEmpty = items.length === 0;
                    const tax = Math.round(subtotal * 0.1);
                    const isDineIn = orderType === 'dine-in';
                    const discount = (!isEmpty && isDineIn) ? Math.min(DISCOUNT, subtotal) : 0;
                    const total = Math.max(subtotal + tax - discount, 0);

                    cartEmpty.classList.toggle('hidden', !isEmpty);
                    itemCountBadge.classList.toggle('hidden', isEmpty);
                    itemCountBadge.textContent = items.length + ' Item';
                    summaryCount.textContent = totalQty;
                    summarySubtotal.textContent = formatRupiah(subtotal);
                    summaryTax.textContent = formatRupiah(tax);

                    if (isDineIn) {
                        discountLabel.textContent = 'Diskon Promo Dine-in';
                        summaryDiscount.textContent = discount > 0 ? '-' + formatRupiah(discount) : 'Rp 0';
                        summaryDiscount.className = 'font-semibold text-[#059669]';
                    } else {
                        discountLabel.textContent = 'Promo Dine-in (Khusus Meja)';
                        summaryDiscount.textContent = 'Rp 0';
                        summaryDiscount.className = 'font-medium text-slate-400';
                    }

                    summaryTotal.textContent = formatRupiah(total);

                    const methodLabel = paymentMethod === 'qris' ? 'Lanjut Pembayaran QRIS' : 'Lanjut ke Kasir';
                    checkoutLabel.textContent = isEmpty ? 'Keranjang Kosong' : methodLabel + ' (' + formatRupiah(total) + ')';

                    return total;
                }

                // Toggle pilihan jenis pemesanan (Dine-in / Takeaway)
                const orderTypeButtons = document.querySelectorAll('.order-type-btn');
                orderTypeButtons.forEach((button) => {
                    button.addEventListener('click', function () {
                        orderType = button.dataset.type;

                        orderTypeButtons.forEach((other) => {
                            const isActive = other === button;
                            other.classList.toggle('is-active', isActive);
                            other.classList.toggle('border-[#7C3AED]', isActive);
                            other.classList.toggle('bg-[#F3F0FD]', isActive);
                            other.classList.toggle('border-[#E4DFF3]', !isActive);
                            other.classList.toggle('bg-white', !isActive);
                            other.setAttribute('aria-checked', isActive ? 'true' : 'false');

                            const title = other.querySelector('span');
                            const subtitle = other.querySelectorAll('span')[1];
                            title.classList.toggle('text-[#6D28D9]', isActive);
                            title.classList.toggle('text-slate-600', !isActive);
                            subtitle.classList.toggle('text-[#7C3AED]/70', isActive);
                            subtitle.classList.toggle('text-slate-400', !isActive);
                        });

                        const isDineIn = orderType === 'dine-in';

                        if (isDineIn) {
                            orderTypeCaption.textContent = 'Makan di Tempat';
                            orderTypeCaption.className = 'text-[11px] font-semibold text-[#6D28D9]';
                            takeawayNotice.classList.add('hidden');
                            takeawayNotice.classList.remove('flex');
                            packagingRow.classList.add('hidden');

                            if (headerOrderBadge) {
                                headerOrderBadge.className = 'inline-flex items-center gap-1.5 rounded-full bg-[#ECFDF5] px-2.5 py-1 text-[11px] font-semibold text-[#059669] transition';
                                headerOrderDot.className = 'h-1.5 w-1.5 animate-pulse rounded-full bg-[#10B981]';
                                headerOrderText.textContent = 'Dine-In Aktif';
                                headerOrderDesc.textContent = 'Pesan langsung dari meja, tanpa antre';
                            }

                            qrisSubtitle.textContent = 'Scan di meja';
                            kasirSubtitle.textContent = 'Ke depan kasir';
                            orderFooterNote.textContent = 'Pesanan langsung diteruskan ke barista meja 01';
                            orderNoteInput.placeholder = 'Contoh: Tolong sediakan sendok tambahan...';
                        } else {
                            orderTypeCaption.textContent = 'Bawa Pulang (Takeaway)';
                            orderTypeCaption.className = 'text-[11px] font-semibold text-amber-600';
                            takeawayNotice.classList.remove('hidden');
                            takeawayNotice.classList.add('flex');
                            packagingRow.classList.remove('hidden');

                            if (headerOrderBadge) {
                                headerOrderBadge.className = 'inline-flex items-center gap-1.5 rounded-full border border-amber-200/80 bg-amber-50 px-2.5 py-1 text-[11px] font-semibold text-amber-700 transition';
                                headerOrderDot.className = 'h-1.5 w-1.5 animate-pulse rounded-full bg-amber-500';
                                headerOrderText.textContent = 'Takeaway (Bawa Pulang)';
                                headerOrderDesc.textContent = 'Pesanan dibungkus & siap di counter pick-up';
                            }

                            qrisSubtitle.textContent = 'Scan di counter/meja';
                            kasirSubtitle.textContent = 'Bayar di kasir';
                            orderFooterNote.textContent = 'Pesanan dibungkus & dapat diambil di counter pick-up saat nomor dipanggil';
                            orderNoteInput.placeholder = 'Contoh: Pisahkan gula/es, sedotan ramah lingkungan, bungkus rapi...';
                        }

                        recalcTotals();
                    });
                });

                // Buka / tutup counter jumlah item pesanan
                cartItemsWrap.addEventListener('click', function (event) {
                    const toggle = event.target.closest('.cart-item-toggle');
                    if (toggle) {
                        const controls = toggle.closest('.cart-item').querySelector('.item-controls');
                        const isOpen = toggle.getAttribute('aria-expanded') === 'true';
                        toggle.setAttribute('aria-expanded', !isOpen);
                        controls.classList.toggle('hidden', isOpen);
                        return;
                    }

                    const item = event.target.closest('.cart-item');
                    if (!item) return;

                    const qtyEl = item.querySelector('.qty');
                    let qty = parseInt(qtyEl.textContent, 10);

                    if (event.target.closest('.qty-inc')) {
                        qtyEl.textContent = qty + 1;
                        recalcTotals();
                    } else if (event.target.closest('.qty-dec')) {
                        if (qty > 1) {
                            qtyEl.textContent = qty - 1;
                            recalcTotals();
                        }
                    } else if (event.target.closest('.remove-item')) {
                        item.remove();
                        recalcTotals();
                    }
                });

                // Toggle pilihan metode pembayaran
                document.querySelectorAll('.payment-method').forEach((button) => {
                    button.addEventListener('click', function () {
                        paymentMethod = button.dataset.method;

                        document.querySelectorAll('.payment-method').forEach((other) => {
                            const isActive = other === button;
                            other.classList.toggle('is-active', isActive);
                            other.classList.toggle('border-[#7C3AED]', isActive);
                            other.classList.toggle('bg-[#F3F0FD]', isActive);
                            other.classList.toggle('border-[#E4DFF3]', !isActive);
                            other.classList.toggle('bg-white', !isActive);

                            const title = other.querySelector('span');
                            const subtitle = other.querySelectorAll('span')[1];
                            title.classList.toggle('text-[#6D28D9]', isActive);
                            title.classList.toggle('text-slate-600', !isActive);
                            subtitle.classList.toggle('text-[#7C3AED]/70', isActive);
                            subtitle.classList.toggle('text-slate-400', !isActive);
                        });

                        recalcTotals();
                    });
                });

                // Filter kategori (tabs)
                const tabs = document.querySelectorAll('.category-tab');
                const cards = document.querySelectorAll('.product-card');
                const emptyFilter = document.getElementById('product-empty');
                const searchInput = document.getElementById('menu-search');

                function filterProducts() {
                    const activeTab = document.querySelector('.category-tab.is-active');
                    const category = activeTab ? activeTab.dataset.category : 'all';
                    const query = (searchInput.value || '').trim().toLowerCase();
                    let visible = 0;

                    cards.forEach((card) => {
                        const matchCategory = category === 'all' || card.dataset.category === category;
                        const matchQuery = !query || card.dataset.name.includes(query);
                        const show = matchCategory && matchQuery;
                        card.classList.toggle('hidden', !show);
                        if (show) visible++;
                    });

                    emptyFilter.classList.toggle('hidden', visible > 0);
                }

                tabs.forEach((tab) => {
                    tab.addEventListener('click', function () {
                        tabs.forEach((other) => {
                            const isActive = other === tab;
                            other.classList.toggle('is-active', isActive);
                            other.classList.toggle('bg-[#7C3AED]', isActive);
                            other.classList.toggle('text-white', isActive);
                            other.classList.toggle('border-transparent', isActive);
                            other.classList.toggle('shadow-sm', isActive);
                            other.classList.toggle('border-[#E4DFF3]', !isActive);
                            other.classList.toggle('bg-white', !isActive);
                            other.classList.toggle('text-slate-600', !isActive);
                            other.classList.toggle('font-semibold', isActive);
                            other.classList.toggle('font-medium', !isActive);
                            other.setAttribute('aria-selected', isActive ? 'true' : 'false');
                        });

                        filterProducts();
                    });
                });

                searchInput.addEventListener('input', filterProducts);

                // Tombol "Tambah" pada kartu produk
                document.querySelectorAll('.add-to-cart').forEach((button) => {
                    button.addEventListener('click', function () {
                        const exists = Array.from(cartItemsWrap.querySelectorAll('.cart-item')).find(
                            (item) => item.dataset.name === button.dataset.name
                        );

                        if (exists) {
                            const qtyEl = exists.querySelector('.qty');
                            qtyEl.textContent = parseInt(qtyEl.textContent, 10) + 1;
                            exists.querySelector('.item-controls').classList.remove('hidden');
                            exists.querySelector('.cart-item-toggle').setAttribute('aria-expanded', 'true');
                            exists.scrollIntoView({ behavior: 'smooth', block: 'nearest' });
                        } else {
                            const item = document.createElement('div');
                            item.className = 'cart-item rounded-2xl border border-[#EDE9FE] bg-[#FAFAFC] p-3.5';
                            item.dataset.price = button.dataset.price;
                            item.dataset.name = button.dataset.name;
                            item.dataset.note = '';
                            item.innerHTML =
                                '<div class="flex items-start justify-between gap-3">' +
                                    '<button type="button" class="cart-item-toggle min-w-0 flex-1 text-left" aria-expanded="true">' +
                                        '<p class="text-sm font-bold text-[#1B1338]">' + button.dataset.name + '</p>' +
                                        '<p class="mt-0.5 text-xs leading-relaxed text-slate-500">Tanpa catatan khusus</p>' +
                                    '</button>' +
                                    '<p class="item-price shrink-0 text-sm font-extrabold text-[#1B1338]"></p>' +
                                '</div>' +
                                '<div class="item-controls mt-3 flex items-center justify-between gap-3">' +
                                    '<div class="flex items-center gap-1 rounded-full border border-[#E4DFF3] bg-white p-1">' +
                                        '<button type="button" class="qty-dec grid h-7 w-7 place-items-center rounded-full text-[#6D28D9] transition hover:bg-[#EDE9FE]" aria-label="Kurangi jumlah">&minus;</button>' +
                                        '<span class="qty w-6 text-center text-sm font-bold text-[#1B1338]">1</span>' +
                                        '<button type="button" class="qty-inc grid h-7 w-7 place-items-center rounded-full text-[#6D28D9] transition hover:bg-[#EDE9FE]" aria-label="Tambah jumlah">+</button>' +
                                    '</div>' +
                                    '<button type="button" class="remove-item inline-flex items-center gap-1 text-xs font-semibold text-red-500 transition hover:text-red-600">Hapus</button>' +
                                '</div>';
                            cartItemsWrap.appendChild(item);
                        }

                        recalcTotals();
                    });
                });

                // Tombol combo banner
                document.getElementById('combo-button').addEventListener('click', function () {
                    this.disabled = true;
                    this.classList.add('opacity-80');
                    this.lastChild.textContent = ' Combo Ditambahkan! ';
                    setTimeout(() => {
                        this.disabled = false;
                        this.classList.remove('opacity-80');
                        this.lastChild.textContent = ' Tambah Combo (Rp 50.000) ';
                    }, 1800);
                });

                // Tombol panggil staff
                document.getElementById('call-staff').addEventListener('click', function () {
                    this.disabled = true;
                    this.textContent = 'Memanggil...';
                    this.classList.add('opacity-70');
                    setTimeout(() => {
                        this.textContent = 'Staff Dalam Perjalanan';
                        setTimeout(() => {
                            this.disabled = false;
                            this.textContent = 'Panggil';
                            this.classList.remove('opacity-70');
                        }, 2500);
                    }, 1200);
                });

                // Tombol checkout utama
                document.getElementById('checkout-button').addEventListener('click', async function () {
                    const items = Array.from(cartItemsWrap.querySelectorAll('.cart-item'));
                    if (items.length === 0) return;

                    const button = this;
                    const label = document.getElementById('checkout-label');
                    const originalLabel = label.textContent;

                    const payloadItems = items.map((item) => ({
                        name: item.dataset.name,
                        price: parseInt(item.dataset.price, 10),
                        qty: parseInt(item.querySelector('.qty').textContent, 10),
                        note: item.dataset.note || null,
                    }));

                    button.disabled = true;
                    button.classList.add('opacity-70');
                    label.textContent = 'Mengirim pesanan...';

                    try {
                        const response = await fetch('{{ route('orders.store') }}', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'Accept': 'application/json',
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                            },
                            body: JSON.stringify({
                                order_type: orderType,
                                payment_method: paymentMethod,
                                table_number: '01',
                                note: orderNoteInput.value.trim() || null,
                                items: payloadItems,
                            }),
                        });

                        if (!response.ok) {
                            throw new Error('Gagal membuat pesanan.');
                        }

                        const result = await response.json();
                        window.location.href = result.redirect;
                    } catch (error) {
                        button.disabled = false;
                        button.classList.remove('opacity-70');
                        label.textContent = originalLabel;
                        alert('Pesanan gagal dikirim. Silakan coba lagi.');
                    }
                });

                recalcTotals();
            });
        </script>
    </body>
</html>
