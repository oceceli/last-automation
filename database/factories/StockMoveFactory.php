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
            'product_id' => $this->faker->numberBetween(1, 10),
            'lot_number' => $this->faker->numberBetween(2101004, 2102005),
            // 'unit_id' => $this->faker->number,
            'type' => 'test',
            'direction' => $this->faker->boolean(),
            'base_amount' => $this->faker->numberBetween(),
            'datetime' => now(),
        ];
    }
}
