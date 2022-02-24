<?php

namespace Database\Factories;

use App\Models\StockMove;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class StockMoveFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = StockMove::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'product_id' => $this->faker->numberBetween(11, 29), // according to seeder
            'type' => 'manual',
            'lot_number' => $this->faker->numberBetween(2101004, 2102005),
            // 'unit_id' => $this->faker->number,
            'direction' => true,
            'approved' => true,
            'base_amount' => floor(($this->faker->numberBetween(50, 300)) / 5) * 5,
            'datetime' => now(),
        ];
    }
}
