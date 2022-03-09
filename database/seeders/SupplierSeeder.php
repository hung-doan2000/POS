<?php

namespace Database\Seeders;

use App\Models\Supplier;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SupplierSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('suppliers')->truncate();
        Supplier::create([
            'name' => 'SP1',
            'address' => 'Ha Noi',
            'phone' => '0123456789',
            'email' => 'sp1@sample.com',
            'created_at' => new \dateTime,
            'updated_at' => new \dateTime,
        ]);
        Supplier::create([
            'name' => 'SP2',
            'address' => 'Ha Noi',
            'phone' => '0123451234',
            'email' => 'sp2@sample.com',
            'created_at' => new \dateTime,
            'updated_at' => new \dateTime,
        ]);
        Supplier::create([
            'name' => 'SP3',
            'address' => 'Ha Noi',
            'phone' => '0123456123',
            'email' => 'sp3@sample.com',
            'created_at' => new \dateTime,
            'updated_at' => new \dateTime,
        ]);
    }
}
