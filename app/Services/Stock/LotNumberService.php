<?php 

namespace App\Services\Stock;

use App\Models\Product;
use App\Models\ReservedStock;
use App\Models\StockMove;

class LotNumberService
{
    private Product $product;
    

    public function __construct(Product $product)
    {
        $this->product = $product;
    }





    public function total()
    {
        $amount = array_sum(array_column($this->allWithAmounts(), 'amount'));
        $availableAmount = array_sum(array_column($this->allWithAmounts(), 'available_amount'));
        $reservedAmount = array_sum(array_column($this->allWithAmounts(), 'reserved_amount'));
        $unit = $this->product->baseUnit;
        return [
            'amount' => $amount,
            'available_amount' => $availableAmount,
            'reserved_amount' => $reservedAmount,
            'amount_string' => "$amount {$unit->name}",
            'available_amount_string' => "$availableAmount {$unit->name}",
            'unit' => $unit,
        ];
    }

    

    /**
     * Get total amount of updirection stockmoves
     */
    private function positive($lot)
    {
        return StockMove::where([
            'product_id' => $this->product->id, 
            'lot_number' => $lot,
            'direction' => true,
        ])->sum('base_amount');
    }




    /**
     * Get total amount of downdirection stockmoves
     */
    private function negative($lot)
    {
        return StockMove::where([
            'product_id' => $this->product->id, 
            'lot_number' => $lot,
            'direction' => false,
        ])->sum('base_amount');
    }




    /**
     * @return float actual amount of given lot
     */
    public function only($lot)
    {
        return $this->positive($lot) - $this->negative($lot);
    }




    public function count()
    {
        return count($this->uniqueLots());
    }




    /**
     *  Drops down into one all stockmove lot occurrences
     * 
     * @return array unique lot numbers
     */
    private function uniqueLots()
    {
        return StockMove
            ::where(['product_id' => $this->product->id])
            ->select('lot_number')
            ->distinct()
            ->get()->pluck('lot_number');
    }




    /**
     * @return array lot numbers and amounts
     */
    public function allWithAmounts()
    {
        // $arr = [];
        foreach($this->uniqueLots() as $lot) {
            $amount = $this->only($lot);
            if($amount == 0) continue;

            $reservedAmount = $this->reservedAmount($lot);
            $availableAmount = $amount - $reservedAmount;
            
            $unit = $this->product->baseUnit;
            $arr[] = [
                'lot_number' => $lot, 
                'amount' => $amount,
                'available_amount' => $availableAmount,
                'reserved_amount' => (float)$reservedAmount,
                'amount_string' => "$amount {$unit->name}", // presentation is much easy now (:
                'available_amount_string' => "$availableAmount {$unit->name}",
                'unit' => $unit,
            ];
        }
        return isset($arr) ? $arr : [];
    }




    public function reservedAmount($lot)
    {
        return ReservedStock::where(
            [
                'reserved_lot' => $lot, 
                'product_id' => $this->product->id,
                // 'is_archived' => false, // !! bunu ekleyeceğim gibi duruyor
            ]
        )->sum('reserved_amount');
    }

}