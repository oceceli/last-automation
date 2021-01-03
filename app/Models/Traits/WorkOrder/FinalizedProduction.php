<?php

namespace App\Models\Traits\WorkOrder;

trait FinalizedProduction
{
    /**
     * Get gross amount of finalized workorder
     */
    public function getProductionGross()
    {
        $gross = $this->stockMoves()->where('type', 'production_total')->get();
        if($gross->isEmpty())
            return 0;
        return $gross->first()->base_amount;
    }


    /**
     * Get waste amount of finalized workorder
     */
    public function getProductionWaste()
    {
        $waste = $this->stockmoves()->where('type', 'production_waste')->get();
        if($waste->isEmpty())
            return 0;
        return $waste->first()->base_amount;
    }


    /**
     * Get production results of finalized workorder as an array
     */
    public function getProductionResults()
    {
        if($this->isFinalized()) {
            return [
                'gross' => $this->getProductionGross(),
                'waste' => $this->getProductionWaste(),
                'net' => $this->getProductionGross() - $this->getProductionWaste(),
            ];
        }
    }
    
}