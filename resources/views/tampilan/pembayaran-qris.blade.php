<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Pembayaran QRIS - HQ Coffee &amp; Bites</title>
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <script>document.documentElement.classList.add('js');</script>

        @fonts
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
        @vite(['resources/css/app.css', 'resources/js/app.js'])

        <style>
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

            .hq-modal {
                position: fixed;
                inset: 0;
                z-index: 70;
                display: grid;
                place-items: center;
                background: rgba(17, 24, 39, 0.55);
                padding: 1rem;
                opacity: 0;
                pointer-events: none;
                transition: opacity 0.2s ease;
            }

            .hq-modal.is-open {
                opacity: 1;
                pointer-events: auto;
            }
        </style>
    </head>

    @php
        $orderType = $order->order_type;
        $isTakeaway = $order->isTakeaway();
        $totalFormatted = number_format($order->total, 0, ',', '.');
        $cleanAmount = (string) $order->total;
        $itemCount = $order->items->sum('qty');
        $orderCode = $order->code;
    @endphp

    <body class="bg-indigo-50/20 flex justify-center items-center min-h-screen p-4">

        <div class="w-full max-w-md bg-white rounded-3xl p-5 shadow-xl border border-gray-100 space-y-4">

            <div class="flex items-center justify-between pb-3 border-b border-gray-100">
                <div class="flex items-center space-x-3">
                    <div class="w-8 h-8 bg-indigo-100 rounded-xl flex items-center justify-center text-indigo-600 font-bold text-xs">HQ</div>
                    <div>
                        <span class="font-bold text-sm text-gray-800 block">HQ Coffee &amp; Bites</span>
                        <span class="text-[11px] text-gray-400 font-medium">{{ $isTakeaway ? 'Pesanan Bawa Pulang' : 'Self-Order • Meja 01' }}</span>
                    </div>
                </div>
                <a href="{{ route('pemesanan') }}" class="text-xs font-semibold text-[#7C3AED] hover:underline inline-flex items-center gap-1">
                    <i class="fa-solid fa-arrow-left text-[10px]"></i> Kembali
                </a>
            </div>

            <div class="bg-indigo-50/60 p-4 rounded-2xl flex justify-between items-center">
                <div class="flex items-center space-x-3">
                    <div class="p-2.5 bg-indigo-100 text-indigo-600 rounded-xl">
                        <i class="fa-solid {{ $isTakeaway ? 'fa-bag-shopping' : 'fa-utensils' }} text-sm"></i>
                    </div>
                    <div>
                        <h3 class="font-bold text-gray-800 text-xs">{{ $isTakeaway ? 'Bawa Pulang (Takeaway)' : 'Makan di Tempat (Dine-in)' }}</h3>
                        <p class="text-[10px] text-gray-400">{{ $itemCount }} Item • {{ $isTakeaway ? 'Counter Pick-up' : 'Meja 01' }} • #{{ $orderCode }}</p>
                    </div>
                </div>
                <div class="text-right">
                    <span class="text-lg font-black text-indigo-600 block">Rp {{ $totalFormatted }}</span>
                    <span class="text-[9px] text-gray-400">TERMASUK PB1 10%</span>
                </div>
            </div>

            <div class="bg-amber-50/40 border border-amber-100/60 rounded-2xl p-5 text-center space-y-3">
                <div class="flex justify-between items-center px-2">
                    <span class="bg-red-600 text-white font-bold text-[9px] px-2 py-0.5 rounded">QRIS</span>
                    <span class="text-[10px] font-bold text-gray-400 tracking-wider">STANDAR PEMBAYARAN NASIONAL</span>
                    <span class="bg-gray-200 text-gray-600 font-bold text-[9px] px-1.5 py-0.5 rounded">GPN</span>
                </div>

                <div id="countdown-pill" class="inline-flex items-center space-x-1.5 bg-amber-100/80 text-amber-800 px-3 py-1 rounded-full text-xs font-semibold">
                    <i class="fa-regular fa-clock"></i>
                    <span>Kedaluwarsa dalam: <strong id="countdown-value" class="font-bold">14 : 31</strong></span>
                </div>

                <button id="btn-zoom-qr" type="button" aria-label="Perbesar kode QR" class="block bg-white p-4 rounded-2xl mx-auto shadow-sm border border-gray-100 cursor-zoom-in">
                    <img src="https://api.qrserver.com/v1/create-qr-code/?size=180x180&amp;data=HQCoffee{{ $cleanAmount }}" class="w-44 h-44 mx-auto" alt="Kode QRIS">
                </button>

                <div>
                    <h4 class="font-bold text-gray-800 text-sm">HQ Coffee &amp; Bites</h4>
                    <p class="text-[10px] text-gray-400 font-mono tracking-wider mt-0.5">NMID : ID10209384756201</p>
                    <span class="text-[10px] text-gray-400 flex items-center justify-center mt-2">
                        <i class="fa-solid fa-magnifying-glass text-[9px] mr-1"></i> Ketuk QR untuk memperbesar layar
                    </span>
                </div>
            </div>

            <div class="bg-indigo-50/40 rounded-2xl p-4 text-xs space-y-2">
                <div class="flex items-center space-x-1.5 font-bold text-gray-800">
                    <i class="fa-regular fa-circle-question text-indigo-600"></i>
                    <span>Petunjuk Pembayaran</span>
                </div>
                <ol class="space-y-1.5 text-[11px] text-gray-600 pl-1">
                    <li class="flex items-start">
                        <span class="bg-indigo-100 text-indigo-600 font-bold w-4 h-4 rounded-full flex items-center justify-center text-[9px] mr-2 flex-shrink-0 mt-0.5">1</span>
                        <span>Buka aplikasi <strong>GoPay, ShopeePay, BCA, Mandiri, OVO</strong>, atau m-banking apa saja.</span>
                    </li>
                    <li class="flex items-start">
                        <span class="bg-indigo-100 text-indigo-600 font-bold w-4 h-4 rounded-full flex items-center justify-center text-[9px] mr-2 flex-shrink-0 mt-0.5">2</span>
                        <span>Pindai (scan) kode QRIS di atas dan pastikan nominal tepat <strong class="text-indigo-600">Rp {{ $totalFormatted }}</strong> atas nama <strong>HQ Coffee &amp; Bites</strong>.</span>
                    </li>
                    <li class="flex items-start">
                        <span class="bg-indigo-100 text-indigo-600 font-bold w-4 h-4 rounded-full flex items-center justify-center text-[9px] mr-2 flex-shrink-0 mt-0.5">3</span>
                        <span>Masukkan PIN dompet digital Anda dan ketuk tombol konfirmasi di bawah jika pembayaran berhasil.</span>
                    </li>
                </ol>
            </div>

            <button id="btn-sudah-bayar" type="button" class="w-full bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-3.5 rounded-2xl text-xs transition shadow-md flex justify-center items-center">
                <i class="fa-solid fa-circle-check mr-2"></i> Saya Sudah Bayar
            </button>

            <button id="btn-bantuan" type="button" class="text-[11px] text-gray-400 text-center block w-full hover:underline">
                <i class="fa-solid fa-headset mr-1"></i> Bantuan Kasir
            </button>

        </div>

        <div id="qr-modal" class="hq-modal" role="dialog" aria-modal="true" aria-label="Kode QRIS diperbesar">
            <div class="bg-white rounded-3xl p-6 text-center space-y-3 max-w-sm w-full">
                <span class="bg-red-600 text-white font-bold text-[10px] px-2 py-0.5 rounded">QRIS</span>
                <img src="https://api.qrserver.com/v1/create-qr-code/?size=320x320&amp;data=HQCoffee{{ $cleanAmount }}" class="w-72 h-72 mx-auto rounded-xl" alt="Kode QRIS diperbesar">
                <p class="text-xs font-bold text-gray-800">HQ Coffee &amp; Bites • Rp {{ $totalFormatted }}</p>
                <p class="text-[10px] text-gray-400">Ketuk di luar kotak untuk menutup</p>
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

                const countdownValue = document.getElementById('countdown-value');
                const countdownPill = document.getElementById('countdown-pill');
                const btnBayar = document.getElementById('btn-sudah-bayar');
                let sisa = 14 * 60 + 31;

                const interval = setInterval(function () {
                    if (sisa <= 0) {
                        clearInterval(interval);
                        countdownPill.classList.remove('bg-amber-100/80', 'text-amber-800');
                        countdownPill.classList.add('bg-red-100', 'text-red-700');
                        countdownPill.innerHTML = '<i class="fa-solid fa-triangle-exclamation"></i><span>Kode QRIS kedaluwarsa, minta kode baru ke kasir</span>';
                        btnBayar.disabled = true;
                        btnBayar.classList.add('bg-gray-300', 'cursor-not-allowed');
                        btnBayar.classList.remove('bg-indigo-600', 'hover:bg-indigo-700');
                        return;
                    }
                    sisa--;
                    const menit = String(Math.floor(sisa / 60)).padStart(2, '0');
                    const detik = String(sisa % 60).padStart(2, '0');
                    countdownValue.textContent = menit + ' : ' + detik;
                }, 1000);

                const modal = document.getElementById('qr-modal');

                function setModal(buka) {
                    modal.classList.toggle('is-open', buka);
                }

                document.getElementById('btn-zoom-qr').addEventListener('click', () => setModal(true));
                modal.addEventListener('click', (e) => { if (e.target === modal) setModal(false); });
                document.addEventListener('keydown', (e) => { if (e.key === 'Escape') setModal(false); });

                btnBayar.addEventListener('click', async function () {
                    if (this.disabled) return;
                    this.disabled = true;
                    this.innerHTML = '<i class="fa-solid fa-spinner fa-spin mr-2"></i> Memverifikasi Pembayaran...';

                    try {
                        const response = await fetch('{{ route('orders.pay', $order) }}', {
                            method: 'POST',
                            headers: {
                                'Accept': 'application/json',
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                            },
                        });

                        if (!response.ok) {
                            throw new Error('Gagal menyimpan pembayaran.');
                        }

                        toast('Pembayaran QRIS Berhasil! Menunggu verifikasi kasir.');
                        setTimeout(() => {
                            window.location.href = '{{ route('status-pesanan', ['order' => $order->code]) }}';
                        }, 900);
                    } catch (error) {
                        this.disabled = false;
                        this.innerHTML = '<i class="fa-solid fa-circle-check mr-2"></i> Saya Sudah Bayar';
                        toast('Gagal menyimpan pembayaran. Silakan coba lagi.');
                    }
                });

                document.getElementById('btn-bantuan').addEventListener('click', function () {
                    toast('Menghubungi kasir... mohon tunggu');
                });
            });
        </script>

    </body>
</html>
