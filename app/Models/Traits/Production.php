<?php 

namespace App\Models\Traits;

use App\Common\Facades\Conversions;
use App\Common\Facades\Stock;
use App\Models\Unit;

trait Production // production olsun bu !!!
{
    private $productionGross;
    // private $productionWaste;
    
    

    public function getProductionGross()
    {
        $gross = $this->stockMoves()->where('type', 'production_gross')->get();
        if($gross->isEmpty())
            return 0;
        return $gross->first()->amount;
    }

    public function getProductionWaste()
    {
        $waste = $this->stockmoves()->where('type', 'production_waste')->get();
        if($waste->isEmpty())
            return 0;
        return $waste->first()->amount;
    }

    public function net()
    {
        return $this->getProductionGross() - $this->getProductionWaste();
    }


    public function saveProductionResults($productionGross, $productionWaste, $unitId)
    {
        if($productionWaste > $productionGross) return;

        $this->productionGross = $productionGross;


        Stock::productionGross($this, $productionGross, $unitId);
        Stock::productionWaste($this, $productionWaste, $unitId);

        $this->markAsCompleted();

        foreach($this->necessaryIngredients as $necessary) {
            Stock::decreasedIngredient($this, $necessary['ingredient']->id, $necessary['amount'], $necessary['unit']);
        }
    }

    public function getNecessaryIngredientsAttribute()
    {
        $workOrderGross = Conversions::toBase($this->unit, $this->amount);
        
        foreach($this->product->recipe->ingredients as $ingredient) {
            $totalDecrase[] = [
                'ingredient' => $ingredient,
                'amount' => $this->isCompleted() && ! $ingredient->pivot->literal
                                ? $this->productionGross * $ingredient->pivot->amount
                                : $workOrderGross['amount'] * $ingredient->pivot->amount, 
                'unit' => Unit::find($ingredient->pivot->unit_id),
            ];
        }
        return $totalDecrase;
    }

    

    
}



// $workOrderGross = Conversions::toBase($this->unit, $this->amount);
// $actualGrossAmount = Conversions::toBase($unitId, $productionGross); 