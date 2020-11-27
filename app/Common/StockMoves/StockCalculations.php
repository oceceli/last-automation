<?php

namespace App\Common\StockMoves;

use App\Models\Product;
use App\Models\StockMove;

class StockCalculations
{
    // public function total() // constructora taşı
    // {
    //     foreach (Product::all() as $product) {
    //         $stocks[] = [
    //             'product' => $product,
    //             'total' => $this->positiveMoves($product->id) - $this->negativeMoves($product->id),
    //             'last_entry' => $this->lastEntry($product->id),
    //         ];
    //     }
    //     return $stocks;
    // }

    public function test()
    {
        foreach (Product::all() as $product) {
            $stocks[] = [
                'product' => $product,
                'total' => $this->positiveMoves($product->id) - $this->negativeMoves($product->id),
                'lot_numbers' => $this->getLots($product->id),
                'last_entry' => $this->lastEntry($product->id),
            ];
        }
        return $stocks;
    }

    // private function istediğimYapı()
    // {
    //     return collect([
    //         'product' => App\Model\Product::class,
    //         'total' => $this->positiveMoves(2) - $this->negativeMoves(2),
    //         'lot_numbers' => [
    //             '201100401' => 450,
    //             '201100402' => 800,
    //             '201153825' => 1200,
    //         ]
    //     ]);
    // }

    private function getLots($productId)
    {
        $lots = StockMove::where('product_id', 2)->pluck('lot_number')->all();
        $uniqueLots = array_values(array_unique($lots));
        foreach($uniqueLots as $lotNumber) {
            $a[$lotNumber] = StockMove::where([
                'lot_number' => $lotNumber,
                'direction' => true,
            ])->sum('base_amount'); 
        }
        foreach($uniqueLots as $lotNumber) {
            $b[$lotNumber] = StockMove::where([
                'lot_number' => $lotNumber,
                'direction' => false,
            ])->sum('base_amount'); 
        }
        dd($this->lot($uniqueLots[0], 1) - $this->lot($uniqueLots[0], 0)); // BURADAN DEVAM ET
    }

    private function lot($lotNumber, $direction)
    {
        return StockMove::where([
            'lot_number' => $lotNumber,
            'direction' => $direction,
        ])->sum('base_amount');
    }



    private function positiveMoves($productId)
    {
        return StockMove::where([
            'product_id' => $productId,
            'direction' => true,
        ])->sum('base_amount');
    }

    private function negativeMoves($productId)
    {
        return StockMove::where([
            'product_id' => $productId,
            'direction' => false,
        ])->sum('base_amount');
    }

    private function lastEntry($productId)
    {
        $last = StockMove::where('product_id', $productId)
            ->latest()->first();
        if($last) return $last->updated_at->diffForHumans();
    }






    // private function totalProductionGross($productId)
    // {
    //     return StockMove::where([
    //             'product_id' => $productId, 
    //             'direction' => true,
    //             'type' => 'production_gross',
    //         ]) ->sum('base_amount');
    // }

    // private function totalProductionWaste($productId)
    // {
    //     return StockMove::where([
    //             'product_id' => $productId, 
    //             'direction' => false,
    //             'type' => 'production_waste',
    //         ])->sum('base_amount');
    // }

}