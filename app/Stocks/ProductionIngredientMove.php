<?php

namespace App\Stocks;

use App\Models\Interfaces\CanReserveStocks;
use App\Models\WorkOrder;
use DateTime;

class ProductionIngredientMove extends Moves
{

    public function __construct(CanReserveStocks $workOrder, int $ingredientId, String $lotNumber, float $amount)
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