<?php

namespace Database\Factories;

use App\Models\WorkOrder;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class WorkOrderFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = WorkOrder::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'recipe_id' => 1,
            'lot_no' => $this->faker->ean8,
            'amount' => $this->faker->randomNumber(),
            'datetime' => now() + $this->faker->numberBetween(0,10),
            'code' => $this->faker->randomNumber(),
            'queue' => $this->faker->randomNumber(),
            'is_active' => $this->faker->boolean(),
            'is_completed' => $this->faker->boolean(),
            'in_progress' => $this->faker->boolean(),
            'note' => 'test note of workorder',
        ];
    }
}
