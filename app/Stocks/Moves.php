<?php

namespace App\Stocks;

class Moves 
{   

    protected $productId;
    protected $type;
    protected $direction;
    protected $amount;
    protected $lotNumber;
    protected $datetime;

    protected $stockableType;
    protected $stockableId;



    public function __construct()
    {
        //
    }


    protected function data()
    {
        return [
            'product_id' => $this->productId,
            'type' => $this->type,
            'direction' => $this->direction,
            'base_amount' => $this->amount,
            'lot_number' => $this->lotNumber,
            'datetime' => $this->datetime,
        ];
    }


}