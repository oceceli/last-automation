<?php

namespace App\Stocks;

use App\Models\WorkOrder;
use DateTime;

class ProductionWasteMove extends Moves
{
    private $workOrder;

    public function __construct(WorkOrder $workOrder, float $amount)
    {
        $this->workOrder = $workOrder;

        $this->productId = $workOrder->product_id;
        $this->type = 'production_waste';
        $this->direction = false;
        $this->lotNumber = $workOrder->lot_no;

        $this->amount = $amount;
        $this->datetime = now();
    }


    public function save()
    {
        if($this->amount > 0)
            $this->workOrder->StockMoves()->create($this->data());
    }

    
}
