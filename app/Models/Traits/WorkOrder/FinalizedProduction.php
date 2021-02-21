<?php

namespace App\Models\Traits\WorkOrder;

trait FinalizedProduction
{
    /**
     * Get gross amount of finalized workorder
     */
    public function getProductionTotal() : float
    {
        $total = $this->stockMoves()->where('type', 'production_total')->first();
        return optional($total)->base_amount;
    }


    /**
     * Get waste amount of finalized workorder
     */
    public function getProductionWaste() : float 
    {
        $waste = $this->stockmoves()->where('type', 'production_waste')->first();
        return optional($waste)->base_amount;
    }


    /**
     * Get production results of finalized workorder as an array
     */
    public function getProductionResultsAttribute()
    {
        if($this->isCompleted() || $this->isApproved()) {
            return [
                'total' => $this->getProductionTotal(),
                'waste' => $this->getProductionWaste(),
                'net' => $this->getProductionTotal() - $this->getProductionWaste(),
            ];
        }
    }

    public function getIngredientMovesAttribute()
    {
        return $this->stockmoves()->where('type', 'production_ingredient')->get();
    }
    
}