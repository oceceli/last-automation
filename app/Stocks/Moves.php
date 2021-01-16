<?php

namespace App\Stocks;

use App\Models\StockMove;
use App\Models\WorkOrder;

class Moves
{   

    protected $productId;
    protected $type;
    protected $direction;
    protected $amount;
    protected $lotNumber;
    protected $datetime;

    // protected $stockableType; // !! kullanılmıyorlar şu an, lazım olur mu bilemedim
    // protected $stockableId;

    private $manualEntry = "manual";

    /**
     * Model instance which is App\Models\Interfaces\CanReserveStocks implemented
     */
    protected $instance;


    public function save() 
    {
        if( ! $this->direction) {
            $lot = StockMove::where(['product_id' => $this->productId, 'lot_number' => strtoupper($this->lotNumber)])->get();
            if($lot->isEmpty()) 
                dd("todo: ".__CLASS__ . ", save fonksiyonu. Bu lot numarasına ait yeterli miktarda kaynak var mı diye sorulacak! muhtemelen vardır yani ama.."); // !! eksik 
        }

        if($this->amount <= 0) return;

        if($this->instance) {
            $this->instance->stockMoves()->create($this->data());
        }
        else {
            $this->type = $this->manualEntry;
            StockMove::create($this->data());
        }
    }


    /**
     * Ready to push StockMove date
     */
    protected function data()
    {
        return [
            'product_id' => $this->productId,
            'type' => $this->type,
            'direction' => (bool)$this->direction,
            'base_amount' => $this->amount,
            'lot_number' => $this->lotNumber,
            'datetime' => $this->datetime,
        ];
    }

    


    /**
     * Get the value of productId
     */ 
    public function getProductId()
    {
        return $this->productId;
    }

    /**
     * Set the value of productId
     *
     * @return  self
     */ 
    public function setProductId(int $productId)
    {
        $this->productId = $productId;

        return $this;
    }

    /**
     * Get the value of type
     */ 
    public function getType()
    {
        return $this->type;
    }

    /**
     * Set the value of type
     *
     * @return  self
     */ 
    public function setType(String $type)
    {
        $this->type = $type;

        return $this;
    }

    /**
     * Get the value of direction
     */ 
    public function getDirection()
    {
        return $this->direction;
    }

    /**
     * Set the value of direction
     *
     * @return  self
     */ 
    public function setDirection(bool $direction)
    {
        $this->direction = $direction;

        return $this;
    }

    /**
     * Get the value of amount
     */ 
    public function getAmount()
    {
        return $this->amount;
    }

    /**
     * Set the value of amount
     *
     * @return  self
     */ 
    public function setAmount(float $amount)
    {
        $this->amount = $amount;

        return $this;
    }

    /**
     * Get the value of lotNumber
     */ 
    public function getLotNumber()
    {
        return $this->lotNumber;
    }

    /**
     * Set the value of lotNumber
     *
     * @return  self
     */ 
    public function setLotNumber(String $lotNumber)
    {
        $this->lotNumber = $lotNumber;

        return $this;
    }

    /**
     * Get the value of datetime
     */ 
    public function getDatetime()
    {
        return $this->datetime;
    }

    /**
     * Set the value of datetime
     *
     * @return  self
     */ 
    public function setDatetime($datetime)
    {
        $this->datetime = $datetime;

        return $this;
    }

    /**
     * Get the value of stockableType
     */ 
    public function getStockableType()
    {
        return $this->stockableType;
    }

    /**
     * Set the value of stockableType
     *
     * @return  self
     */ 
    public function setStockableType(String $stockableType)
    {
        $this->stockableType = $stockableType;

        return $this;
    }

    /**
     * Get the value of stockableId
     */ 
    public function getStockableId()
    {
        return $this->stockableId;
    }

    /**
     * Set the value of stockableId
     *
     * @return  self
     */ 
    public function setStockableId(int $stockableId)
    {
        $this->stockableId = $stockableId;

        return $this;
    }
}