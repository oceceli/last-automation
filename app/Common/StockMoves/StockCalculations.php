<?php

namespace App\Common\StockMoves;

use App\Models\Product;
use App\Models\StockMove;

class StockCalculations
{
    public function calculateTotal()
    {
        foreach (Product::all() as $product) {
            $a[] = [
                'product' => $product,
                'total' => StockMove::where(['product_id' => $product->id])->sum('base_amount'),
            ];
        }
        dd(($a));
    }

    private function upDirectionAmount($productId)
    {
        return StockMove::where([
            'product_id' => $productId,
            'direction' => true,
        ]);
    }



    
    public function calculateTotallllll()
    {
        $products = Product::wherehas('stockmoves')->where('producible', 1)->get();
        foreach ($products as $product) {
            $a[] = [
                'product' => $product,
                'total' => $this->totalProductionGross($product->id) - $this->totalProductionWaste($product->id),
                // 'waste' => $this->totalProductionWaste($product->id),
                'lots' => $this->lotNumbers($product->id),
            ];
        }
        dd(($a));
    }

    private function totalProductionGross($productId)
    {
        return StockMove::where([
                'product_id' => $productId, 
                'direction' => true,
                'type' => 'production_gross',
            ]) ->sum('base_amount');
    }

    private function totalProductionWaste($productId)
    {
        return StockMove::where([
                'product_id' => $productId, 
                'direction' => false,
                'type' => 'production_waste',
            ])->sum('base_amount');
    }

    private function lotNumbers($productId)
    {
        StockMove::where([
            'product_id' => $productId,
            'direction' => true,
            'lot_number' => 'production_gross'
        ])->sum('base_amount');
    }
}