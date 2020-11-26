<?php

namespace App\Common\StockMoves;

use App\Models\Product;
use App\Models\StockMove;

class StockCalculations
{
    public function total()
    {
        foreach (Product::all() as $product) {
            $stocks[] = [
                'product' => $product,
                'total' => $this->positiveMoves($product->id) - $this->negativeMoves($product->id),
                'last_entry' => $this->lastEntry($product->id),
            ];
        }
        return $stocks;
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



    
    public function calculateTotallllll()
    {
        $products = Product::wherehas('stockmoves')->where('producible', 1)->first();
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