<?php

namespace Tests\Feature;

use App\Models\Order;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class OrderFlowTest extends TestCase
{
    use RefreshDatabase;

    private function orderPayload(): array
    {
        return [
            'order_type' => 'dine-in',
            'payment_method' => 'qris',
            'table_number' => '01',
            'note' => 'Tanpa es',
            'items' => [
                ['name' => 'Kopi Susu Aren HQ', 'price' => 22000, 'qty' => 2],
                ['name' => 'Rice Bowl Ayam Teriyaki', 'price' => 35000, 'qty' => 1],
            ],
        ];
    }

    public function test_customer_order_is_stored_and_visible_to_cashier(): void
    {
        $kasir = User::factory()->create(['role' => 'kasir']);

        $response = $this->postJson(route('orders.store'), $this->orderPayload());

        $response->assertCreated();

        $order = Order::query()->with('items')->firstOrFail();

        $this->assertSame(3, $order->items->sum('qty'));
        $this->assertSame(79000, $order->subtotal);
        $this->assertSame(7900, $order->tax);
        $this->assertSame(9900, $order->discount);
        $this->assertSame(77000, $order->total);
        $this->assertSame('verifikasi', $order->status);
        $this->assertSame('pending', $order->payment_status);

        $response->assertJsonPath('redirect', route('pembayaran-qris', ['order' => $order->code]));

        $this->actingAs($kasir)
            ->get(route('kasir-order-monitor'))
            ->assertOk()
            ->assertSee($order->code)
            ->assertSee('Kopi Susu Aren HQ')
            ->assertSee('Rp 77.000');

        $this->actingAs($kasir)
            ->getJson(route('kasir-order-monitor.feed'))
            ->assertOk()
            ->assertJsonPath('counts.verifikasi', 1)
            ->assertJsonPath('counts.aktif', 1);
    }

    public function test_cashier_can_verify_qris_and_advance_order_status(): void
    {
        $kasir = User::factory()->create(['role' => 'kasir']);
        $this->postJson(route('orders.store'), $this->orderPayload())->assertCreated();

        $order = Order::query()->firstOrFail();

        $this->actingAs($kasir)
            ->patchJson(route('orders.update', $order), ['action' => 'verifikasi'])
            ->assertOk()
            ->assertJsonPath('status', 'dapur')
            ->assertJsonPath('payment_status', 'lunas');

        $this->actingAs($kasir)
            ->patchJson(route('orders.update', $order), ['action' => 'advance'])
            ->assertOk()
            ->assertJsonPath('status', 'siap');

        $this->actingAs($kasir)
            ->patchJson(route('orders.update', $order), ['action' => 'finish'])
            ->assertOk()
            ->assertJsonPath('status', 'selesai');
    }

    public function test_customer_can_open_payment_and_status_pages_for_their_order(): void
    {
        $this->postJson(route('orders.store'), $this->orderPayload())->assertCreated();
        $order = Order::query()->firstOrFail();

        $this->get(route('pembayaran-qris', ['order' => $order->code]))
            ->assertOk()
            ->assertSee('Rp 77.000')
            ->assertSee($order->code);

        $this->postJson(route('orders.pay', $order))
            ->assertOk()
            ->assertJsonPath('payment_status', 'pending');

        $this->get(route('status-pesanan', ['order' => $order->code]))
            ->assertOk()
            ->assertSee($order->code)
            ->assertSee('Kembali ke Beranda HQ Coffee')
            ->assertSee(route('landing'));
    }

    public function test_payment_and_status_pages_do_not_show_default_order_without_order_code(): void
    {
        $this->get(route('pembayaran-qris'))->assertRedirect(route('pemesanan'));
        $this->get(route('status-pesanan'))->assertRedirect(route('pemesanan'));
    }

    public function test_login_page_has_back_to_landing_button(): void
    {
        $this->get(route('login'))
            ->assertOk()
            ->assertSee('Kembali ke Beranda HQ Coffee')
            ->assertSee(route('landing'));
    }
}
