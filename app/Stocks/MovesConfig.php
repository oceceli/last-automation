<?php

namespace App\Stocks;

use App\Models\WorkOrder;
use DateTime;

class MovesConfig
{   
    
    private $type;
    private $lotNumber;
    private $direction;
    private $amount;
    private $datetime;

    private $stockableType;
    private $stockableId;

    private $workOrder;

    private $productId;


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
    public function setDatetime(DateTime $datetime)
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
     * Get the value of workOrder
     */ 
    public function getWorkOrder()
    {
        return $this->workOrder;
    }

    /**
     * Set the value of workOrder
     *
     * @return  self
     */ 
    public function setWorkOrder(WorkOrder $workOrder)
    {
        $this->workOrder = $workOrder;

        return $this;
    }
}