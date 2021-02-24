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
    protected $approved = false;

    protected $types = [
        'manual',
        'production_ingredient',
        'production_total',
        'production_waste',
        'dispatch_total',
    ];

    // protected $stockableType; // ?? kullanılmıyorlar şu an, lazım olur mu bilemedim
    // protected $stockableId;

    private $manualEntry = "manual";

    /**
     * Model instance which is App\Models\Interfaces\CanReserveStocks implemented
     */
    protected $instance;


    public function save() 
    {
        if($this->amount <= 0) return;

        // If process is deduction then check if selected lot is in stock
        if($this->direction == false) {
            $lot = StockMove::where(['product_id' => $this->productId, 'lot_number' => strtoupper($this->lotNumber)])->get();
            if($lot->isEmpty()) 
                dd("todo: ".__CLASS__ . ", save fonksiyonu. Bu lot numarasına ait yeterli miktarda kaynak var mı diye sorulacak! muhtemelen vardır yani ama.."); // !! eksik 
        }

        if($this->instance) {
            if(! in_array($this->type, $this->types))
                throw new \Exception('Stok hareketi tipi yanlış!', 422);
                
            $this->instance->stockMoves()->create($this->data());
        }
        else {
            $this->type = $this->manualEntry;
            StockMove::create($this->data());
        }
    }


    public function saveReserveds()
    {
        $reservedStocks = $this->instance->reservedStocks;
        foreach($reservedStocks as $reservation) {
            $this->productId = $reservation->product_id;
            $this->lotNumber = $reservation->reserved_lot;
            $this->amount = $reservation->reserved_amount;

            $this->save();
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
            'approved' => $this->approved,
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
     * Get the value of approved
     */ 
    public function getApproved()
    {
        return $this->approved;
    }

    /**
     * Set the value of approved
     *
     * @return  self
     */ 
    public function setApproved($approved)
    {
        $this->approved = $approved;

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