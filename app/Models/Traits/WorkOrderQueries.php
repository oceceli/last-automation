<?php 

namespace App\Models\Traits;

use App\Common\Facades\Conversions;
use App\Common\Facades\Stock;
use Exception;

trait WorkOrderQueries // production olsun bu !!!
{
    private $baseGrossAmount;
    private $baseWasteAmount;
    
    

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
        

        Stock::productionGross($this, $productionGross, $unitId);
        Stock::productionWaste($this, $productionWaste, $unitId);

        $this->markAsCompleted();

        foreach($this->necessaryIngredients as $necessary) {
            Stock::decreasedIngredient($this, $necessary['ingredient']->id, $necessary['amount'], $necessary['unit_id']);
        }

    }

    public function getNecessaryIngredientsAttribute()
    {
        $workOrderGross = Conversions::toBase($this->unit, $this->amount);

        foreach($this->product->recipe->ingredients as $ingredient) {
            $totalDecrease[] = [
                'ingredient' => $ingredient,
                'amount' => $workOrderGross['amount'] * $ingredient->pivot->amount,
                'unit_id' => $ingredient->pivot->unit_id,
            ];
        }
        return collect($totalDecrease);
    }

    
}



// $workOrderGross = Conversions::toBase($this->unit, $this->amount);
// $actualGrossAmount = Conversions::toBase($unitId, $productionGross); // DEVAM