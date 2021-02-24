<?php

namespace App\Stocks;

use App\Models\Interfaces\CanReserveStocks;

class DispatchTotalMove extends Moves
{

    public function __construct(CanReserveStocks $dispatchOrder, $datetime = null)
    {
        $this->instance = $dispatchOrder;

        $this->type = 'dispatch_total';
        $this->direction = false;
        $this->approved = true;

        if($datetime) $this->datetime = $datetime;
        else $this->datetime = now();
    }

}