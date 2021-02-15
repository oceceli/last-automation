<?php

namespace App\Stocks;

use App\Models\Interfaces\CanReserveStocks;
use App\Models\WorkOrder;
use DateTime;

class ProductionTotalMove extends Moves
{

    public function __construct(CanReserveStocks $workOrder, float $amount)
    {
        $this->instance = $workOrder;

        $this->productId = $workOrder->product_id;
        $this->type = 'production_total';
        $this->direction = true;
        $this->lotNumber = $workOrder->wo_lot_no;

        $this->amount = $amount;
        $this->datetime = now();
    }

    
}
