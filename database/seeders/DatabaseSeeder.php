<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(UserSeeder::class);
        $this->call(StoreSeeder::class);
        $this->call(SaleSeeder::class);
        $this->call(SuplierSeeder::class);
        $this->call(WarehouseSeeder::class);
        $this->call(CustomerSeeder::class);
        $this->call(CustomerGroupSeeder::class);
        $this->call(ProductSeeder::class);
        $this->call(CategorySeeder::class);
        $this->call(BrandSeeder::class);
    }
}
