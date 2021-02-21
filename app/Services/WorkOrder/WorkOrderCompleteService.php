<?php 

namespace App\Services\WorkOrder;

use App\Common\Facades\Conversions;
use App\Models\WorkOrder;
use App\Stocks\ProductionIngredientMove;
use App\Stocks\ProductionTotalMove;
use App\Stocks\ProductionWasteMove;

class WorkOrderCompleteService
{
    private $workOrder;

    private $total;
    private $waste; 

    public function __construct(WorkOrder $workOrder, $unit_id, $total, $waste)
    {
        $this->workOrder = $workOrder;

        // take production results to their base unit
        $this->total = Conversions::toBase($unit_id, $total)['amount'];
        $this->waste = Conversions::toBase($unit_id, $waste)['amount'];
    }


    public function saveProductionResults()
    {        
        if( $this->efficiencyIsNotAcceptable()) return;

        (new ProductionTotalMove($this->workOrder, (float)$this->total))->save();
        (new ProductionWasteMove($this->workOrder, (float)$this->waste))->save();

        $this->deductFromReservedSources();
        
        return true;
    }
    


    /**
     * Subtracts reserved sources(based on lot number)
     */
    private function deductFromReservedSources()
    {
        foreach($this->necessaryIngredients() as $necessary) {
            $reservedSources = $this->workOrder->reservedStocks()->where('product_id', $necessary['ingredient']['id'])->get();
            foreach($reservedSources as $reservation) {
                // if($necessary['amount'] === 0) continue;
                if($necessary['amount'] >= $reservation->reserved_amount) {
                    (float)$toBeDeducted = $reservation->reserved_amount;
                    $necessary['amount'] -= $reservation->reserved_amount;
                } else {
                    (float)$toBeDeducted = $necessary['amount'];
                    $necessary['amount'] = 0;
                }

                (new ProductionIngredientMove($this->workOrder, $necessary['ingredient']['id'], $reservation->reserved_lot, $toBeDeducted))->save();
            }
        }
    }



    /**
     * Return total amount of needed ingredients for workorder's product 
     */
    private function necessaryIngredients() : array
    {
        foreach($this->workOrder->product->recipe->ingredients as $ingredient) {
            $ingredientBaseAmount = Conversions::toBase($ingredient->pivot->unit_id, $ingredient->pivot->amount)['amount'];
            $totalDecrase[] = [
                'ingredient' => $ingredient,
                'amount' => $ingredient->pivot->literal 
                    ? $this->plannedBaseAmount() * $ingredientBaseAmount
                    : ($this->total + $this->waste) * $ingredientBaseAmount
            ];
        }
        return $totalDecrase;
    }




    public function efficiencyIsNotAcceptable() : bool
    {
        $toleranceFactor = $this->workOrder->product->recipe->tolerance_factor; // !! reçete tablosuna ekle 

        $tolerance = ($this->plannedBaseAmount() * $toleranceFactor) / 100;

        $positiveTolerance = ($this->total + $tolerance);
        $negativeTolerance = ($this->total - $tolerance);

        return $this->plannedBaseAmount() < $negativeTolerance || $this->plannedBaseAmount() > $positiveTolerance;
    }

    
    
    
    
    private function plannedBaseAmount() : float
    {        
        return Conversions::toBase($this->workOrder->unit, $this->workOrder->wo_amount)['amount'];
    }

}