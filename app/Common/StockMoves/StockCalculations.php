<?php

namespace App\Common\StockMoves;

use App\Models\Product;
use App\Models\ReservedStock;
use App\Models\StockMove;
use App\Models\Unit;

class StockCalculations
{


    public function getCurrentStockAmountOfProduct($productId)
    {
        return [
            'amount' => array_sum(array_column($this->lotNumbersAndAmounts($productId), 'amount')),
            'unit' => $this->getUnit($productId),
        ];
    }


    public function lotNumbersAndAmounts($productId)
    {
        // dd($this->reservedLots());
        $lotNumbers = StockMove::where('product_id', $productId)
            ->distinct()
            ->get(['lot_number'])
            ->pluck('lot_number')
            ->toArray();

        foreach($lotNumbers as $key => $lotNumber) {
            $reserved = ReservedStock::where(['reserved_lot' => $lotNumber, 'product_id' => $productId])->first();
            $amount = $this->getCurrentAmountBasedOnLotNumber($lotNumber, $productId);
            if($amount < 0) continue;
            $array[$key] = [
                'lot_number' => $lotNumber,
                'amount' => $amount,
                'unit' => $this->getUnit($productId),
            ];
            if($reserved) 
                $array[$key]['reserved_amount'] = $reserved->reserved_amount;
        }
        // dd($array); // !! dikkat
        return isset($array) ? $array : [];
    }


    
    private function getCurrentAmountBasedOnLotNumber($lotNumber, $productId)
    {
        return $this->lotQuery($lotNumber, $productId, true) - $this->lotQuery($lotNumber, $productId, false);
    }

    private function getUnit($productId)
    {
        return Unit::where('product_id', $productId)->first();
    }

    
    
    private function lotQuery($lotNumber, $productId, $direction)
    {
        return StockMove::where([
            'product_id' => $productId,
            'lot_number' => $lotNumber,
            'direction' => $direction,
        ])->sum('base_amount');
    }



    public function lastMove($productId)
    {
        $last = StockMove::where('product_id', $productId)
            ->latest()->first();
        // return $last = $last->updated_at->diffForHumans();
        return $last;
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