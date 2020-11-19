<?php

namespace App\Common\StockMoves;

use App\Common\Factories\Instantiator;
use App\Models\StockMove;

class Stock 
{
    private $productId;
    private $direction;
    private $amount;
    private $datetime;

    private $stockableType;
    private $stockableId;



     /**
     *  Gets a workorder/workorder_id as parameter, creates a new stockmove in positive way(gross)
     */
    public function productionGross($workOrder, $amount, $datetime = null)
    {
        $this->instantiate($workOrder);
        $this->prepare($workOrder->product_id, $amount, true, $datetime)->persist($workOrder);
    }

    /**
     *  Gets a workorder/workorder_id as parameter, creates a new stockmove in negative way(waste)
     */
    public function productionWaste($workOrder, $amount, $datetime = null)
    {
        $this->instantiate($workOrder);
        $this->prepare($workOrder->product_id, $amount, false, $datetime)->persist($workOrder);
    }

    public function decreasedIngredient($workOrder, $ingredientId, $amount, $datetime = null)
    {
        $this->instantiate($workOrder);
        $this->prepare($ingredientId, $amount, false, $datetime)->persist($workOrder);
    }

    /**
     * Create a positive move manually
     */
    public function moveIn($productId, $amount, $datetime, $stockableType = 'manual')
    {
        $this->prepare($productId, $amount, true, $datetime, $stockableType)->persist();
    }

    /**
     * Create a negative move manually
     */
    public function moveOut($productId, $amount, $datetime, $stockableType = 'manual')
    {
        $this->prepare($productId, $amount, false, $datetime, $stockableType)->persist();
    }
    
    /**
     * Create a move manually
     */
    public function newMove($productId, $amount, $direction, $datetime, $stockableType = 'manual')
    {
        $this->prepare($productId, $amount, $direction, $datetime, $stockableType)->persist();
    }


    /**
     * Prepare properties to be persisted
     */
    private function prepare($productId, $amount, $direction, $datetime = null, $stockableType = null, $stockableId = null)
    {
        $this->productId = $productId;
        $this->direction = $direction;
        $this->amount = $amount;
        if($datetime)
            $this->datetime = $datetime;
        else $this->datetime = now();

        $this->stockableType = $stockableType;
        $this->stockableId = $stockableId;
        
        return $this;
    }

    /**
     * The data that will be persisted
     */
    private function data()
    {
       return  [
            'product_id' => $this->productId,
            'direction' => $this->direction,
            'amount' => $this->amount,
            'datetime' => $this->datetime,
        ];
    }

    /**
     * Persist to database
     * @param mixed|null $related the initiated model that has to many stockmove relation 
     */
    private function persist($related = null)
    {
        if($related) {
            $related->stockMoves()->create($this->data());
        } else {
            StockMove::create(array_merge($this->data(), [
                'stockable_type' => $this->stockableType,
                'stockable_id' => $this->stockableId,
            ]));
        }
    }

    private function instantiate(&$workOrder)
    {
        if( ! $workOrder instanceof \App\Models\WorkOrder && is_numeric($workOrder))
            $workOrder = Instantiator::make('workOrder', $workOrder);
    }

    

   


    

}