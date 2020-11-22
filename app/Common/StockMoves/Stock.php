<?php

namespace App\Common\StockMoves;

use App\Common\Factories\Instantiator;
use App\Models\StockMove;

class Stock 
{
    private $productId;
    private $type;
    private $direction;
    private $amount;
    private $unitId;
    private $datetime;

    private $stockableType;
    private $stockableId;



     /**
     *  Gets a workorder/workorder_id as parameter, creates a new stockmove in positive way(gross)
     */
    public function productionGross($workOrder, $amount, $unitId, $datetime = null)
    {
        if($amount <= 0) return;
        $this->instantiate($workOrder);
        $this->prepare($workOrder->product_id, $amount, $unitId, true, 'production_gross', $datetime)->persist($workOrder);
    }

    /**
     *  Gets a workorder/workorder_id as parameter, creates a new stockmove in negative way(waste)
     */
    public function productionWaste($workOrder, $amount, $unitId, $datetime = null)
    {
        if($amount <= 0) return;
        $this->instantiate($workOrder);
        $this->prepare($workOrder->product_id, $amount, $unitId, false, 'production_waste', $datetime)->persist($workOrder);
    }

    public function decreasedIngredient($workOrder, $ingredientId, $amount, $unitId, $datetime = null)
    {
        $this->instantiate($workOrder);
        $this->prepare($ingredientId, $amount, $unitId, false, 'production_ingredient', $datetime)->persist($workOrder);
    }

    /**
     * Create a positive move manually
     */
    public function moveIn($productId, $amount, $unitId, $datetime)
    {
        $this->prepare($productId, $amount, $unitId, true, 'manual', $datetime)->persist();
    }

    /**
     * Create a negative move manually
     */
    public function moveOut($productId, $amount, $unitId, $datetime)
    {
        $this->prepare($productId, $amount, $unitId, false, 'manual', $datetime)->persist();
    }
    
    /**
     * Make a move
     */
    public function newMove($productId, $amount, $unitId, $direction, $datetime, $type = 'manual', $stockableType = null, $stockableId = null)
    {
        $this->prepare($productId, $amount, $unitId, $direction, $type, $datetime, $stockableType, $stockableId)->persist();
    }


    /**
     * Prepare properties to push database
     */
    private function prepare($productId, $amount, $unitId, $direction, $type, $datetime = null, $stockableType = null, $stockableId = null)
    {
        $this->productId = $productId;
        $this->type = $type;
        $this->direction = $direction;
        $this->amount = $amount;
        $this->unitId = $unitId;
        if($datetime)
            $this->datetime = $datetime;
        else $this->datetime = now();

        $this->stockableType = $stockableType;
        $this->stockableId = $stockableId;
        
        return $this;
    }

    /**
     * The data that will be pushed
     */
    private function data()
    {
       return  [
            'product_id' => $this->productId,
            'type' => $this->type,
            'direction' => $this->direction,
            'amount' => $this->amount,
            'unit_id' => $this->unitId,
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