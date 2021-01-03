<?php 

namespace App\Models\Traits\WorkOrder;

use App\Common\Facades\Conversions;
use App\Stocks\ProductionIngredientMove;
use App\Stocks\ProductionTotalMove;
use App\Stocks\ProductionWasteMove;

trait FinalizeProduction
{

    private $inputTotal;  


    public function saveProductionResults($inputTotal, $inputWaste, $unitId)
    {
        if( ! $this->isInProgress()) return;
        if($inputWaste > $inputTotal) return;

        // take production results to their base unit
        $this->inputTotal = $inputTotal = Conversions::toBase($unitId, $inputTotal)['amount'];
        $inputWaste =                     Conversions::toBase($unitId, $inputWaste)['amount'];
        
        if(!$this->isEfficiencyAcceptable($inputTotal)) dd("verimlilik düşük/fazla"); //return; // todo: today livewire'da sorgula 

        (new ProductionTotalMove($this, (float)$inputTotal))->save();  // ?? kullanıcı girişi olduğu gibi stoğa yansıtılıyor. Yansımamalı. ** verimlilik yaptım eksikler var
        (new ProductionWasteMove($this, (float)$inputWaste))->save();
        
        $this->deductFromReservedSources();
        
        $this->markAsFinalized();
        $this->reservedStocks()->delete();

        return true;
    }
    


    /**
     * Subtracts reserved sources(based on lot number)
     */
    private function deductFromReservedSources()
    {
        $necessaryIngredients = $this->necessaryIngredients();

        foreach($necessaryIngredients as $necessary) {
            $reservedSources = $this->reservedStocks()->where('product_id', $necessary['ingredient']['id'])->get();
            foreach($reservedSources as $reservation) {
                // if($necessary['amount'] === 0) continue;
                if($necessary['amount'] >= $reservation->reserved_amount) {
                    (float)$toBeDeducted = $reservation->reserved_amount;
                    $necessary['amount'] -= $reservation->reserved_amount;
                } else {
                    (float)$toBeDeducted = $necessary['amount'];
                    $necessary['amount'] = 0;
                }

                (new ProductionIngredientMove($this, $necessary['ingredient']['id'], $reservation->reserved_lot, $toBeDeducted))
                    ->save();
            }
        }
    }



    /**
     * Return total amount of needed ingredients for current workorder's product 
     */
    private function necessaryIngredients() : array
    {
        foreach($this->product->recipe->ingredients as $key => $ingredient) {
            $ingredientBaseAmount = Conversions::toBase($ingredient->pivot->unit_id, $ingredient->pivot->amount)['amount'];
            $totalDecrase[$key] = [
                'ingredient' => $ingredient,
                'amount' => $ingredient->pivot->literal 
                    ? $this->plannedBaseAmount * $ingredientBaseAmount
                    : $this->inputTotal * $ingredientBaseAmount // ?? is flooring needed?
            ];
        }

        return $totalDecrase;
    }




    private function isEfficiencyAcceptable(float $inputTotal)
    {
        $toleranceFactor = $this->product->recipe->tolerance_factor; // !! reçete tablosuna ekle 

        $tolerance = ($this->plannedBaseAmount * $toleranceFactor) / 100;

        $positiveTolerance = ($inputTotal + $tolerance);
        $negativeTolerance = ($inputTotal - $tolerance);

        return ! ($this->plannedBaseAmount < $negativeTolerance || $this->plannedBaseAmount > $positiveTolerance);
    }

    
    
    
    
    public function getPlannedBaseAmountAttribute()
    {        
        return (float)Conversions::toBase($this->unit, $this->amount)['amount'];
    }

}