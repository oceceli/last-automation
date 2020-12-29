<?php

namespace App\Common\StockMoves;

use App\Common\Factories\Instantiator;
use App\Models\StockMove;

class Moves 
{
    private $productId;
    private $type;
    private $direction;
    private $baseAmount;
    private $lotNumber;
    private $datetime;

    private $stockableType;
    private $stockableId;



     /**
     *  Gets a workorder/workorder_id as parameter, creates a new stockmove in positive way(gross)
     */
    public function saveProductionGross($workOrder, $baseAmount, $datetime = null)
    {
        if($baseAmount <= 0) return;
        $this->instantiate($workOrder);
        $this->prepare($workOrder->product_id, $baseAmount, true, 'production_gross', $datetime, $workOrder->lot_no)->persist($workOrder);
    }



    /**
     *  Gets a workorder/workorder_id as parameter, creates a new stockmove in negative way(waste)
     */
    public function saveProductionWaste($workOrder, $baseAmount, $datetime = null)
    {
        if($baseAmount <= 0) return;
        $this->instantiate($workOrder);
        $this->prepare($workOrder->product_id, $baseAmount, false, 'production_waste', $datetime, $workOrder->lot_no)->persist($workOrder);
    }



    public function decreasedIngredient($workOrder, $ingredientId, $baseAmount, $datetime = null)
    {
        if($baseAmount <= 0) return;
        $this->instantiate($workOrder);
        $lotNumber = $workOrder->reservedStocks()->where('product_id', $ingredientId)->first()->reserved_lot;
        $this->prepare($ingredientId, $baseAmount, false, 'production_ingredient', $datetime, $lotNumber)->persist($workOrder);
    }



    /**
     * Create a positive move manually
     */
    public function moveIn($productId, $baseAmount, $datetime)
    {
        $this->prepare($productId, $baseAmount, true, 'manual', $datetime, 'değiştir movein out')->persist();
    }



    /**
     * Create a negative move manually
     */
    public function moveOut($productId, $baseAmount, $datetime)
    {
        $this->prepare($productId, $baseAmount, false, 'manual', $datetime, 'değiştir movein out')->persist();
    }
    


    /**
     * Make a move
     */
    public function newMove($productId, $baseAmount, $direction, $datetime, $lotNumber, $type = 'manual', $stockableType = null, $stockableId = null)
    {
        $this->prepare($productId, $baseAmount, $direction, $type, $datetime, $lotNumber, $stockableType, $stockableId)->persist();
    }


    /**
     * Prepare properties to push into database
     */
    private function prepare($productId, $baseAmount, $direction, $type, $datetime = null, $lotNumber, $stockableType = null, $stockableId = null)
    {
        $this->productId = $productId;
        $this->type = $type;
        $this->direction = $direction;
        $this->baseAmount = $baseAmount;
        $this->lotNumber = $lotNumber;
        // $this->unitId = $unitId instanceof \App\Models\Unit
        //     ? $unitId->id
        //     : $unitId;
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
            'base_amount' => $this->baseAmount,
            'lot_number' => $this->lotNumber,
            // 'unit_id' => $this->unitId,
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