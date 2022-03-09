<?php

namespace Database\Factories;

use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProductFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Product::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->text(10),
            'price'=> $this->faker->numberBetween(50, 100),
            'import_price'=> $this->faker->numberBetween(10, 50),
            'product_code'=> $this->faker->text(8),
            'description' => $this->faker->text(10),
            'created_by'=>$this->faker->numberBetween(1, 3),
            'category_id'=>$this->faker->numberBetween(1, 5),
            'brand_id'=>$this->faker->numberBetween(1, 5),
            'active'=>'1',
        ];
    }
}
