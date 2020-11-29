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
            'product_id' => $this->faker->numberBetween(1, 30),
            'unit_id' => $this->faker->number,
            'type' => 'manual',
            'direction' => $this->faker->boolean(),
            'amount' => $this->faker->numberBetween(),
            'datetime' => now() + $this->faker->numberBetween(0,10),
        ];
    }
}
