<?php 

namespace App\Models\Traits\WorkOrder;

use App\Common\Facades\Conversions;
use App\Common\Facades\Moves;

trait Production
{
    private $userGrossInput;
    // private $userWasteInput;

    /**
     * Finalize the production for this workorder
     */
    public function saveProductionResults($userGrossInput, $userWasteInput, $unitId)
    {
        if( ! $this->isInProgress()) return;
        if($userWasteInput > $userGrossInput) return;

        // take production results to their base unit
        $userGrossInput = Conversions::toBase($unitId, $userGrossInput)['amount'];
        $userWasteInput = Conversions::toBase($unitId, $userWasteInput)['amount'];

        $this->userGrossInput = $userGrossInput;

        Moves::saveProductionGross($this, $userGrossInput);
        Moves::saveProductionWaste($this, $userWasteInput);
        
        foreach($this->necessaryIngredients() as $necessary) {
            Moves::decreasedIngredient($this, $necessary['ingredient']->id, $necessary['amount']);
        }
        
        $this->markAsFinalized();
        $this->reservedStocks()->delete();
        return true;
    }
    

    private function necessaryIngredients()
    {
        $plannedBaseAmount = Conversions::toBase($this->unit, $this->amount)['amount'];
        
        foreach($this->product->recipe->ingredients as $key => $ingredient) {
            $ingredientBaseAmount = Conversions::toBase($ingredient->pivot->unit_id, $ingredient->pivot->amount)['amount'];
            $totalDecrase[$key] = [
                'ingredient' => $ingredient,
                'amount' => $ingredient->pivot->literal 
                    ? $plannedBaseAmount * $ingredientBaseAmount
                    : $this->userGrossInput * $ingredientBaseAmount // ?? is flooring needed?
            ];
        }

        return $totalDecrase;
    }
    



    /**
     * Get gross amount of finalized workorder
     */
    public function getProductionGross()
    {
        $gross = $this->stockMoves()->where('type', 'production_gross')->get();
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




// if($this->isFinalized()) {
            //     if($ingredient->pivot->literal) {
            //         $totalDecrase[$key]['amount'] = $plannedBaseAmount * $ingredientBaseAmount;
            //     } else {
            //         $totalDecrase[$key]['amount'] = floor($this->userGrossInput * $ingredientBaseAmount); // ?? ceil ya da floor
            //     }
            // } else { // for presentatiton // 'at least requirement'
            //     $totalDecrase[$key]['amount'] = floor($plannedBaseAmount * $ingredientBaseAmount);
            // }