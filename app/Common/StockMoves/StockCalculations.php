<?php

namespace App\Common\StockMoves;

use App\Models\Product;
use App\Models\StockMove;

class StockCalculations
{
    public function calculateTotal()
    {
        $productsHasMoves = Product::wherehas('stockmoves')->get();
        // foreach ($productsHasMoves as $product) {
        //     $a = StockMove::where()
        // }
        $a = StockMove::where('product_id', 2)
                    ->where('direction', true)
                    ->sum('amount');
        dd($a);
    }

    public function totalProductionGross($productId)
    {
        
    }

    public function totalProductionWaste($productId)
    {

    }
}