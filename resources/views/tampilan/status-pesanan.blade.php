<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Status Pesanan — HQ Coffee &amp; Bites | Pesanara</title>
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <script>document.documentElement.classList.add('js');</script>

        @fonts
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
        @vite(['resources/css/app.css', 'resources/js/app.js'])

        <style>
            .step-line {
                transition: all 0.4s ease;
            }
            .step-circle {
                transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            }
            @keyframes pulse-ring {
                0% { transform: scale(0.95); opacity: 0.8; }
                50% { transform: scale(1.15); opacity: 0.3; }
                100% { transform: scale(0.95); opacity: 0.8; }
            }
            .pulse-ring {
                animation: pulse-ring 2s infinite ease-in-out;
            }
        </style>
    </head>

    @php
        $orderType = $order->order_type;
        $isTakeaway = $order->isTakeaway();
        $totalFormatted = number_format($order->total, 0, ',', '.');
        $orderCode = '#'.$order->code;
        $isPaid = $order->payment_status === 'lunas';
    @endphp

    <body class="min-h-screen bg-[#FAFAFC] font-sans text-slate-600 antialiased py-6 px-4 flex flex-col justify-between items-center" data-order-code="{{ $order->code }}" data-status-url="{{ route('orders.status', $order) }}">

        <div class="w-full max-w-lg bg-white rounded-3xl p-5 sm:p-6 shadow-xl border border-slate-100 space-y-5">

            {{-- Top Bar & Header --}}
            <div class="flex items-center justify-between pb-4 border-b border-slate-100">
                <div class="flex items-center gap-3">
                    <span class="grid h-10 w-10 place-items-center rounded-2xl bg-[#7C3AED] text-xs font-bold text-white shadow-md shadow-[#7C3AED]/25">
                        HQ
                    </span>
                    <div>
                        <div class="flex items-center gap-2">
                            <h1 class="text-sm font-bold text-[#1B1338]">Status Pesanan</h1>
                            <span class="inline-flex items-center gap-1 rounded-full bg-emerald-50 border border-emerald-200/80 px-2 py-0.5 text-[10px] font-semibold text-emerald-700">
                                <span class="h-1.5 w-1.5 animate-pulse rounded-full bg-emerald-500"></span>
                                Live Sync
                            </span>
                        </div>
                        <p class="text-xs text-slate-400">Order ID: <strong class="text-slate-700">{{ $orderCode }}</strong></p>
                    </div>
                </div>

                <div class="flex items-center gap-2">
                    <a href="{{ route('landing') }}" class="inline-flex items-center gap-1 rounded-full border border-[#E4DFF3] bg-[#F3F0FD] px-3 py-1.5 text-xs font-semibold text-[#6D28D9] transition hover:bg-[#EDE9FE]">
                        <i class="fa-solid fa-house text-[10px]"></i> Beranda
                    </a>
                    <a href="{{ route('pemesanan') }}" class="inline-flex items-center gap-1 rounded-full border border-slate-200 bg-slate-50 px-3 py-1.5 text-xs font-semibold text-slate-600 transition hover:bg-slate-100">
                        <i class="fa-solid fa-arrow-left text-[10px]"></i> Menu
                    </a>
                </div>
            </div>

            {{-- Badge Jenis Pemesanan (Dine-in vs Takeaway) --}}
            <div class="{{ $isTakeaway ? 'bg-amber-50 border-amber-200/80 text-amber-900' : 'bg-[#F3F0FD] border-indigo-100 text-indigo-900' }} border rounded-2xl p-4 flex items-center justify-between">
                <div class="flex items-center gap-3">
                    <div class="p-2.5 {{ $isTakeaway ? 'bg-amber-100 text-amber-700' : 'bg-indigo-100 text-indigo-700' }} rounded-xl">
                        <i class="fa-solid {{ $isTakeaway ? 'fa-bag-shopping' : 'fa-utensils' }} text-base"></i>
                    </div>
                    <div>
                        <span class="text-[10px] font-bold uppercase tracking-wider {{ $isTakeaway ? 'text-amber-700' : 'text-indigo-600' }}">Jenis Pemesanan</span>
                        <h2 class="text-sm font-bold text-[#1B1338]">{{ $isTakeaway ? 'Takeaway (Bawa Pulang)' : 'Dine-In (Makan di Tempat)' }}</h2>
                        <p class="text-xs text-slate-500">{{ $isTakeaway ? 'Ambil di counter kasir saat nomor dipanggil' : 'Meja 01 • Pesanan diantar staf ke meja' }}</p>
                    </div>
                </div>
                <span class="px-2.5 py-1 rounded-lg text-xs font-bold {{ $isTakeaway ? 'bg-amber-200/60 text-amber-800' : 'bg-indigo-200/60 text-indigo-800' }}">
                    {{ $isTakeaway ? 'Pick-up' : 'Meja 01' }}
                </span>
            </div>

            {{-- Banner Status Utama --}}
            <div id="status-card" class="bg-gradient-to-br from-[#7C3AED] to-[#5B21B6] rounded-2xl p-5 text-white text-center shadow-lg shadow-[#7C3AED]/20 relative overflow-hidden">
                <div class="absolute -right-6 -bottom-6 w-24 h-24 rounded-full bg-white/10 blur-xl"></div>
                
                <div id="status-icon-wrap" class="w-14 h-14 mx-auto rounded-2xl bg-white/20 flex items-center justify-center text-2xl mb-3 shadow-inner">
                    <i id="status-icon" class="fa-solid fa-fire-burner animate-bounce"></i>
                </div>
                <h3 id="status-title" class="text-lg font-extrabold tracking-tight">Pesanan Sedang Diproses Dapur</h3>
                <p id="status-desc" class="text-xs text-white/85 mt-1 max-w-sm mx-auto leading-relaxed">
                    Barista dan kru dapur kami sedang meracik pesanan spesial Anda. Estimasi siap dalam 5–10 menit.
                </p>
            </div>

            {{-- Stepper Progress Alur Sistem --}}
            <div class="py-2">
                <p class="text-xs font-bold uppercase tracking-wider text-slate-400 mb-3">Alur Status Pesanan</p>
                <div class="space-y-4">
                    {{-- Step 1: Dibayar --}}
                    <div id="step-row-1" class="flex items-start gap-3.5">
                        <div id="step-dot-1" class="grid place-items-center h-8 w-8 rounded-full bg-emerald-500 text-white font-bold text-xs shrink-0 shadow-sm shadow-emerald-500/30">
                            <i id="step-icon-1" class="fa-solid fa-check"></i>
                        </div>
                        <div class="pt-0.5">
                            <p id="step-title-1" class="text-xs font-bold text-[#1B1338]">1. Pembayaran Berhasil (Status: Dibayar)</p>
                            <p id="step-desc-1" class="text-[11px] text-slate-400">
                                @if ($isPaid)
                                    Pembayaran {{ $order->payment_method === 'qris' ? 'QRIS' : 'di kasir' }} Rp {{ $totalFormatted }} telah diverifikasi oleh kasir.
                                @elseif ($order->payment_method === 'qris')
                                    Menunggu verifikasi pembayaran QRIS Rp {{ $totalFormatted }} oleh kasir.
                                @else
                                    Menunggu pembayaran Rp {{ $totalFormatted }} di kasir.
                                @endif
                            </p>
                        </div>
                    </div>

                    {{-- Step 2: Dapur / Barista --}}
                    <div id="step-row-2" class="flex items-start gap-3.5">
                        <div id="step-dot-2" class="grid place-items-center h-8 w-8 rounded-full bg-[#7C3AED] text-white font-bold text-xs shrink-0 shadow-sm shadow-[#7C3AED]/30 ring-4 ring-[#7C3AED]/20">
                            <i class="fa-solid fa-mug-hot"></i>
                        </div>
                        <div class="pt-0.5">
                            <p id="step-title-2" class="text-xs font-bold text-[#6D28D9]">2. Menyiapkan Pesanan (Dapur &amp; Barista)</p>
                            <p id="step-desc-2" class="text-[11px] text-slate-500">Kru HQ Coffee sedang meracik menu dengan teliti dan higienis.</p>
                        </div>
                    </div>

                    {{-- Step 3: Siap Diantar / Siap Diambil di Kasir --}}
                    <div id="step-row-3" class="flex items-start gap-3.5 opacity-60">
                        <div id="step-dot-3" class="grid place-items-center h-8 w-8 rounded-full bg-slate-200 text-slate-500 font-bold text-xs shrink-0">
                            <i class="fa-solid {{ $isTakeaway ? 'fa-bullhorn' : 'fa-bell-concierge' }}"></i>
                        </div>
                        <div class="pt-0.5">
                            <p id="step-title-3" class="text-xs font-bold text-slate-700">
                                3. {{ $isTakeaway ? 'Pesanan Siap (Panggil Ambil di Kasir)' : 'Pesanan Siap (Mengantar ke Meja)' }}
                            </p>
                            <p id="step-desc-3" class="text-[11px] text-slate-400">
                                {{ $isTakeaway ? 'Pesanan sudah dibungkus rapi dan siap diambil di counter pick-up.' : 'Pelayan akan mengantarkan pesanan langsung ke Meja 01.' }}
                            </p>
                        </div>
                    </div>

                    {{-- Step 4: Selesai --}}
                    <div id="step-row-4" class="flex items-start gap-3.5 opacity-60">
                        <div id="step-dot-4" class="grid place-items-center h-8 w-8 rounded-full bg-slate-200 text-slate-500 font-bold text-xs shrink-0">
                            <i class="fa-solid fa-circle-check"></i>
                        </div>
                        <div class="pt-0.5">
                            <p id="step-title-4" class="text-xs font-bold text-slate-700">4. Pesanan Selesai Diterima</p>
                            <p id="step-desc-4" class="text-[11px] text-slate-400">Transaksi dicatat otomatis ke laporan penjualan sistem.</p>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Ringkasan Pesanan --}}
            <div class="border-t border-slate-100 pt-4 space-y-2 text-xs">
                <div class="flex justify-between items-center text-slate-500">
                    <span>Metode Pembayaran</span>
                    <span id="payment-status-label" class="font-semibold inline-flex items-center gap-1 {{ $isPaid ? 'text-emerald-600' : 'text-amber-600' }}">
                        @if ($isPaid)
                            <i class="fa-solid fa-circle-check"></i> {{ $order->payment_method === 'qris' ? 'QRIS Lunas' : 'Tunai Lunas' }}
                        @elseif ($order->payment_method === 'qris')
                            <i class="fa-solid fa-hourglass-half"></i> Menunggu Verifikasi QRIS
                        @else
                            <i class="fa-solid fa-cash-register"></i> Bayar di Kasir
                        @endif
                    </span>
                </div>
                <div class="flex justify-between items-center text-slate-500">
                    <span>Kemasan &amp; Tas Kantong</span>
                    <span class="font-semibold text-[#059669]">GRATIS</span>
                </div>
                <div class="flex justify-between items-center text-slate-800 font-bold text-sm pt-1 border-t border-slate-100">
                    <span>Total Pembayaran</span>
                    <span class="text-[#6D28D9]">Rp {{ $totalFormatted }}</span>
                </div>
            </div>

            {{-- Info Status Realtime --}}
            <div class="bg-slate-50 rounded-2xl p-4 border border-dashed border-slate-200 text-center space-y-2">
                <p class="text-[11px] font-bold uppercase tracking-wider text-slate-500">
                    <i class="fa-solid fa-arrows-rotate text-[#7C3AED] mr-1"></i> Status Diperbarui Otomatis
                </p>
                <p id="live-status-note" class="text-[11px] text-slate-400">Halaman ini memantau status pesanan dari kasir secara langsung.</p>
                <a href="{{ route('landing') }}" class="inline-flex w-full items-center justify-center gap-2 rounded-xl bg-[#7C3AED] px-4 py-2.5 text-xs font-bold text-white transition hover:bg-[#6D28D9]">
                    <i class="fa-solid fa-house"></i> Kembali ke Beranda HQ Coffee
                </a>
            </div>

            {{-- Tombol Bantuan Staff --}}
            <div class="flex items-center justify-between gap-3 pt-2">
                <a href="{{ route('landing') }}" class="flex-1 text-center rounded-2xl bg-slate-100 px-4 py-3 text-xs font-bold text-slate-700 transition hover:bg-slate-200">
                    Kembali ke Beranda
                </a>
                <a href="{{ route('pemesanan') }}" class="flex-1 text-center rounded-2xl bg-slate-100 px-4 py-3 text-xs font-bold text-slate-700 transition hover:bg-slate-200">
                    Pesan Menu Lain
                </a>
                <button type="button" id="btn-call-help" class="flex-1 rounded-2xl bg-[#7C3AED] px-4 py-3 text-xs font-bold text-white transition hover:bg-[#6D28D9]">
                    <i class="fa-solid fa-bell mr-1"></i> Bantuan {{ $isTakeaway ? 'Kasir' : 'Pelayan' }}
                </button>
            </div>

        </div>

        <p class="mt-4 text-center text-xs text-slate-400">
            HQ Coffee &amp; Bites • Sistem Pesanara Self-Order &amp; POS Realtime
        </p>

        <script>
            document.addEventListener('DOMContentLoaded', function () {
                const isTakeaway = {{ $isTakeaway ? 'true' : 'false' }};
                const isQris = {{ $order->payment_method === 'qris' ? 'true' : 'false' }};
                const orderCode = @json($orderCode);
                const totalFormatted = @json($totalFormatted);
                const statusUrl = document.body.dataset.statusUrl;

                const statusCard = document.getElementById('status-card');
                const statusIcon = document.getElementById('status-icon');
                const statusTitle = document.getElementById('status-title');
                const statusDesc = document.getElementById('status-desc');
                const paymentStatusLabel = document.getElementById('payment-status-label');
                const stepDesc1 = document.getElementById('step-desc-1');
                const liveStatusNote = document.getElementById('live-status-note');

                const stepRow1 = document.getElementById('step-row-1');
                const stepDot1 = document.getElementById('step-dot-1');
                const stepIcon1 = document.getElementById('step-icon-1');
                const stepTitle1 = document.getElementById('step-title-1');

                const stepRow2 = document.getElementById('step-row-2');
                const stepDot2 = document.getElementById('step-dot-2');
                const stepRow3 = document.getElementById('step-row-3');
                const stepDot3 = document.getElementById('step-dot-3');
                const stepRow4 = document.getElementById('step-row-4');
                const stepDot4 = document.getElementById('step-dot-4');

                const dotPending = 'grid place-items-center h-8 w-8 rounded-full bg-slate-200 text-slate-500 font-bold text-xs shrink-0';
                const dotActive = 'grid place-items-center h-8 w-8 rounded-full bg-[#7C3AED] text-white font-bold text-xs shrink-0 shadow-sm shadow-[#7C3AED]/30 ring-4 ring-[#7C3AED]/20';
                const dotDone = 'grid place-items-center h-8 w-8 rounded-full bg-emerald-500 text-white font-bold text-xs shrink-0';

                let lastStatus = null;

                function markStep1Paid() {
                    stepRow1.className = 'flex items-start gap-3.5';
                    stepDot1.className = dotDone;
                    stepIcon1.className = 'fa-solid fa-check';
                    stepTitle1.textContent = '1. Pembayaran Berhasil (Status: Dibayar)';
                    stepDesc1.textContent = 'Pembayaran ' + (isQris ? 'QRIS' : 'di kasir') + ' Rp ' + totalFormatted + ' telah diverifikasi oleh kasir.';
                }

                function markStep1Waiting() {
                    stepRow1.className = 'flex items-start gap-3.5';
                    stepDot1.className = 'grid place-items-center h-8 w-8 rounded-full bg-amber-500 text-white font-bold text-xs shrink-0 ring-4 ring-amber-500/20';
                    stepIcon1.className = 'fa-solid fa-hourglass-half animate-pulse';
                    stepTitle1.textContent = '1. Menunggu Verifikasi Pembayaran';
                    stepDesc1.textContent = isQris
                        ? 'Menunggu verifikasi pembayaran QRIS Rp ' + totalFormatted + ' oleh kasir.'
                        : 'Menunggu pembayaran Rp ' + totalFormatted + ' di kasir.';
                }

                function resetSteps() {
                    stepRow2.className = 'flex items-start gap-3.5 opacity-60';
                    stepDot2.className = dotPending;
                    stepDot2.innerHTML = '2';
                    stepRow3.className = 'flex items-start gap-3.5 opacity-60';
                    stepDot3.className = dotPending;
                    stepDot3.innerHTML = '3';
                    stepRow4.className = 'flex items-start gap-3.5 opacity-60';
                    stepDot4.className = dotPending;
                    stepDot4.innerHTML = '4';
                }

                function showWaitingPayment() {
                    statusCard.className = 'bg-gradient-to-br from-amber-500 to-orange-600 rounded-2xl p-5 text-white text-center shadow-lg shadow-amber-500/20 relative overflow-hidden';
                    statusIcon.className = 'fa-solid fa-hourglass-half animate-pulse';
                    statusTitle.textContent = 'Menunggu Verifikasi Pembayaran';
                    statusDesc.textContent = isQris
                        ? 'Pembayaran QRIS Anda sudah diterima sistem dan sedang dicek oleh kasir.'
                        : 'Silakan selesaikan pembayaran di kasir. Pesanan akan diproses setelah pembayaran diterima.';

                    markStep1Waiting();
                    stepRow2.className = 'flex items-start gap-3.5 opacity-60';
                    stepDot2.className = dotPending;
                    stepRow3.className = 'flex items-start gap-3.5 opacity-60';
                    stepDot3.className = dotPending;
                    stepRow4.className = 'flex items-start gap-3.5 opacity-60';
                    stepDot4.className = dotPending;
                }

                function setStep(step) {
                    markStep1Paid();
                    resetSteps();

                    if (step === 1) {
                        statusCard.className = 'bg-gradient-to-br from-[#7C3AED] to-[#5B21B6] rounded-2xl p-5 text-white text-center shadow-lg shadow-[#7C3AED]/20 relative overflow-hidden';
                        statusIcon.className = 'fa-solid fa-mug-hot animate-bounce';
                        statusTitle.textContent = 'Pesanan Sedang Diproses Dapur';
                        statusDesc.textContent = 'Barista dan kru dapur kami sedang meracik pesanan Anda. Estimasi siap dalam 5–10 menit.';

                        stepRow2.className = 'flex items-start gap-3.5';
                        stepDot2.className = dotActive;
                    } else if (step === 2) {
                        statusCard.className = 'bg-gradient-to-br from-blue-600 to-indigo-700 rounded-2xl p-5 text-white text-center shadow-lg shadow-blue-500/20 relative overflow-hidden';
                        statusIcon.className = isTakeaway ? 'fa-solid fa-bullhorn animate-pulse' : 'fa-solid fa-bell-concierge animate-pulse';
                        statusTitle.textContent = isTakeaway ? 'Pesanan Siap! Silakan Ambil di Kasir' : 'Pesanan Siap! Sedang Diantar ke Meja 01';
                        statusDesc.textContent = isTakeaway
                            ? 'Silakan tunjukkan ID ' + orderCode + ' ke kru di counter kasir untuk mengambil pesanan Anda.'
                            : 'Pelayan kami sedang membawa hidangan lezat langsung ke Meja 01 Anda.';

                        stepRow2.className = 'flex items-start gap-3.5';
                        stepDot2.className = dotDone;
                        stepDot2.innerHTML = '<i class="fa-solid fa-check"></i>';
                        stepRow3.className = 'flex items-start gap-3.5';
                        stepDot3.className = 'grid place-items-center h-8 w-8 rounded-full bg-blue-600 text-white font-bold text-xs shrink-0 ring-4 ring-blue-500/20';
                    } else if (step === 3) {
                        statusCard.className = 'bg-gradient-to-br from-emerald-600 to-teal-700 rounded-2xl p-5 text-white text-center shadow-lg shadow-emerald-500/20 relative overflow-hidden';
                        statusIcon.className = 'fa-solid fa-circle-check';
                        statusTitle.textContent = 'Pesanan Telah Selesai Diterima';
                        statusDesc.textContent = 'Terima kasih telah berkunjung ke HQ Coffee & Bites! Selamat menikmati hidangan.';

                        stepRow2.className = 'flex items-start gap-3.5';
                        stepDot2.className = dotDone;
                        stepDot2.innerHTML = '<i class="fa-solid fa-check"></i>';
                        stepRow3.className = 'flex items-start gap-3.5';
                        stepDot3.className = dotDone;
                        stepDot3.innerHTML = '<i class="fa-solid fa-check"></i>';
                        stepRow4.className = 'flex items-start gap-3.5';
                        stepDot4.className = 'grid place-items-center h-8 w-8 rounded-full bg-emerald-600 text-white font-bold text-xs shrink-0 ring-4 ring-emerald-500/20';
                    }
                }

                function applyStatus(payload) {
                    const paid = payload.payment_status === 'lunas';

                    if (paid) {
                        paymentStatusLabel.className = 'font-semibold inline-flex items-center gap-1 text-emerald-600';
                        paymentStatusLabel.innerHTML = '<i class="fa-solid fa-circle-check"></i> ' + (payload.payment_method === 'qris' ? 'QRIS Lunas' : 'Tunai Lunas');
                        markStep1Paid();
                    } else {
                        paymentStatusLabel.className = 'font-semibold inline-flex items-center gap-1 text-amber-600';
                        paymentStatusLabel.innerHTML = '<i class="fa-solid fa-hourglass-half"></i> ' + (payload.payment_method === 'qris' ? 'Menunggu Verifikasi QRIS' : 'Bayar di Kasir');
                    }

                    if (payload.status === 'batal') {
                        statusCard.className = 'bg-gradient-to-br from-rose-600 to-red-700 rounded-2xl p-5 text-white text-center shadow-lg shadow-rose-500/20 relative overflow-hidden';
                        statusIcon.className = 'fa-solid fa-circle-xmark';
                        statusTitle.textContent = 'Pesanan Dibatalkan';
                        statusDesc.textContent = 'Pesanan ini telah dibatalkan oleh kasir. Silakan hubungi kasir untuk informasi lebih lanjut.';
                        resetSteps();
                    } else if (payload.status === 'selesai') {
                        setStep(3);
                    } else if (payload.status === 'siap') {
                        setStep(2);
                    } else if (payload.status === 'dapur') {
                        setStep(1);
                    } else if (payload.status === 'verifikasi' && !paid) {
                        showWaitingPayment();
                    } else {
                        setStep(1);
                    }

                    lastStatus = payload.status + '|' + payload.payment_status;
                    liveStatusNote.textContent = 'Terakhir dicek ' + new Date().toLocaleTimeString('id-ID', { hour: '2-digit', minute: '2-digit', second: '2-digit' }) + ' WIB.';
                }

                async function refreshStatus() {
                    try {
                        const response = await fetch(statusUrl, { headers: { 'Accept': 'application/json' } });
                        if (!response.ok) return;
                        const payload = await response.json();
                        const signature = payload.status + '|' + payload.payment_status;
                        if (signature !== lastStatus) {
                            applyStatus(payload);
                        }
                    } catch (error) {
                        // silently retry on next tick
                    }
                }

                applyStatus({
                    status: @json($order->status),
                    payment_status: @json($order->payment_status),
                    payment_method: @json($order->payment_method),
                });

                setInterval(refreshStatus, 4000);

                document.getElementById('btn-call-help').addEventListener('click', function () {
                    this.textContent = 'Memanggil...';
                    setTimeout(() => {
                        this.textContent = 'Kru Sedang Menuju ke Meja';
                        setTimeout(() => {
                            this.innerHTML = '<i class="fa-solid fa-bell mr-1"></i> Bantuan ' + (isTakeaway ? 'Kasir' : 'Pelayan');
                        }, 2500);
                    }, 1000);
                });
            });
        </script>
    </body>
</html>
