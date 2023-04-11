<?php

namespace Database\Seeders;

use App\Models\Due;
use Illuminate\Database\Seeder;

class DueSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Due::factory()
            ->count(5)
            ->create();
    }
}
