<?php

namespace Database\Seeders;

use App\Models\ProductCode;
use Illuminate\Database\Seeder;

class ProductCodeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        ProductCode::factory()
            ->count(5)
            ->create();
    }
}
