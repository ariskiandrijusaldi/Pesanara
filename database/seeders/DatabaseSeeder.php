<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::query()->create([
            'name' => 'Owner HQ',
            'email' => 'owner@hqcoffee.com',
            'password' => 'password',
            'role' => 'owner',
        ]);

        User::query()->create([
            'name' => 'Kasir HQ',
            'email' => 'kasir@hqcoffee.com',
            'password' => 'password',
            'role' => 'kasir',
        ]);
    }
}
