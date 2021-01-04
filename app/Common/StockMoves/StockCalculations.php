<?php

namespace App\Common\StockMoves;

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
        $lotNumbers = StockMove::where('product_id', $productId)
            ->distinct()
            ->get(['lot_number'])
            ->pluck('lot_number')
            ->toArray();

        foreach($lotNumbers as $key => $lotNumber) {
            $lotAmount = $this->getCurrentAmountBasedOnLotNumber($lotNumber, $productId);

            // don't push zero lots to array 
            if($lotAmount == 0) continue; // !! eksi değerlerden bir şekilde korunmam lazım 

            $array[$key] = [
                'lot_number' => $lotNumber,
                'unit' => $this->getUnit($productId),
                'amount' => $lotAmount,
                'available_amount' => $lotAmount,
                'reserved_amount' => null,
            ];

            // workorder in_progress olduğu sürece kaynakları rezerve ediyor. İş iptal edilmeden veya sonlandırılmadan kaynaklar kullanılamaz olmalı.
            $reservations = ReservedStock::where(['reserved_lot' => $lotNumber, 'product_id' => $productId])->get();

            if($reservations) {
                $totalReserved = 0;
                foreach($reservations as $reservation) {
                    $totalReserved += $reservation->reserved_amount;
                    $array[$key]['available_amount'] = $lotAmount - $totalReserved;
                    $array[$key]['reserved_amount'] = (float)$totalReserved;
                }
            }
            // dd($array);
        }
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