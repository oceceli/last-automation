<?php

namespace App\Stocks;

use App\Models\WorkOrder;
use DateTime;

class ProductionIngredientMove extends Moves
{

    public function __construct(WorkOrder $workOrder, int $ingredientId, String $lotNumber, float $amount)
    {
        $this->instance = $workOrder;

        $this->type = 'production_ingredient';
        $this->direction = false;
        
        $this->productId = $ingredientId;
        $this->lotNumber = $lotNumber;
        $this->amount = $amount;
        $this->datetime = now();
    }

}