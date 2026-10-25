@foreach ($orders as $order)
    @php
        $isTakeaway = $order->isTakeaway();
        $isPaid = $order->payment_status === 'lunas';
        $payStatus = $isPaid ? 'lunas' : ($order->payment_status === 'belum' ? 'belum' : 'pending');
        $total = 'Rp '.number_format($order->total, 0, ',', '.');
        $orderCode = '#'.$order->code;
        $table = $isTakeaway ? $order->code : $order->table_number;
        $customer = $order->customer_name ?: ($isTakeaway ? 'Pelanggan Takeaway' : 'Tamu Meja '.$order->table_number);
        $createdAt = $order->created_at->copy()->timezone('Asia/Jakarta');
        $paidAt = $order->paid_at?->copy()->timezone('Asia/Jakarta');
        $payTime = $paidAt ? $paidAt->format('H:i:s').' WIB' : '-';
        $payMethod = $order->payment_method === 'qris' ? 'QRIS GPN' : 'Bayar di Kasir (Tunai / EDC)';
        $itemCount = $order->items->sum('qty');
        $itemKinds = $order->items->count();
        $rrn = $order->payment_method === 'qris' ? 'RRN-'.$order->id : '-';

        if ($order->status === 'batal') {
            $border = 'border-rose-200';
            $chip = 'DIBATALKAN';
            $chipClass = 'bg-rose-100 text-rose-800';
            $statusHtml = '<i class="fa-solid fa-circle-xmark mr-1"></i> Dibatalkan Kasir';
            $statusClass = 'bg-rose-100 text-rose-700';
        } elseif ($order->status === 'selesai') {
            $border = 'border-emerald-200';
            $chip = 'SELESAI';
            $chipClass = 'bg-emerald-100 text-emerald-800';
            $statusHtml = '<i class="fa-solid fa-check mr-1"></i> Selesai (Telah Diterima)';
            $statusClass = 'bg-emerald-100 text-emerald-800';
        } elseif ($order->status === 'siap') {
            $border = $isTakeaway ? 'border-amber-200/70' : 'border-blue-200/70';
            $chip = $isTakeaway ? 'SIAP DIAMBIL' : 'SIAP DIANTAR';
            $chipClass = $isTakeaway ? 'bg-amber-100 text-amber-800' : 'bg-blue-100 text-blue-800';
            $statusHtml = $isTakeaway
                ? '<i class="fa-solid fa-bullhorn mr-1"></i> Siap di Counter Kasir'
                : '<i class="fa-solid fa-bell-concierge mr-1"></i> Siap Diantar ke Meja';
            $statusClass = $isTakeaway ? 'bg-amber-100 text-amber-800' : 'bg-blue-100 text-blue-800';
        } elseif ($order->status === 'dapur') {
            $border = 'border-gray-100';
            $chip = 'DIPROSES DAPUR';
            $chipClass = 'bg-purple-100 text-purple-800';
            $statusHtml = $isPaid
                ? '<i class="fa-solid fa-check mr-1"></i> Lunas ('.($order->payment_method === 'qris' ? 'QRIS Terverifikasi' : 'Kasir Tunai').')'
                : '<i class="fa-solid fa-hourglass-half mr-1"></i> Menunggu Pembayaran';
            $statusClass = $isPaid ? 'bg-emerald-100 text-emerald-800' : 'bg-amber-100 text-amber-800';
        } elseif ($payStatus === 'belum') {
            $border = 'border-rose-200';
            $chip = 'BELUM BAYAR';
            $chipClass = 'bg-rose-100 text-rose-800';
            $statusHtml = '<i class="fa-solid fa-hand-holding-dollar mr-1"></i> Pilih Bayar di Kasir';
            $statusClass = 'bg-rose-100 text-rose-700';
        } else {
            $border = 'border-amber-200';
            $chip = 'PESANAN BARU';
            $chipClass = 'bg-amber-100 text-amber-800';
            $statusHtml = '<i class="fa-solid fa-receipt mr-1"></i> Menunggu Verifikasi QRIS';
            $statusClass = 'bg-amber-100 text-amber-800';
        }
    @endphp

    <div class="order-card bg-white rounded-2xl p-4 border {{ $border }} shadow-sm space-y-3 cursor-pointer"
        data-type="{{ $order->order_type }}"
        data-status="{{ $order->status }}"
        data-floor="{{ $isTakeaway ? 'semua' : '1' }}"
        data-meja="{{ $table }}"
        data-order="{{ $orderCode }}"
        data-pemesan="{{ $customer }}"
        data-total="{{ $total }}"
        data-pay-status="{{ $payStatus }}"
        data-pay-time="{{ $payTime }}"
        data-pay-method="{{ $payMethod }}"
        data-rrn="{{ $rrn }}">

        <div class="flex flex-wrap justify-between items-start gap-2">
            <div class="flex items-center space-x-3">
                <span class="card-meja font-bold px-3 py-1 rounded-xl text-xs {{ $isTakeaway ? 'bg-amber-100 text-amber-800 flex items-center gap-1' : ($payStatus === 'belum' ? 'bg-rose-100 text-rose-700' : 'bg-indigo-100 text-indigo-700') }}">
                    @if ($isTakeaway)
                        <i class="fa-solid fa-bag-shopping"></i> TAKEAWAY {{ $order->code }}
                    @else
                        MEJA {{ $order->table_number }}
                    @endif
                </span>
                <div>
                    <div class="flex items-center gap-1.5">
                        <span class="card-order font-bold text-gray-900">{{ $orderCode }}</span>
                        <span class="{{ $isTakeaway ? 'bg-amber-100 text-amber-800' : 'bg-indigo-50 text-indigo-700' }} text-[9px] font-bold px-2 py-0.5 rounded-full">
                            <i class="fa-solid {{ $isTakeaway ? 'fa-bag-shopping' : 'fa-utensils' }} mr-1"></i>{{ $isTakeaway ? 'Takeaway' : 'Dine-in' }}
                        </span>
                        <span class="card-chip {{ $chipClass }} font-bold text-[9px] px-2 py-0.5 rounded-full">{{ $chip }}</span>
                    </div>
                    <p class="text-[10px] text-gray-400 mt-0.5">{{ $createdAt->locale('id')->diffForHumans() }} • {{ $createdAt->format('H:i') }} WIB • Pemesan: {{ $customer }}</p>
                </div>
            </div>
            <span class="card-status {{ $statusClass }} text-[10px] font-bold px-2.5 py-1 rounded-lg">{!! $statusHtml !!}</span>
        </div>

        <div class="space-y-2 border-t border-b border-gray-50 py-3">
            @foreach ($order->items as $item)
                <div class="flex justify-between gap-3 font-medium">
                    <span>
                        {{ $item->qty }}x {{ $item->name }}
                        @if ($item->note)
                            <span class="block text-[10px] text-gray-400 font-normal">Catatan: {{ $item->note }}</span>
                        @endif
                    </span>
                    <span class="font-bold text-gray-800 shrink-0">Rp {{ number_format($item->line_total, 0, ',', '.') }}</span>
                </div>
            @endforeach
            @if ($order->note)
                <p class="rounded-lg bg-amber-50 px-2.5 py-1.5 text-[10px] text-amber-800"><strong>Catatan pesanan:</strong> {{ $order->note }}</p>
            @endif
        </div>

        @if ($order->payment_method === 'qris')
            <div class="bg-indigo-50/50 p-2.5 rounded-xl flex flex-wrap justify-between items-center gap-2">
                <span class="text-indigo-700 font-semibold text-[11px]"><i class="fa-solid fa-receipt mr-1"></i> Bukti Bayar QRIS: <strong>{{ $total }}</strong></span>
                <button type="button" class="btn-cek-bukti bg-white border border-indigo-200 text-indigo-600 font-bold px-3 py-1 rounded-lg hover:bg-indigo-50"><i class="fa-solid fa-eye mr-1"></i> Cek Bukti QRIS</button>
            </div>
        @else
            <div class="bg-rose-50/60 p-2.5 rounded-xl flex flex-wrap justify-between items-center gap-2">
                <span class="text-rose-700 font-semibold text-[11px]"><i class="fa-solid fa-cash-register mr-1"></i> Metode: Bayar di Kasir</span>
                <span class="text-rose-600 font-bold text-[11px]">{{ $isPaid ? 'Sudah Dibayar' : 'Belum Dibayar' }}</span>
            </div>
        @endif

        <div class="flex flex-wrap justify-between items-center gap-2 pt-1">
            <span class="font-bold text-sm">Total: <strong class="text-indigo-600 text-base">{{ $total }}</strong> <span class="text-gray-400 font-normal text-xs">({{ $itemKinds }} Menu / {{ $itemCount }} Item)</span></span>
            <div class="card-action flex flex-wrap items-center gap-2">
                @if ($order->status === 'verifikasi' && $payStatus === 'pending')
                    <button type="button" data-action="cancel" class="btn-tolak border border-rose-200 text-rose-600 font-bold px-3 py-1.5 rounded-xl hover:bg-rose-50 text-xs">
                        <i class="fa-regular fa-circle-xmark mr-1"></i> Tolak / Batal
                    </button>
                    <button type="button" class="btn-cetak bg-gray-100 text-gray-700 font-bold px-3 py-1.5 rounded-xl hover:bg-gray-200 text-xs">
                        <i class="fa-solid fa-print mr-1"></i> Cetak Struk
                    </button>
                    <button type="button" data-action="verifikasi" class="btn-verif-qris bg-emerald-600 text-white font-bold px-4 py-1.5 rounded-xl hover:bg-emerald-700 text-xs shadow-sm shadow-emerald-200 transition flex items-center gap-1.5">
                        <i class="fa-solid fa-circle-check"></i> Verifikasi &amp; Kirim ke Dapur
                    </button>
                @elseif ($order->status === 'verifikasi' && $payStatus === 'belum')
                    <button type="button" data-action="cancel" class="btn-tolak border border-rose-200 text-rose-600 font-bold px-3 py-1.5 rounded-xl hover:bg-rose-50 text-xs">
                        <i class="fa-regular fa-circle-xmark mr-1"></i> Tolak / Batal
                    </button>
                    <button type="button" data-action="terima" class="btn-terima bg-indigo-600 text-white font-bold px-4 py-1.5 rounded-xl hover:bg-indigo-700 text-xs shadow-sm">
                        <i class="fa-solid fa-cash-register mr-1"></i> Terima Pembayaran Tunai / EDC
                    </button>
                @elseif ($order->status === 'dapur')
                    <button type="button" data-action="advance" class="btn-advance {{ $isTakeaway ? 'bg-amber-600 hover:bg-amber-700' : 'bg-indigo-600 hover:bg-indigo-700' }} text-white font-bold px-4 py-1.5 rounded-xl text-xs transition">
                        @if ($isTakeaway)
                            <i class="fa-solid fa-bullhorn mr-1"></i> Ubah ke: "Siap (Panggil Ambil di Kasir)"
                        @else
                            Ubah ke: "Siap (Mengantar ke Meja)" <i class="fa-solid fa-bell-concierge ml-1"></i>
                        @endif
                    </button>
                @elseif ($order->status === 'siap')
                    @if ($isTakeaway)
                        <button type="button" class="btn-panggil-counter bg-amber-600 text-white font-bold px-3 py-1.5 rounded-xl hover:bg-amber-700">
                            <i class="fa-solid fa-volume-high mr-1"></i> Panggil Kasir
                        </button>
                    @endif
                    <button type="button" data-action="finish" class="btn-finish bg-emerald-500 text-white font-bold px-3 py-1.5 rounded-xl hover:bg-emerald-600">
                        <i class="fa-solid fa-circle-check mr-1"></i> {{ $isTakeaway ? 'Selesai (Diambil)' : "Tandai 'Selesai' (Meja Bersih)" }}
                    </button>
                @endif
            </div>
        </div>
    </div>
@endforeach
