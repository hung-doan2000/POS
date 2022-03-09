<?php

namespace Database\Seeders;

use App\Models\Customer;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class CustomerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('customers')->truncate();
        Customer::create([
            'name' => 'Duc',
            'phone' => '0338828456',
            'email' => 'duc@sample.com',
            'password' => Hash::make('duc-password'),
            'created_at' => new \dateTime,
            'updated_at' => new \dateTime,
            'group_id' => '1',
        ]);
        Customer::create(
            [
                'name' => 'Nam',
                'phone' => '0123432543',
                'email' => 'nam@sample.com',
                'password' => Hash::make('nam-password'),
                'created_at' => new \dateTime,
                'updated_at' => new \dateTime,
                'group_id' => '1',
            ]
        );


    }
}
