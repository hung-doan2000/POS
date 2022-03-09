<?php

namespace Database\Seeders;

use App\Models\CustomerGroup;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class CustomerGroupSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('customer_groups')->truncate();
        CustomerGroup::create(
            [
                'group_name' => 'Silver',
                'condition' => '0',
                'created_at' => new \dateTime,
                'updated_at' => new \dateTime,
            ]
        );
        CustomerGroup::create(
            [
                'group_name' => 'Gold',
                'condition' => '5000',
                'created_at' => new \dateTime,
                'updated_at' => new \dateTime,
            ]
        );
        CustomerGroup::create(
            [
                'group_name' => 'Diamond',
                'condition' => '10000',
                'created_at' => new \dateTime,
                'updated_at' => new \dateTime,
            ]
        );
    }
}
