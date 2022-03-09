<?php

namespace Database\Seeders;

use App\Models\Store;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class StoreSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('stores')->truncate();
        Store::create([
            'name' => 'CH1',
            'address' => 'Ha Noi',
            'phone' => '1234567',
            'created_at' => new \dateTime,
            'updated_at' => new \dateTime,
        ]);
        Store::create([
            'name' => 'CH2',
            'address' => 'HaiDuong',
            'phone' => '1234567',
            'created_at' => new \dateTime,
            'updated_at' => new \dateTime,
        ]);
    }
}
