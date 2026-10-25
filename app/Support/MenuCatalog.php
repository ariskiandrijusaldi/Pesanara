<?php

namespace App\Support;

class MenuCatalog
{
    /**
     * @return array<string, int>
     */
    public static function prices(): array
    {
        return [
            'Kopi Susu Aren HQ' => 22000,
            'Sea Salt Latte' => 28000,
            'Thai Green Tea' => 24000,
            'Cinnamon Roll Homemade' => 22000,
            'Rice Bowl Ayam Teriyaki' => 35000,
            'Chicken Wrap Tortilla' => 28000,
            'French Fries Truffle' => 25000,
            'Croissant Butter' => 24000,
        ];
    }

    public static function priceFor(string $name): ?int
    {
        return self::prices()[trim($name)] ?? null;
    }
}
