<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

#[Fillable([
    'code',
    'table_number',
    'order_type',
    'payment_method',
    'payment_status',
    'status',
    'customer_name',
    'note',
    'subtotal',
    'tax',
    'discount',
    'total',
    'paid_at',
])]
class Order extends Model
{
    use HasFactory;

    protected function casts(): array
    {
        return [
            'paid_at' => 'datetime',
            'subtotal' => 'integer',
            'tax' => 'integer',
            'discount' => 'integer',
            'total' => 'integer',
        ];
    }

    public function items(): HasMany
    {
        return $this->hasMany(OrderItem::class);
    }

    public function getRouteKeyName(): string
    {
        return 'code';
    }

    public function isTakeaway(): bool
    {
        return $this->order_type === 'takeaway';
    }

    public static function generateCode(string $orderType): string
    {
        $prefix = $orderType === 'takeaway' ? 'TK' : 'ORD';

        do {
            $code = $prefix.'-'.str_pad((string) random_int(1, 9999), 4, '0', STR_PAD_LEFT);
        } while (self::query()->where('code', $code)->exists());

        return $code;
    }
}
