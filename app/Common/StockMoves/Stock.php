<?php

namespace App\Common\StockMoves;

use App\Models\StockMove;

class Stock 
{
    public function types()
    {
        return [
            ['value' => 'production', 'text' => __("stockmoves.production")],
            ['value' => 'manual', 'text' => __("stockmoves.manual")],
        ];
    }

    public function directions()
    {
        return [
            ['value' => 1, 'text' => __("stockmoves.stock_entry")],
            ['value' => 0, 'text' => __("stockmoves.stock_decrease")],
        ];
    }

    public function moveInProd($product, $amount)
    {
        StockMove::create(['product_id' => $product['id'], 'type' => 'production', 'direction' => true, 'amount' => $amount, 'datetime' => now()]);
    }

    public function moveOutProd($product, $amount)
    {
        StockMove::create(['product_id' => $product['id'], 'type' => 'production', 'direction' => false, 'amount' => $amount, 'datetime' => now()]);
    }
}