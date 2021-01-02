<?php

namespace App\Stocks;

use App\Models\WorkOrder;
use DateTime;

class ProductionIngredientMove extends Moves
{
    private $workOrder;

    public function __construct(WorkOrder $workOrder, int $ingredientId, String $lotNumber, int $amount)
    {
        $this->workOrder = $workOrder;
        $this->type = 'production_ingredient';
        $this->direction = false;
        
        $this->productId = $ingredientId;
        $this->lotNumber = $lotNumber;
        $this->amount = $amount;
        $this->datetime = now();
    }


    public function save()
    {
        $this->workOrder->StockMoves()->create($this->data());
    }
}