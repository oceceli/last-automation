<?php

namespace Database\Factories;

use App\Models\Unit;
use Illuminate\Database\Eloquent\Factories\Factory;

class UnitFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Unit::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'product_id' => $this->faker->randomDigit,
            'parent_id' => 1,
            'name' => $this->faker->randomLetter . $this->faker->randomLetter,
            'multiplier' => $this->faker->boolean(),
            'factor' => $this->faker->randomNumber(),
        ];
    }
}
