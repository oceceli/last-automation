<?php 

namespace App\Models\Traits\WorkOrder;

use App\Common\Facades\Conversions;
use App\Stocks\ProductionIngredientMove;
use App\Stocks\ProductionTotalMove;
use App\Stocks\ProductionWasteMove;

trait Production
{
    private $inputTotal;

    /**
     * Finalize the production for this workorder
     */
    // public function saveProductionResults($inputTotal, $inputWaste, $unitId)
    // {
    //     if( ! $this->isInProgress()) return;
    //     if($inputWaste > $inputTotal) return;

    //     // take production results to their base unit
    //     $inputTotal = Conversions::toBase($unitId, $inputTotal)['amount'];
    //     $inputWaste = Conversions::toBase($unitId, $inputWaste)['amount'];

    //     $this->inputTotal = $inputTotal;

    //     Moves::saveProductionGross($this, $inputTotal);
    //     Moves::saveProductionWaste($this, $inputWaste);
        
    //     foreach($this->necessaryIngredients() as $necessary) {
    //         Moves::decreasedIngredient($this, $necessary['ingredient']->id, $necessary['amount']);
    //     }
        
    //     $this->markAsFinalized();
    //     $this->reservedStocks()->delete();
    //     return true;
    // }
    


    public function saveProductionResults($inputTotal, $inputWaste, $unitId)
    {
        if( ! $this->isInProgress()) return;
        if($inputWaste > $inputTotal) return;

        
        // take production results to their base unit
        $inputTotal = Conversions::toBase($unitId, $inputTotal)['amount'];
        $inputWaste = Conversions::toBase($unitId, $inputWaste)['amount'];
        
        if(!$this->isEfficiencyAcceptable($inputTotal)) dd("verimlilik düşük/fazla"); //return; // todo: today livewire'da sorgula 

        $this->inputTotal = $inputTotal;

        (new ProductionTotalMove($this, $inputTotal))->save();  // ?? kullanıcı girişi olduğu gibi stoğa yansıtılıyor. Yansımamalı.
        (new ProductionWasteMove($this, $inputWaste))->save();
        
        $this->deductIngredients();
        
        // foreach($this->necessaryIngredients() as $necessary) {

        //     (new ProductionIngredientMove($this, $necessary['ingredient']->id, $necessary['lot_number'], $necessary['amount']))->save();
            
        //     // Moves::decreasedIngredient($this, $necessary['ingredient']->id, $necessary['amount']);
        // }
            


        // $this->markAsFinalized();
        // $this->reservedStocks()->delete();
        return true;
    }
    
    private function deductIngredients()
    {
        foreach($this->reservedStocks as $reservation) {
            (new ProductionIngredientMove($this, $reservation->product_id, $reservation->reserved_lot, $reservation->reserved_amount))->save();
        }
    }


    private function isEfficiencyAcceptable(int $inputTotal)
    {
        $toleranceFactor = $this->product->recipe->tolerance_factor; // !! reçete tablosuna ekle 

        $tolerance = ($this->plannedBaseAmount * $toleranceFactor) / 100;

        $positiveTolerance = ($inputTotal + $tolerance);
        $negativeTolerance = ($inputTotal - $tolerance);

        return ! ($this->plannedBaseAmount < $negativeTolerance || $this->plannedBaseAmount > $positiveTolerance);
    }

    
    
    
    
    public function getPlannedBaseAmountAttribute()
    {        
        return (int)Conversions::toBase($this->unit, $this->amount)['amount'];
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





// private function necessaryIngredients() : array
    // {
    //     // kaç adet ürün üretilecek? (Main product)
    //     $plannedBaseAmount = Conversions::toBase($this->unit, $this->amount)['amount'];
        
    //     foreach($this->product->recipe->ingredients as $key => $ingredient) {
    //         $ingredientBaseAmount = Conversions::toBase($ingredient->pivot->unit_id, $ingredient->pivot->amount)['amount'];
    //         $totalDecrase[$key] = [
    //             'ingredient' => $ingredient,
    //             'amount' => $ingredient->pivot->literal 
    //                 ? $plannedBaseAmount * $ingredientBaseAmount
    //                 : $this->inputTotal * $ingredientBaseAmount // ?? is flooring needed?
    //         ];
    //     }

    //     return $totalDecrase;
    // }
