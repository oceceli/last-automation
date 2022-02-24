<?php

namespace Database\Factories;

use App\Models\WorkOrder;
use App\Models\Product;
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
        $product = Product::find(random_int(1, 12)); // according to seeder
        $randomAmount = floor(random_int(5, 250) / 5) * 5;
        $randomWoNumber = random_int(1,500);
        $randomQueue = random_int(1,1000);
        
        return [
            'product_id' => $product->id, 
            'unit_id' => $product->baseUnit->id,
            'wo_lot_no' => $this->faker->ean8,
            'wo_amount' => $randomAmount,
            'wo_datetime' => $this->faker->randomElement([                
                now(),
                $this->faker->dateTimeBetween('+0 days', '+1 year'),
            ]), 
            'wo_code' => $randomWoNumber,
            'wo_queue' => $randomQueue,
            'wo_status' => $this->faker->randomElement([                
                'active',
                'suspended',
            ]),
            'wo_note' => 'Bu ürünün reçetesi için yazılmış özel bir açıklama örneği',
        ];
    }
}
