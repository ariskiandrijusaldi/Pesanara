<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Laporan Penjualan — HQ Coffee & Bites</title>

        <script>document.documentElement.classList.add('js');</script>

        @fonts
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>

    @php
        // Ganti dengan data dari database (mis. hasil query penjualan 5 hari terakhir)
        $rekap = [
            ['tanggal' => 'Sabtu, 24 Mei 2025', 'today' => true, 'pesanan' => 52, 'omzet' => 4850000],
            ['tanggal' => 'Jumat, 23 Mei 2025', 'pesanan' => 48, 'omzet' => 4340000],
            ['tanggal' => 'Kamis, 22 Mei 2025', 'pesanan' => 41, 'omzet' => 3800000],
            ['tanggal' => 'Rabu, 21 Mei 2025', 'pesanan' => 44, 'omzet' => 4010000],
            ['tanggal' => 'Selasa, 20 Mei 2025', 'pesanan' => 39, 'omzet' => 3550000],
        ];

        $hariIni = $rekap[0];
        $rupiah = fn ($n) => 'Rp ' . number_format($n, 0, ',', '.');
        $rataStruk = intdiv($hariIni['omzet'], max(1, $hariIni['pesanan']));

        // Kurva penjualan: titik-titik omzet (juta rupiah) sepanjang siklus
        $kurva = [1.2, 2.0, 3.0, 2.6, 4.2, 4.9, 5.7];
        $weekLabels = ['Minggu 1', 'Minggu 2', 'Minggu 3', 'Minggu 4 (Aktif)'];

        $w = 520; $h = 140; $padX = 14; $padTop = 14; $padBottom = 14;
        $min = min($kurva); $max = max($kurva);
        $points = [];
        foreach ($kurva as $i => $v) {
            $x = $padX + ($w - 2 * $padX) * $i / (count($kurva) - 1);
            $y = $padTop + ($h - $padTop - $padBottom) * (1 - ($v - $min) / ($max - $min));
            $points[] = [round($x, 1), round($y, 1)];
        }
        $line = implode(' ', array_map(fn ($p) => $p[0] . ',' . $p[1], $points));
        $area = $line . ' ' . $points[count($points) - 1][0] . ',' . $h . ' ' . $points[0][0] . ',' . $h;
    @endphp

    <body class="min-h-screen overflow-x-hidden bg-[#FAFAFC] font-sans text-slate-600 antialiased">

        {{-- ===================== NAVBAR ===================== --}}
        <header class="border-b border-[#ECE9F6] bg-white">
            <div class="mx-auto flex max-w-5xl items-center justify-between gap-4 px-5 py-3 sm:px-6 lg:px-8">
                <a href="#" class="flex items-center gap-2.5">
                    <span class="grid h-9 w-9 place-items-center rounded-xl bg-[#7C3AED] text-white shadow-md shadow-[#7C3AED]/30">
                        <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                            <path d="M4 8h12v5a4 4 0 0 1-4 4H8a4 4 0 0 1-4-4V8Z" />
                            <path d="M16 9h1.5a2.5 2.5 0 0 1 0 5H16" />
                        </svg>
                    </span>
                    <span class="leading-tight">
                        <span class="block text-sm font-bold text-[#1B1338]">HQ Coffee &amp; Bites</span>
                        <span class="block text-[10px] font-semibold uppercase tracking-wider text-[#7C3AED]">Owner Portal</span>
                    </span>
                </a>

                <nav class="hidden items-center gap-1 rounded-xl bg-[#F3F0FD] p-1 sm:flex" aria-label="Navigasi owner">
                    <a href="#" aria-current="page" class="rounded-lg bg-white px-4 py-1.5 text-xs font-semibold text-[#6D28D9] shadow-sm">Ringkasan Laporan</a>
                    <a href="#" class="rounded-lg px-4 py-1.5 text-xs font-semibold text-slate-600 transition hover:text-[#6D28D9]">Kelola Menu</a>
                </nav>

                <div class="flex items-center gap-2.5">
                    <span class="hidden text-right leading-tight sm:block">
                        <span class="block text-xs font-semibold text-[#1B1338]">Owner HQ</span>
                        <span class="block text-[10px] text-slate-500">owner@hqcoffee.id</span>
                    </span>
                    <span class="grid h-8 w-8 place-items-center rounded-full bg-[#7C3AED] text-white">
                        <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><circle cx="12" cy="8" r="4" /><path d="M4 21a8 8 0 0 1 16 0" /></svg>
                    </span>
                </div>
            </div>

            {{-- Navigasi mobile --}}
            <nav class="flex gap-1 border-t border-[#ECE9F6] px-5 py-2 sm:hidden" aria-label="Navigasi owner mobile">
                <a href="#" aria-current="page" class="flex-1 rounded-lg bg-[#F3F0FD] py-2 text-center text-xs font-semibold text-[#6D28D9]">Ringkasan Laporan</a>
                <a href="#" class="flex-1 rounded-lg py-2 text-center text-xs font-semibold text-slate-600">Kelola Menu</a>
            </nav>
        </header>

        <main class="mx-auto max-w-5xl px-5 py-8 sm:px-6 lg:px-8">

            {{-- ===================== JUDUL & AKSI ===================== --}}
            <div class="flex flex-col gap-5 lg:flex-row lg:items-end lg:justify-between">
                <div class="reveal">
                    <p class="inline-flex items-center gap-1.5 text-[10px] font-bold uppercase tracking-wider text-[#6D28D9]">
                        <svg class="h-3.5 w-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M3 3v18h18M7 15l4-4 3 3 5-6" /></svg>
                        Owner Financial Overview
                    </p>
                    <h1 class="mt-2 text-3xl font-bold tracking-tight text-[#1B1338] sm:text-4xl">Laporan Penjualan</h1>
                    <p class="mt-2 text-sm text-slate-500">Tinjauan omzet bersih dan performa penjualan 100% cashless QRIS.</p>
                </div>

                <div class="reveal flex flex-wrap items-center gap-1 self-start rounded-xl border border-[#ECE9F6] bg-white p-1 shadow-sm lg:self-auto" id="period-tabs" style="--reveal-delay: 80ms">
                    <button type="button" data-period="harian" class="period-btn inline-flex items-center gap-1.5 rounded-lg bg-[#F3F0FD] px-3 py-1.5 text-xs font-semibold text-[#6D28D9]">
                        <svg class="h-3.5 w-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><rect x="3" y="5" width="18" height="16" rx="2" /><path d="M3 10h18M8 3v4M16 3v4" /></svg>
                        Laporan Harian
                    </button>
                    <button type="button" data-period="bulanan" class="period-btn inline-flex items-center gap-1.5 rounded-lg px-3 py-1.5 text-xs font-semibold text-slate-600 transition hover:bg-[#F3F0FD]">
                        <svg class="h-3.5 w-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><rect x="3" y="5" width="18" height="16" rx="2" /><path d="M3 10h18M8 3v4M16 3v4" /></svg>
                        Laporan Bulanan
                    </button>
                    <span class="mx-1 h-4 w-px bg-[#ECE9F6]" aria-hidden="true"></span>
                    <a href="#" class="inline-flex items-center gap-1.5 rounded-lg px-3 py-1.5 text-xs font-semibold text-slate-600 transition hover:bg-[#F3F0FD]">
                        <svg class="h-3.5 w-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M12 4v11m0 0-4-4m4 4 4-4M5 20h14" /></svg>
                        Unduh Rekap
                    </a>
                </div>
            </div>

            {{-- ===================== KARTU RINGKASAN ===================== --}}
            <section class="reveal stagger mt-8 grid gap-4 md:grid-cols-3" aria-label="Ringkasan hari ini">
                <article class="rounded-2xl border border-[#ECE9F6] bg-white p-5 shadow-sm">
                    <div class="flex items-start justify-between">
                        <p class="text-[10px] font-bold uppercase tracking-wider text-slate-500">Omzet Hari Ini</p>
                        <span class="grid h-7 w-7 place-items-center rounded-lg bg-[#EDE9FE] text-[#7C3AED]">
                            <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><rect x="2" y="6" width="20" height="12" rx="2" /><circle cx="12" cy="12" r="2.5" /></svg>
                        </span>
                    </div>
                    <p class="mt-4 text-3xl font-bold tracking-tight text-[#1B1338]">{{ $rupiah($hariIni['omzet']) }}</p>
                    <p class="mt-1 inline-flex items-center gap-1 text-xs font-medium text-[#6D28D9]">
                        <svg class="h-3.5 w-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="m3 17 6-6 4 4 8-8M15 7h6v6" /></svg>
                        +12% dibanding kemarin
                    </p>
                    <div class="mt-5 flex items-center justify-between border-t border-[#F1EEFA] pt-3 text-xs">
                        <span class="text-slate-500">Sabtu, 24 Mei 2025</span>
                        <span class="rounded-full bg-[#EDE9FE] px-2 py-0.5 text-[10px] font-bold text-[#6D28D9]">100% QRIS</span>
                    </div>
                </article>

                <article class="rounded-2xl border border-[#ECE9F6] bg-white p-5 shadow-sm">
                    <div class="flex items-start justify-between">
                        <p class="text-[10px] font-bold uppercase tracking-wider text-slate-500">Pesanan Berhasil</p>
                        <span class="grid h-7 w-7 place-items-center rounded-lg bg-[#EDE9FE] text-[#7C3AED]">
                            <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M6 3h12v18l-3-2-3 2-3-2-3 2V3ZM9 8h6M9 12h6" /></svg>
                        </span>
                    </div>
                    <p class="mt-4 flex items-baseline gap-2"><span class="text-3xl font-bold tracking-tight text-[#1B1338]">{{ $hariIni['pesanan'] }}</span><span class="text-lg text-slate-600">Pesanan</span></p>
                    <p class="mt-1 inline-flex items-center gap-1 text-xs font-medium text-[#6D28D9]">
                        <svg class="h-3.5 w-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><circle cx="12" cy="12" r="9" /><path d="m9 12 2 2 4-4" /></svg>
                        Semua transaksi sukses
                    </p>
                    <div class="mt-5 flex items-center justify-between border-t border-[#F1EEFA] pt-3 text-xs">
                        <span class="text-slate-500">Status Kasir</span>
                        <span class="font-semibold text-[#1B1338]">Tutup Kasir Klop</span>
                    </div>
                </article>

                <article class="rounded-2xl border border-[#ECE9F6] bg-white p-5 shadow-sm">
                    <div class="flex items-start justify-between">
                        <p class="text-[10px] font-bold uppercase tracking-wider text-slate-500">Rata-Rata Transaksi</p>
                        <span class="grid h-7 w-7 place-items-center rounded-lg bg-[#EDE9FE] text-[#7C3AED]">
                            <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M4 6h10M4 12h16M4 18h10M18 4v4M18 16v4" /></svg>
                        </span>
                    </div>
                    <p class="mt-4 text-3xl font-bold tracking-tight text-[#1B1338]">{{ $rupiah($rataStruk) }}</p>
                    <p class="mt-1 inline-flex items-center gap-1 text-xs font-medium text-slate-500">
                        <svg class="h-3.5 w-3.5 text-[#7C3AED]" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M5 12h3v7H5zM10.5 5h3v14h-3zM16 9h3v10h-3z" /></svg>
                        Rerata belanja per struk
                    </p>
                    <div class="mt-5 flex items-center justify-between border-t border-[#F1EEFA] pt-3 text-xs">
                        <span class="text-slate-500">Metode Bayar</span>
                        <span class="font-semibold text-[#1B1338]">QRIS Dinamis</span>
                    </div>
                </article>
            </section>

            {{-- ===================== REKAP HARIAN ===================== --}}
            <section class="mt-8 rounded-2xl border border-[#ECE9F6] bg-white p-5 shadow-sm sm:p-6">
                <div class="flex flex-col gap-3 sm:flex-row sm:items-start sm:justify-between">
                    <div>
                        <h2 class="text-lg font-bold text-[#1B1338]">Rekap Penjualan Harian</h2>
                        <p class="mt-0.5 text-xs text-slate-500">Histori pemerimaan harian 5 hari ke belakang terverifikasi klop.</p>
                    </div>
                    <span class="inline-flex items-center gap-1.5 self-start rounded-full border border-[#E4DFF3] bg-[#F7F5FE] px-3 py-1 text-[10px] font-semibold text-[#6D28D9]">
                        <svg class="h-3.5 w-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M12 3 4 6v6c0 4.5 3.4 8 8 9 4.6-1 8-4.5 8-9V6l-8-3Z" /><path d="m9 12 2 2 4-4" /></svg>
                        Terverifikasi Sistem Finansial
                    </span>
                </div>

                <div class="mt-5 overflow-x-auto">
                    <table class="w-full min-w-[620px] text-left text-xs">
                        <thead>
                            <tr class="bg-[#F7F5FE] text-[10px] font-bold uppercase tracking-wider text-slate-500">
                                <th scope="col" class="rounded-l-lg px-4 py-3">Tanggal</th>
                                <th scope="col" class="px-4 py-3">Jumlah Pesanan</th>
                                <th scope="col" class="px-4 py-3">Omzet QRIS</th>
                                <th scope="col" class="rounded-r-lg px-4 py-3 text-right">Status Setoran</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-[#F1EEFA]">
                            @foreach ($rekap as $r)
                                <tr>
                                    <td class="px-4 py-4">
                                        <p class="font-semibold text-[#1B1338]">{{ $r['tanggal'] }}</p>
                                        @if (!empty($r['today']))
                                            <p class="text-[10px] font-medium text-[#7C3AED]">Hari ini</p>
                                        @endif
                                    </td>
                                    <td class="px-4 py-4 text-slate-600">{{ $r['pesanan'] }} Pesanan</td>
                                    <td class="px-4 py-4 font-semibold text-[#1B1338]">{{ $rupiah($r['omzet']) }}</td>
                                    <td class="px-4 py-4 text-right">
                                        <span class="inline-flex items-center gap-1 rounded-full bg-[#EDE9FE] px-2.5 py-1 text-[10px] font-bold text-[#6D28D9]">
                                            <svg class="h-3 w-3" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><circle cx="12" cy="12" r="9" /><path d="m9 12 2 2 4-4" /></svg>
                                            Selesai &amp; Klop
                                        </span>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </section>

            {{-- ===================== KURVA PENJUALAN ===================== --}}
            <section class="mt-8 rounded-2xl border border-[#ECE9F6] bg-white p-5 shadow-sm sm:p-6">
                <div class="flex flex-col gap-3 sm:flex-row sm:items-start sm:justify-between">
                    <div>
                        <h2 class="text-lg font-bold text-[#1B1338]">Kurva Ritme Penjualan</h2>
                        <p class="mt-0.5 text-xs text-slate-500">Tren pergerakan akumulasi penjualan sepanjang siklus operasional</p>
                    </div>
                    <span class="inline-flex items-center gap-2 self-start text-[10px] font-semibold text-slate-600">
                        <span class="h-2 w-2 rounded-full bg-[#5B2BD8]"></span> Omzet Bersih QRIS
                    </span>
                </div>

                <div class="mt-6">
                    <svg viewBox="0 0 {{ $w }} {{ $h }}" class="h-44 w-full" preserveAspectRatio="none" role="img" aria-label="Grafik kurva omzet bersih QRIS selama empat minggu">
                        <defs>
                            <linearGradient id="area-fill" x1="0" y1="0" x2="0" y2="1">
                                <stop offset="0%" stop-color="#7C3AED" stop-opacity="0.18" />
                                <stop offset="100%" stop-color="#7C3AED" stop-opacity="0" />
                            </linearGradient>
                        </defs>
                        <polygon points="{{ $area }}" fill="url(#area-fill)" />
                        <polyline points="{{ $line }}" fill="none" stroke="#5B2BD8" stroke-width="3" stroke-linejoin="round" stroke-linecap="round" vector-effect="non-scaling-stroke" />
                    </svg>

                    {{-- Titik ditaruh sebagai elemen HTML agar tetap bulat saat SVG melebar --}}
                    <div class="relative -mt-44 h-44 w-full" aria-hidden="true">
                        @foreach ($points as $p)
                            <span class="absolute h-2.5 w-2.5 -translate-x-1/2 -translate-y-1/2 rounded-full border-2 border-[#5B2BD8] bg-white"
                                  style="left: {{ round($p[0] / $w * 100, 2) }}%; top: {{ round($p[1] / $h * 100, 2) }}%"></span>
                        @endforeach
                    </div>

                    <div class="mt-3 flex justify-between border-t border-[#F1EEFA] pt-3 text-[11px] font-medium text-slate-500">
                        @foreach ($weekLabels as $i => $label)
                            <span class="{{ $loop->last ? 'font-semibold text-[#7C3AED]' : '' }}">{{ $label }}</span>
                        @endforeach
                    </div>
                </div>
            </section>
        </main>

        {{-- ===================== FOOTER ===================== --}}
        <footer class="mt-6 border-t border-[#ECE9F6] bg-white">
            <div class="mx-auto flex max-w-5xl flex-col items-center justify-between gap-2 px-5 py-4 text-[11px] text-slate-500 sm:flex-row sm:px-6 lg:px-8">
                <p><span class="mr-2 font-bold uppercase text-[#7C3AED]">HQ Coffee &amp; Bites</span>· Sistem Manajemen &amp; Portofolio Bisnis Terpadu</p>
                <p>© {{ date('Y') }} HQ Coffee &amp; Bites. Hak Cipta Dilindungi.</p>
            </div>
        </footer>

        <script>
            document.addEventListener('DOMContentLoaded', function () {
                const buttons = document.querySelectorAll('.period-btn');
                buttons.forEach((btn) => {
                    btn.addEventListener('click', () => {
                        buttons.forEach((b) => {
                            const on = b === btn;
                            b.classList.toggle('bg-[#F3F0FD]', on);
                            b.classList.toggle('text-[#6D28D9]', on);
                            b.classList.toggle('text-slate-600', !on);
                        });
                        // TODO: muat data harian/bulanan sesuai btn.dataset.period (fetch atau ?periode=)
                    });
                });
            });
        </script>
    </body>
</html>