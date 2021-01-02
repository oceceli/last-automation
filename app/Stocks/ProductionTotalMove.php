<?php

namespace App\Stocks;

use App\Models\WorkOrder;
use DateTime;

class ProductionTotalMove extends Moves
{
    private $workOrder;

    public function __construct(WorkOrder $workOrder, int $amount)
    {
        $this->workOrder = $workOrder;

        $this->productId = $workOrder->product_id;
        $this->type = 'production_total';
        $this->direction = true;
        $this->lotNumber = $workOrder->lot_no;

        $this->amount = $amount;
        $this->datetime = now();
    }


    public function save()
    {
        $this->workOrder->StockMoves()->create($this->data());
    }

    
}
