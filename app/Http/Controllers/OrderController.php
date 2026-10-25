<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Support\MenuCatalog;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class OrderController extends Controller
{
    private const DISCOUNT = 9900;

    public function store(Request $request): JsonResponse
    {
        $data = $request->validate([
            'order_type' => ['required', 'in:dine-in,takeaway'],
            'payment_method' => ['required', 'in:qris,kasir'],
            'table_number' => ['nullable', 'string', 'max:10'],
            'customer_name' => ['nullable', 'string', 'max:80'],
            'note' => ['nullable', 'string', 'max:500'],
            'items' => ['required', 'array', 'min:1'],
            'items.*.name' => ['required', 'string', 'max:120'],
            'items.*.price' => ['required', 'integer', 'min:0'],
            'items.*.qty' => ['required', 'integer', 'min:1', 'max:99'],
            'items.*.note' => ['nullable', 'string', 'max:200'],
        ]);

        $items = collect($data['items'])->map(function (array $item): array {
            $price = MenuCatalog::priceFor($item['name']) ?? (int) $item['price'];
            $qty = (int) $item['qty'];

            return [
                'name' => $item['name'],
                'price' => $price,
                'qty' => $qty,
                'line_total' => $price * $qty,
                'note' => $item['note'] ?? null,
            ];
        });

        $subtotal = (int) $items->sum('line_total');
        $tax = (int) round($subtotal * 0.1);
        $discount = $data['order_type'] === 'dine-in' ? min(self::DISCOUNT, $subtotal) : 0;
        $total = max($subtotal + $tax - $discount, 0);

        $order = DB::transaction(function () use ($data, $items, $subtotal, $tax, $discount, $total) {
            $order = Order::query()->create([
                'code' => Order::generateCode($data['order_type']),
                'table_number' => $data['table_number'] ?? '01',
                'order_type' => $data['order_type'],
                'payment_method' => $data['payment_method'],
                'payment_status' => $data['payment_method'] === 'qris' ? 'pending' : 'belum',
                'status' => 'verifikasi',
                'customer_name' => $data['customer_name'] ?? null,
                'note' => $data['note'] ?? null,
                'subtotal' => $subtotal,
                'tax' => $tax,
                'discount' => $discount,
                'total' => $total,
            ]);

            $order->items()->createMany($items);

            return $order;
        });

        return response()->json([
            'order' => [
                'code' => $order->code,
                'total' => $order->total,
                'total_formatted' => 'Rp '.number_format($order->total, 0, ',', '.'),
            ],
            'redirect' => $data['payment_method'] === 'qris'
                ? route('pembayaran-qris', ['order' => $order->code])
                : route('status-pesanan', ['order' => $order->code]),
        ], 201);
    }

    public function payment(Request $request): View|RedirectResponse
    {
        $order = Order::query()
            ->with('items')
            ->where('code', $request->query('order'))
            ->first();

        if (! $order) {
            return redirect()->route('pemesanan');
        }

        return view('tampilan.pembayaran-qris', compact('order'));
    }

    public function status(Request $request): View|RedirectResponse
    {
        $order = Order::query()
            ->with('items')
            ->where('code', $request->query('order'))
            ->first();

        if (! $order) {
            return redirect()->route('pemesanan');
        }

        return view('tampilan.status-pesanan', compact('order'));
    }

    public function statusFeed(Order $order): JsonResponse
    {
        return response()->json($this->orderPayload($order));
    }

    public function pay(Order $order): JsonResponse
    {
        if ($order->payment_status === 'lunas') {
            return response()->json(['ok' => true, 'status' => $order->status, 'payment_status' => $order->payment_status]);
        }

        if ($order->payment_method !== 'qris') {
            throw ValidationException::withMessages([
                'payment' => 'Pesanan ini dibayar langsung di kasir.',
            ]);
        }

        $order->forceFill([
            'payment_status' => 'pending',
            'paid_at' => now(),
        ])->save();

        return response()->json($this->orderPayload($order));
    }

    public function monitor(): View
    {
        return view('tampilan.kasir-order-monitor', [
            'orders' => $this->ordersForMonitor(),
            'counts' => $this->countsForMonitor(),
        ]);
    }

    public function feed(): JsonResponse
    {
        $orders = $this->ordersForMonitor();

        return response()->json([
            'html' => view('tampilan.partials.order-cards', compact('orders'))->render(),
            'counts' => $this->countsForMonitor(),
            'stamp' => (string) optional($orders->max('updated_at'))->getTimestamp(),
        ]);
    }

    public function update(Request $request, Order $order): JsonResponse
    {
        $data = $request->validate([
            'action' => ['required', 'in:verifikasi,terima,advance,finish,cancel'],
        ]);

        switch ($data['action']) {
            case 'verifikasi':
                $order->fill([
                    'payment_status' => 'lunas',
                    'status' => 'dapur',
                    'paid_at' => $order->paid_at ?? now(),
                ]);
                break;
            case 'terima':
                $order->fill([
                    'payment_status' => 'lunas',
                    'status' => 'dapur',
                    'paid_at' => $order->paid_at ?? now(),
                ]);
                break;
            case 'advance':
                $order->fill(['status' => 'siap']);
                break;
            case 'finish':
                $order->fill(['status' => 'selesai']);
                break;
            case 'cancel':
                $order->fill(['status' => 'batal']);
                break;
        }

        $order->save();

        return response()->json($this->orderPayload($order));
    }

    private function ordersForMonitor()
    {
        return Order::query()
            ->with('items')
            ->latest()
            ->limit(50)
            ->get();
    }

    /**
     * @return array<string, int>
     */
    private function countsForMonitor(): array
    {
        $base = Order::query();

        $verifikasi = (clone $base)->where('status', 'verifikasi')->count();
        $dapur = (clone $base)->where('status', 'dapur')->count();
        $siap = (clone $base)->where('status', 'siap')->count();
        $selesai = (clone $base)->where('status', 'selesai')->whereDate('updated_at', today())->count();

        return [
            'aktif' => $verifikasi + $dapur + $siap,
            'verifikasi' => $verifikasi,
            'dapur' => $dapur,
            'siap' => $siap,
            'selesai' => $selesai,
            'total' => (clone $base)->count(),
        ];
    }

    /**
     * @return array<string, mixed>
     */
    private function orderPayload(Order $order): array
    {
        return [
            'ok' => true,
            'code' => $order->code,
            'status' => $order->status,
            'payment_status' => $order->payment_status,
            'payment_method' => $order->payment_method,
            'updated_at' => $order->updated_at?->toIso8601String(),
        ];
    }
}
