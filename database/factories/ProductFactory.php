<?php

namespace Database\Factories;

use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

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
            'category_id' => $this->faker->randomDigit,
            'name' => $this->faker->randomLetter . ' ürünü',
            'code' => $this->faker->ean8,
            'barcode' => $this->faker->ean13,
            'min_threshold' => 50,
            'shelf_life' => 2,
            'note' => "Lorem ipsum dolor sit amet consectetur adipisicing elit. Sequi excepturi aliquam dolor. Error pariatur eum fugit reprehenderit, aut, doloremque voluptatem, iusto officiis esse perferendis quo. Placeat ea dolorum dolores debitis?",
            'is_active' => true,
            'producible' => $this->faker->boolean(),
        ];
    }
}
