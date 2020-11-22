<?php 

namespace App\Models\Traits;


trait WorkOrderQueries 
{
    public function getGross()
    {
        $gross = $this->stockMoves()->where('type', 'production_gross')->get();
        if($gross->isEmpty())
            return 0;
        return $gross->first()->amount;
    }

    public function getWaste()
    {
        $waste = $this->stockmoves()->where('type', 'production_waste')->get();
        if($waste->isEmpty())
            return 0;
        return $waste->first()->amount;
    }

    public function net()
    {
        return $this->getGross() - $this->getWaste();
    }

    
}