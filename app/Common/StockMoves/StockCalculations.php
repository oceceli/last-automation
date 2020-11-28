<?php

namespace App\Common\StockMoves;

use App\Models\Product;
use App\Models\StockMove;
use App\Models\Unit;

class StockCalculations
{


    public function getCurrentStockAmountOfProduct($productId)
    {
        return array_sum(array_column($this->lotNumbersAndAmounts($productId), 'amount'));
    }


    public function lotNumbersAndAmounts($productId)
    {        
        $lotNumbers = StockMove::where('product_id', $productId)
            ->distinct()
            ->get(['lot_number'])
            ->pluck('lot_number')
            ->toArray();

        foreach($lotNumbers as $lotNumber) {
            $array[] = [
                'lot_number' => $lotNumber,
                'amount' => $this->getCurrentAmountBasedOnLotNumber($lotNumber),
                'unit' => $this->getUnit($productId),
            ];
        }
        return isset($array) ? $array : [];
    }

    
    private function getCurrentAmountBasedOnLotNumber($lotNumber)
    {
        return $this->lotQuery($lotNumber, true) - $this->lotQuery($lotNumber, false);
    }

    private function getUnit($productId)
    {
        return Unit::where('product_id', $productId)->first();
    }

    
    
    private function lotQuery($lotNumber, $direction)
    {
        return StockMove::where([
            'lot_number' => $lotNumber,
            'direction' => $direction,
        ])->sum('base_amount');
    }



    private function lastEntry($productId)
    {
        $last = StockMove::where('product_id', $productId)
            ->latest()->first();
        return $last = $last->updated_at->diffForHumans();
        // if($last) return $last->updated_at->diffForHumans();
    }


    // public function total()
    // {
    //     foreach (Product::all() as $product) {
    //         $stocks[] = [
    //             'product' => $product,
    //             'total' => $this->getCurrentStockAmountOfProduct($product->id),
    //             'lot_numbers' => $this->lotNumbersAndAmounts($product->id),
    //             'last_move' => $this->lastEntry($product->id),
    //         ];
    //     }
    //     return $stocks;
    // }


}