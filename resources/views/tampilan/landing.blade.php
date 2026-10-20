<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Pesanara — Pesan Lebih Mudah, Nikmati Lebih Nyaman</title>
        <meta name="description" content="Pesanara memudahkan kamu memesan menu favorit tanpa antre. Cepat, praktis, dan nyaman.">

        @fonts

        {{-- Styles / Scripts (Langsung panggil @vite agar Tailwind CSS dimuat) --}}
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="overflow-x-hidden bg-[#FAFAFC] font-sans text-slate-600 antialiased">
        {{-- ===================== NAVBAR ===================== --}}
        <header class="sticky top-0 z-40 border-b border-[#ECE9F6] bg-white/85 backdrop-blur-md">
            <nav class="mx-auto flex max-w-6xl items-center justify-between gap-4 px-5 py-3.5 sm:px-6 lg:px-8" aria-label="Navigasi utama">
                <a href="#beranda" class="flex shrink-0 items-center gap-2.5">
                    <span class="grid h-9 w-9 place-items-center rounded-xl bg-[#7C3AED] text-white shadow-md shadow-[#7C3AED]/30">
                        <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                            <path d="M4 8h12v5a4 4 0 0 1-4 4H8a4 4 0 0 1-4-4V8Z" />
                            <path d="M16 9h1.5a2.5 2.5 0 0 1 0 5H16" />
                            <path d="M7 4.5v1.5M10 3.5v2.5M13 4.5v1.5" />
                        </svg>
                    </span>
                    <span class="text-lg font-bold tracking-tight text-[#1B1338]">Pesanara</span>
                </a>

                <ul class="hidden items-center gap-1 lg:flex">
                    <li><a href="#beranda" class="rounded-full px-3.5 py-2 text-sm font-medium text-slate-600 transition hover:bg-[#F3F0FD] hover:text-[#6D28D9]">Beranda</a></li>
                    <li><a href="#profil" class="rounded-full px-3.5 py-2 text-sm font-medium text-slate-600 transition hover:bg-[#F3F0FD] hover:text-[#6D28D9]">Profil</a></li>
                    <li><a href="#menu" class="rounded-full px-3.5 py-2 text-sm font-medium text-slate-600 transition hover:bg-[#F3F0FD] hover:text-[#6D28D9]">Menu</a></li>
                    <li><a href="#fasilitas" class="rounded-full px-3.5 py-2 text-sm font-medium text-slate-600 transition hover:bg-[#F3F0FD] hover:text-[#6D28D9]">Fasilitas</a></li>
                    <li><a href="#lokasi" class="rounded-full px-3.5 py-2 text-sm font-medium text-slate-600 transition hover:bg-[#F3F0FD] hover:text-[#6D28D9]">Lokasi</a></li>
                </ul>

                <div class="flex items-center gap-2.5">
                    <a href="#menu" class="hidden items-center gap-1.5 rounded-full bg-[#7C3AED] px-5 py-2.5 text-sm font-semibold text-white shadow-sm transition hover:bg-[#6D28D9] sm:inline-flex">
                        Mulai Pesan
                        <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                            <path d="M13.5 4.5 21 12m0 0-7.5 7.5M21 12H3" />
                        </svg>
                    </a>

                    @if (Route::has('login'))
                        @auth
                            <a href="{{ url('/dashboard') }}" class="hidden items-center rounded-full border border-[#E4DFF3] px-4 py-2 text-sm font-medium text-[#1B1338] transition hover:border-[#C9BFEA] hover:bg-[#F3F0FD] sm:inline-flex">
                                Dashboard
                            </a>
                        @else
                            <a href="{{ route('login') }}" class="hidden items-center rounded-full px-3.5 py-2 text-sm font-medium text-slate-600 transition hover:text-[#6D28D9] sm:inline-flex">
                                Masuk
                            </a>
                            @if (Route::has('register'))
                                <a href="{{ route('register') }}" class="hidden items-center rounded-full border border-[#E4DFF3] px-4 py-2 text-sm font-medium text-[#1B1338] transition hover:border-[#C9BFEA] hover:bg-[#F3F0FD] sm:inline-flex">
                                    Daftar
                                </a>
                            @endif
                        @endauth
                    @endif

                    <button
                        id="nav-toggle"
                        type="button"
                        class="grid h-10 w-10 place-items-center rounded-xl border border-[#ECE9F6] bg-white text-[#1B1338] transition hover:bg-[#F3F0FD] lg:hidden"
                        aria-controls="nav-mobile-menu"
                        aria-expanded="false"
                        aria-label="Buka menu navigasi"
                    >
                        <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                            <path d="M3.75 6.75h16.5M3.75 12h16.5M3.75 17.25h16.5" />
                        </svg>
                    </button>
                </div>
            </nav>

            {{-- Mobile menu --}}
            <div id="nav-mobile-menu" class="hidden border-t border-[#ECE9F6] bg-white lg:hidden">
                <div class="mx-auto max-w-6xl px-5 py-4 sm:px-6">
                    <ul class="space-y-1">
                        <li><a href="#beranda" class="block rounded-xl px-4 py-3 text-sm font-medium text-slate-700 transition hover:bg-[#F3F0FD] hover:text-[#6D28D9]">Beranda</a></li>
                        <li><a href="#profil" class="block rounded-xl px-4 py-3 text-sm font-medium text-slate-700 transition hover:bg-[#F3F0FD] hover:text-[#6D28D9]">Profil</a></li>
                        <li><a href="#menu" class="block rounded-xl px-4 py-3 text-sm font-medium text-slate-700 transition hover:bg-[#F3F0FD] hover:text-[#6D28D9]">Menu</a></li>
                        <li><a href="#fasilitas" class="block rounded-xl px-4 py-3 text-sm font-medium text-slate-700 transition hover:bg-[#F3F0FD] hover:text-[#6D28D9]">Fasilitas</a></li>
                        <li><a href="#lokasi" class="block rounded-xl px-4 py-3 text-sm font-medium text-slate-700 transition hover:bg-[#F3F0FD] hover:text-[#6D28D9]">Lokasi</a></li>
                    </ul>

                    <a href="#menu" class="mt-3 flex w-full items-center justify-center gap-1.5 rounded-full bg-[#7C3AED] px-5 py-3 text-sm font-semibold text-white transition hover:bg-[#6D28D9]">
                        Mulai Pesan
                    </a>

                    @if (Route::has('login'))
                        <div class="mt-3 flex items-center justify-center gap-3 border-t border-[#ECE9F6] pt-3">
                            @auth
                                <a href="{{ url('/dashboard') }}" class="text-sm font-medium text-[#1B1338]">Dashboard</a>
                            @else
                                <a href="{{ route('login') }}" class="text-sm font-medium text-slate-700">Masuk</a>
                                @if (Route::has('register'))
                                    <a href="{{ route('register') }}" class="text-sm font-medium text-[#6D28D9]">Daftar</a>
                                @endif
                            @endauth
                        </div>
                    @endif
                </div>
            </div>
        </header>

        <main>
            {{-- ===================== HERO ===================== --}}
            <section id="beranda" class="scroll-mt-20 px-5 pt-6 sm:px-6 sm:pt-8 lg:px-8">
                <div class="relative overflow-hidden rounded-[1.75rem] bg-gradient-to-br from-[#31186B] via-[#2A1360] to-[#171043] px-6 py-16 text-center sm:px-10 sm:py-20 lg:rounded-[2.5rem] lg:py-24">
                    {{-- Dekorasi --}}
                    <div class="absolute -left-16 -top-20 h-64 w-64 rounded-full bg-[#7C3AED] opacity-30 blur-3xl" aria-hidden="true"></div>
                    <div class="absolute -bottom-24 -right-12 h-72 w-72 rounded-full bg-[#4F46E5] opacity-30 blur-3xl" aria-hidden="true"></div>

                    <div class="relative mx-auto max-w-3xl">
                        <span class="inline-flex items-center gap-2 rounded-full border border-white/20 bg-white/10 px-4 py-1.5 text-xs font-semibold tracking-wide text-purple-100">
                            <span class="h-1.5 w-1.5 rounded-full bg-[#A78BFA]"></span>
                            Pesan online tanpa antre
                        </span>

                        <h1 class="mt-6 text-4xl font-bold leading-[1.1] tracking-tight text-white sm:text-5xl lg:text-6xl">
                            Pesan Lebih Mudah, Nikmati Lebih Nyaman
                        </h1>

                        <p class="mx-auto mt-5 max-w-2xl text-base leading-relaxed text-white/70 sm:text-lg">
                            Pesan menu favoritmu lewat Pesanara — cepat, praktis, dan siap dinikmati tanpa harus mengantre.
                        </p>

                        <div class="mt-8 flex flex-col items-stretch justify-center gap-3 sm:flex-row sm:items-center sm:gap-4">
                            <a href="#menu" class="inline-flex items-center justify-center gap-2 rounded-full bg-[#8B5CF6] px-7 py-3.5 text-sm font-semibold text-white shadow-lg shadow-[#7C3AED]/30 transition hover:bg-[#7C3AED]">
                                Mulai Pesan
                                <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                                    <path d="M13.5 4.5 21 12m0 0-7.5 7.5M21 12H3" />
                                </svg>
                            </a>
                            <a href="#menu" class="inline-flex items-center justify-center gap-2 rounded-full border border-white/30 px-7 py-3.5 text-sm font-semibold text-white transition hover:bg-white/10">
                                Lihat Menu
                            </a>
                        </div>
                    </div>

                    {{-- Kartu status pesanan --}}
                    <div class="absolute bottom-8 left-8 hidden items-center gap-3 rounded-2xl bg-white px-4 py-3 shadow-xl lg:flex">
                        <span class="grid h-9 w-9 shrink-0 place-items-center rounded-full bg-[#EDE9FE] text-[#7C3AED]">
                            <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                                <circle cx="12" cy="12" r="9" />
                                <path d="m9 12 2 2 4-4" />
                            </svg>
                        </span>
                        <div class="text-left">
                            <p class="text-sm font-semibold text-[#1B1338]">Pesanan diproses</p>
                            <p class="text-xs text-slate-500">Estimasi 10 menit</p>
                        </div>
                    </div>
                </div>
            </section>

            {{-- ===================== PROFIL & KEUNGGULAN ===================== --}}
            <section id="profil" class="scroll-mt-20 px-5 py-16 sm:px-6 sm:py-20 lg:px-8 lg:py-24">
                <div class="mx-auto max-w-6xl">
                    <div class="mx-auto max-w-2xl text-center">
                        <span class="inline-flex items-center rounded-full bg-[#EDE9FE] px-4 py-1.5 text-xs font-semibold uppercase tracking-wider text-[#6D28D9]">
                            Keunggulan
                        </span>
                        <h2 class="mt-4 text-3xl font-bold tracking-tight text-[#1B1338] sm:text-4xl">
                            Kenapa Memilih Pesanara?
                        </h2>
                        <p class="mt-4 text-base leading-relaxed text-slate-500 sm:text-lg">
                            Pesanara adalah platform pemesanan menu online yang memudahkan kamu menikmati menu favorit kapan saja — tanpa antre, tanpa ribet.
                        </p>
                    </div>

                    <div id="fasilitas" class="mt-12 grid scroll-mt-24 gap-6 sm:grid-cols-2 lg:grid-cols-4">
                        <article class="rounded-2xl border border-[#ECE9F6] bg-white p-6 shadow-sm transition duration-300 hover:-translate-y-1 hover:shadow-[0_16px_40px_rgba(49,24,107,0.10)]">
                            <span class="grid h-11 w-11 place-items-center rounded-xl bg-[#EDE9FE] text-[#7C3AED]">
                                <svg class="h-6 w-6" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                                    <path d="M15.75 10.5V6a3.75 3.75 0 1 0-7.5 0v4.5m11.356-1.993 1.263 12c.07.665-.45 1.243-1.119 1.243H4.25a1.125 1.125 0 0 1-1.12-1.243l1.264-12A1.125 1.125 0 0 1 5.513 7.5h12.974c.576 0 1.059.435 1.119 1.007ZM8.625 10.5a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Z" />
                                </svg>
                            </span>
                            <h3 class="mt-4 text-base font-semibold text-[#1B1338]">Pemesanan Mudah</h3>
                            <p class="mt-2 text-sm leading-relaxed text-slate-500">Pesan menu favorit hanya dalam beberapa ketukan, langsung dari perangkatmu.</p>
                        </article>

                        <article class="rounded-2xl border border-[#ECE9F6] bg-white p-6 shadow-sm transition duration-300 hover:-translate-y-1 hover:shadow-[0_16px_40px_rgba(49,24,107,0.10)]">
                            <span class="grid h-11 w-11 place-items-center rounded-xl bg-[#EDE9FE] text-[#7C3AED]">
                                <svg class="h-6 w-6" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                                    <path d="m3.75 13.5 10.5-11.25L12 10.5h8.25L9.75 21.75 12 13.5H3.75Z" />
                                </svg>
                            </span>
                            <h3 class="mt-4 text-base font-semibold text-[#1B1338]">Proses Cepat</h3>
                            <p class="mt-2 text-sm leading-relaxed text-slate-500">Pesanan diproses secara real-time agar tidak perlu menunggu lama.</p>
                        </article>

                        <article class="rounded-2xl border border-[#ECE9F6] bg-white p-6 shadow-sm transition duration-300 hover:-translate-y-1 hover:shadow-[0_16px_40px_rgba(49,24,107,0.10)]">
                            <span class="grid h-11 w-11 place-items-center rounded-xl bg-[#EDE9FE] text-[#7C3AED]">
                                <svg class="h-6 w-6" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                                    <path d="M8.25 6.75h12M8.25 12h12M8.25 17.25h12M3.75 6.75h.007v.008H3.75V6.75Zm.375 0a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0ZM3.75 12h.007v.008H3.75V12Zm.375 0a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Zm-.375 5.25h.007v.008H3.75v-.008Zm.375 0a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Z" />
                                </svg>
                            </span>
                            <h3 class="mt-4 text-base font-semibold text-[#1B1338]">Menu Lengkap</h3>
                            <p class="mt-2 text-sm leading-relaxed text-slate-500">Beragam pilihan makanan dan minuman yang selalu diperbarui.</p>
                        </article>

                        <article class="rounded-2xl border border-[#ECE9F6] bg-white p-6 shadow-sm transition duration-300 hover:-translate-y-1 hover:shadow-[0_16px_40px_rgba(49,24,107,0.10)]">
                            <span class="grid h-11 w-11 place-items-center rounded-xl bg-[#EDE9FE] text-[#7C3AED]">
                                <svg class="h-6 w-6" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                                    <path d="M2.25 8.25h19.5M2.25 9h19.5m-16.5 5.25h6m-6 2.25h3m-3.75 3h15a2.25 2.25 0 0 0 2.25-2.25V6.75A2.25 2.25 0 0 0 19.5 4.5h-15a2.25 2.25 0 0 0-2.25 2.25v10.5A2.25 2.25 0 0 0 4.5 19.5Z" />
                                </svg>
                            </span>
                            <h3 class="mt-4 text-base font-semibold text-[#1B1338]">Pembayaran Praktis</h3>
                            <p class="mt-2 text-sm leading-relaxed text-slate-500">Beragam metode pembayaran yang aman dan nyaman sesuai pilihanmu.</p>
                        </article>
                    </div>
                </div>
            </section>

            {{-- ===================== MENU FAVORIT ===================== --}}
            @php
                $menuFavorit = [
                    ['name' => 'Kopi Susu Aren', 'description' => 'Espresso, susu segar, dan gula aren khas Pesanara.', 'price' => 'Rp 20.000'],
                    ['name' => 'Matcha Latte', 'description' => 'Matcha premium dengan susu lembut dan sedikit manis.', 'price' => 'Rp 25.000'],
                    ['name' => 'Croissant Cokelat', 'description' => 'Pastry renyah dengan isian cokelat lembut.', 'price' => 'Rp 18.000'],
                    ['name' => 'Roti Bakar Keju', 'description' => 'Roti bakar panggang dengan keju melimpah.', 'price' => 'Rp 15.000'],
                ];
            @endphp

            <section id="menu" class="scroll-mt-20 border-y border-[#ECE9F6] bg-white px-5 py-16 sm:px-6 sm:py-20 lg:px-8 lg:py-24">
                <div class="mx-auto max-w-6xl">
                    <div class="mx-auto max-w-2xl text-center">
                        <span class="inline-flex items-center rounded-full bg-[#EDE9FE] px-4 py-1.5 text-xs font-semibold uppercase tracking-wider text-[#6D28D9]">
                            Produk
                        </span>
                        <h2 class="mt-4 text-3xl font-bold tracking-tight text-[#1B1338] sm:text-4xl">
                            Menu Favorit
                        </h2>
                        <p class="mt-4 text-base leading-relaxed text-slate-500 sm:text-lg">
                            Pilihan terlaris yang sering dipesan pelanggan Pesanara.
                        </p>
                    </div>

                    <div class="mt-12 grid gap-6 sm:grid-cols-2 lg:grid-cols-4">
                        @foreach ($menuFavorit as $item)
                            <article class="group overflow-hidden rounded-2xl border border-[#ECE9F6] bg-white shadow-sm transition duration-300 hover:-translate-y-1 hover:shadow-[0_16px_40px_rgba(49,24,107,0.10)]">
                                <div class="grid aspect-[4/3] place-items-center bg-gradient-to-b from-[#F1ECFE] to-[#F8F6FF]">
                                    <svg class="h-12 w-12 text-[#7C3AED]/40 transition duration-300 group-hover:scale-110" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.4" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                                        <path d="M4 8h12v5a4 4 0 0 1-4 4H8a4 4 0 0 1-4-4V8Z" />
                                        <path d="M16 9h1.5a2.5 2.5 0 0 1 0 5H16" />
                                        <path d="M7 4.5v1.5M10 3.5v2.5M13 4.5v1.5" />
                                    </svg>
                                </div>

                                <div class="p-5">
                                    <div class="flex items-start justify-between gap-3">
                                        <h3 class="text-base font-semibold text-[#1B1338]">{{ $item['name'] }}</h3>
                                        <p class="whitespace-nowrap text-sm font-bold text-[#7C3AED]">{{ $item['price'] }}</p>
                                    </div>
                                    <p class="mt-1.5 line-clamp-2 text-sm leading-relaxed text-slate-500">{{ $item['description'] }}</p>

                                    <button type="button" class="mt-4 inline-flex w-full items-center justify-center gap-1.5 rounded-full bg-[#F3F0FD] px-4 py-2.5 text-sm font-semibold text-[#6D28D9] transition hover:bg-[#7C3AED] hover:text-white">
                                        Pesan
                                        <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                                            <path d="M13.5 4.5 21 12m0 0-7.5 7.5M21 12H3" />
                                        </svg>
                                    </button>
                                </div>
                            </article>
                        @endforeach
                    </div>
                </div>
            </section>

            {{-- ===================== LOKASI & INFORMASI ===================== --}}
            <section id="lokasi" class="scroll-mt-20 px-5 py-16 sm:px-6 sm:py-20 lg:px-8 lg:py-24">
                <div class="mx-auto max-w-6xl">
                    <div class="mx-auto max-w-2xl text-center">
                        <span class="inline-flex items-center rounded-full bg-[#EDE9FE] px-4 py-1.5 text-xs font-semibold uppercase tracking-wider text-[#6D28D9]">
                            Lokasi
                        </span>
                        <h2 class="mt-4 text-3xl font-bold tracking-tight text-[#1B1338] sm:text-4xl">
                            Kunjungi Kami
                        </h2>
                        <p class="mt-4 text-base leading-relaxed text-slate-500 sm:text-lg">
                            Datang dan nikmati langsung pengalaman Pesanara di tempat.
                        </p>
                    </div>

                    <div class="mt-12 grid items-stretch gap-6 lg:grid-cols-2 lg:gap-8">
                        {{-- Peta lokasi --}}
                        <div
                            class="relative min-h-[300px] overflow-hidden rounded-2xl border border-[#ECE9F6] bg-[#EEF0F8] shadow-sm sm:min-h-[360px] lg:min-h-[420px]"
                            style="background-image: radial-gradient(#C3C8DE 1px, transparent 1px); background-size: 18px 18px;"
                        >
                            <div class="absolute inset-0 grid place-items-center p-6 text-center">
                                <div>
                                    <span class="mx-auto grid h-14 w-14 place-items-center rounded-full bg-white text-[#7C3AED] shadow-lg">
                                        <svg class="h-7 w-7" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                                            <path d="M15 10.5a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                                            <path d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1 1 15 0Z" />
                                        </svg>
                                    </span>
                                    <p class="mt-4 text-sm font-semibold text-[#1B1338]">Peta Lokasi Pesanara</p>
                                    <p class="mt-1 text-xs text-slate-500">Tambahkan peta / iframe Google Maps di sini</p>
                                </div>
                            </div>
                        </div>

                        {{-- Informasi --}}
                        <div class="rounded-2xl border border-[#ECE9F6] bg-white p-6 shadow-sm sm:p-8">
                            <h3 class="text-lg font-bold text-[#1B1338]">Informasi Kunjungan</h3>

                            <dl class="mt-6 space-y-5">
                                <div class="flex gap-4">
                                    <span class="grid h-10 w-10 shrink-0 place-items-center rounded-xl bg-[#EDE9FE] text-[#7C3AED]">
                                        <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                                            <path d="M15 10.5a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                                            <path d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1 1 15 0Z" />
                                        </svg>
                                    </span>
                                    <div>
                                        <dt class="text-sm font-semibold text-[#1B1338]">Alamat</dt>
                                        <dd class="mt-0.5 text-sm leading-relaxed text-slate-500">Jl. Raya Contoh No. 12, Kota, Indonesia</dd>
                                    </div>
                                </div>

                                <div class="flex gap-4">
                                    <span class="grid h-10 w-10 shrink-0 place-items-center rounded-xl bg-[#EDE9FE] text-[#7C3AED]">
                                        <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                                            <circle cx="12" cy="12" r="9" />
                                            <path d="M12 6.75V12l3.75 2.25" />
                                        </svg>
                                    </span>
                                    <div>
                                        <dt class="text-sm font-semibold text-[#1B1338]">Jam Operasional</dt>
                                        <dd class="mt-0.5 text-sm leading-relaxed text-slate-500">Senin – Minggu, 08.00 – 22.00 WIB</dd>
                                    </div>
                                </div>

                                <div class="flex gap-4">
                                    <span class="grid h-10 w-10 shrink-0 place-items-center rounded-xl bg-[#EDE9FE] text-[#7C3AED]">
                                        <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                                            <path d="M2.25 6.75c0 8.284 6.716 15 15 15h2.25a2.25 2.25 0 0 0 2.25-2.25v-1.372c0-.516-.351-.966-.852-1.091l-4.423-1.106c-.44-.11-.902.055-1.173.417l-.97 1.293c-.282.376-.769.542-1.21.38a12.035 12.035 0 0 1-7.143-7.143c-.162-.441.004-.928.38-1.21l1.293-.97c.363-.271.527-.734.417-1.173L6.963 3.102a1.125 1.125 0 0 0-1.091-.852H4.5A2.25 2.25 0 0 0 2.25 4.5v2.25Z" />
                                        </svg>
                                    </span>
                                    <div>
                                        <dt class="text-sm font-semibold text-[#1B1338]">Kontak</dt>
                                        <dd class="mt-0.5 text-sm leading-relaxed text-slate-500">
                                            <a href="mailto:halo@pesanara.id" class="transition hover:text-[#6D28D9]">halo@pesanara.id</a>
                                            <span class="mx-1 text-slate-300">·</span>
                                            <a href="tel:+6281234567890" class="transition hover:text-[#6D28D9]">+62 812-3456-7890</a>
                                        </dd>
                                    </div>
                                </div>
                            </dl>

                            <div class="mt-8 flex flex-col gap-3 sm:flex-row">
                                <a
                                    href="https://www.google.com/maps/search/?api=1&query=Pesanara"
                                    target="_blank"
                                    rel="noopener noreferrer"
                                    class="inline-flex flex-1 items-center justify-center gap-2 rounded-full bg-[#7C3AED] px-6 py-3 text-sm font-semibold text-white transition hover:bg-[#6D28D9]"
                                >
                                    Buka di Google Maps
                                    <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                                        <path d="M13.5 4.5 21 12m0 0-7.5 7.5M21 12H3" />
                                    </svg>
                                </a>
                                <a href="#lokasi" class="inline-flex flex-1 items-center justify-center rounded-full border border-[#E4DFF3] px-6 py-3 text-sm font-semibold text-[#1B1338] transition hover:border-[#C9BFEA] hover:bg-[#F3F0FD]">
                                    Hubungi Kami
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </main>

        {{-- ===================== FOOTER ===================== --}}
        <footer class="bg-[#171043] text-purple-100/70">
            <div class="mx-auto grid max-w-6xl gap-10 px-5 py-14 sm:px-6 md:grid-cols-2 lg:grid-cols-4 lg:px-8">
                <div>
                    <a href="#beranda" class="flex items-center gap-2.5">
                        <span class="grid h-9 w-9 place-items-center rounded-xl bg-[#7C3AED] text-white">
                            <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                                <path d="M4 8h12v5a4 4 0 0 1-4 4H8a4 4 0 0 1-4-4V8Z" />
                                <path d="M16 9h1.5a2.5 2.5 0 0 1 0 5H16" />
                                <path d="M7 4.5v1.5M10 3.5v2.5M13 4.5v1.5" />
                            </svg>
                        </span>
                        <span class="text-lg font-bold tracking-tight text-white">Pesanara</span>
                    </a>
                    <p class="mt-4 max-w-xs text-sm leading-relaxed">
                        Platform pemesanan menu online yang memudahkan kamu menikmati makanan dan minuman favorit tanpa antre.
                    </p>
                </div>

                <div>
                    <p class="text-sm font-semibold text-white">Navigasi</p>
                    <ul class="mt-4 space-y-2 text-sm">
                        <li><a href="#beranda" class="transition hover:text-white">Beranda</a></li>
                        <li><a href="#profil" class="transition hover:text-white">Profil</a></li>
                        <li><a href="#menu" class="transition hover:text-white">Menu</a></li>
                        <li><a href="#fasilitas" class="transition hover:text-white">Fasilitas</a></li>
                        <li><a href="#lokasi" class="transition hover:text-white">Lokasi</a></li>
                    </ul>
                </div>

                <div>
                    <p class="text-sm font-semibold text-white">Layanan</p>
                    <ul class="mt-4 space-y-2 text-sm">
                        <li><a href="#menu" class="transition hover:text-white">Pesan Online</a></li>
                        <li><a href="#fasilitas" class="transition hover:text-white">Fasilitas Tempat</a></li>
                        <li><a href="#lokasi" class="transition hover:text-white">Informasi Kontak</a></li>
                    </ul>
                </div>

                <div>
                    <p class="text-sm font-semibold text-white">Ikuti Kami</p>
                    <div class="mt-4 flex items-center gap-3">
                        <a href="#" aria-label="Instagram" class="grid h-9 w-9 place-items-center rounded-full bg-white/10 text-purple-100 transition hover:bg-[#7C3AED] hover:text-white">
                            <svg class="h-4.5 w-4.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                                <rect width="20" height="20" x="2" y="2" rx="5" ry="5"/>
                                <path d="M16 11.37A4 4 0 1 1 12.63 8 4 4 0 0 1 16 11.37z"/>
                                <line x1="17.5" x2="17.51" y1="6.5" y2="6.5"/>
                            </svg>
                        </a>
                    </div>
                </div>
            </div>

            <div class="border-t border-white/10 py-6 text-center text-xs text-purple-100/50">
                <p>&copy; {{ date('Y') }} Pesanara. All rights reserved.</p>
            </div>
        </footer>

        {{-- Script Toggle Menu Mobile --}}
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                const navToggle = document.getElementById('nav-toggle');
                const mobileMenu = document.getElementById('nav-mobile-menu');

                if (navToggle && mobileMenu) {
                    navToggle.addEventListener('click', function () {
                        const isExpanded = navToggle.getAttribute('aria-expanded') === 'true';
                        navToggle.setAttribute('aria-expanded', !isExpanded);
                        mobileMenu.classList.toggle('hidden');
                    });
                }
            });
        </script>
    </body>
</html>