<?php 

namespace App\Models\Traits;

use App\Common\Facades\Conversions;
use App\Common\Facades\Moves;

trait Production
{
    private $productionGross;
    // private $productionWaste;

    public function saveProductionResults($productionGross, $productionWaste, $unitId)
    {
        if($productionWaste > $productionGross) return;
        if($this->isFinalized()) return;

        // take production results to their base unit
        $productionGross = Conversions::toBase($unitId, $productionGross)['amount'];
        $productionWaste = Conversions::toBase($unitId, $productionWaste)['amount'];

        $this->productionGross = $productionGross;

        Moves::saveProductionGross($this, $productionGross);
        Moves::saveProductionWaste($this, $productionWaste);

        $this->markAsFinalized();

        foreach($this->necessaryIngredients as $necessary) {
            Moves::decreasedIngredient($this, $necessary['ingredient']->id, $necessary['amount']);
        }
    }

    public function getNecessaryIngredientsAttribute()
    {
        $plannedBaseAmount = Conversions::toBase($this->unit, $this->amount)['amount'];
        
        foreach($this->product->recipe->ingredients as $key => $ingredient) {
            $ingredientBaseAmount = Conversions::toBase($ingredient->pivot->unit_id, $ingredient->pivot->amount)['amount'];
            $totalDecrase[$key]['ingredient'] = $ingredient;
            if($this->isFinalized()) {
                if($ingredient->pivot->literal) {
                    $totalDecrase[$key]['amount'] = $plannedBaseAmount * $ingredientBaseAmount;
                } else {
                    $totalDecrase[$key]['amount'] = floor($this->productionGross * $ingredientBaseAmount); // ?? ceil ya da floor
                }
            } else { // for presentatiton // 'at least requirement'
                $totalDecrase[$key]['amount'] = floor($plannedBaseAmount * $ingredientBaseAmount);
            }
        }
        return $totalDecrase;
    }




    public function getProductionGross()
    {
        $gross = $this->stockMoves()->where('type', 'production_gross')->get();
        if($gross->isEmpty())
            return 0;
        return $gross->first()->base_amount;
    }

    public function getProductionWaste()
    {
        $waste = $this->stockmoves()->where('type', 'production_waste')->get();
        if($waste->isEmpty())
            return 0;
        return $waste->first()->base_amount;
    }


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
