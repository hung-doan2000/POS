<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('categories')->truncate();
        Category::create([
            'name' => 'Summer Clothes',
            'description' => 'She’s here…Summer 2021!',
            'parent_id' => '0',
            'tax' => '10',
            'unit' => 'chiếc',
            'created_at' => new \dateTime,
            'updated_at' => new \dateTime,
        ]);
        Category::create([
            'name' => 'Winter Clothes',
            'description' => 'Discover the beauty of winter.',
            'parent_id' => '0',
            'tax' => '10',
            'unit' => 'chiếc',
            'created_at' => new \dateTime,
            'updated_at' => new \dateTime,
        ]);
        Category::create([
            'name' => 'Accessories',
            'description' => 'Be the Inspiration',
            'parent_id' => '0',
            'tax' => '10',
            'unit' => 'chiếc',
            'created_at' => new \dateTime,
            'updated_at' => new \dateTime,
        ]);
        Category::create([
            'name' => 'Bag',
            'description' => 'She’s here…Summer 2021!',
            'parent_id' => '3',
            'tax' => '10',
            'unit' => 'Cái',
            'created_at' => new \dateTime,
            'updated_at' => new \dateTime,
        ]);
        Category::create([
            'name' => 'T-Shirt',
            'description' => 'She’s here…Summer 2021!',
            'parent_id' => '1',
            'tax' => '10',
            'unit' => 'Cái',
            'created_at' => new \dateTime,
            'updated_at' => new \dateTime,
        ]);
        Category::create([
            'name' => 'Shoes',
            'description' => 'She’s here…Summer 2021!',
            'parent_id' => '3',
            'tax' => '20',
            'unit' => 'Đôi',
            'created_at' => new \dateTime,
            'updated_at' => new \dateTime,
        ]);
        Category::create([
            'name' => 'Coat',
            'description' => 'She’s here…Summer 2021!',
            'parent_id' => '2',
            'tax' => '15',
            'unit' => 'Cái',
            'created_at' => new \dateTime,
            'updated_at' => new \dateTime,
        ]);
    }
}
