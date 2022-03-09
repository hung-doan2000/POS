<?php

namespace Database\Seeders;

use App\Models\Admin\Sale;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SaleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('sales')->truncate();
        Sale::factory()
        ->count(1000)
        ->create();
    }
}
