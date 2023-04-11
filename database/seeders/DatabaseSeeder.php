<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Adding an admin user
        $user = \App\Models\User::factory()
            ->count(1)
            ->create([
                'email' => 'admin@admin.com',
                'password' => \Hash::make('admin'),
            ]);
        $this->call(PermissionsSeeder::class);

        $this->call(BranchSeeder::class);
        $this->call(BrandSeeder::class);
        $this->call(BuyerSeeder::class);
        $this->call(DueSeeder::class);
        $this->call(ProductSeeder::class);
        $this->call(ProductCategorySeeder::class);
        $this->call(ProductCodeSeeder::class);
        $this->call(SaleSeeder::class);
        $this->call(SellerSeeder::class);
        $this->call(ShopSeeder::class);
        $this->call(SupplierSeeder::class);
        $this->call(SupplierReturnSeeder::class);
        $this->call(UserSeeder::class);
    }
}
