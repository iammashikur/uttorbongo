<?php

namespace Database\Seeders;

use App\Models\SupplierReturn;
use Illuminate\Database\Seeder;

class SupplierReturnSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        SupplierReturn::factory()
            ->count(5)
            ->create();
    }
}
