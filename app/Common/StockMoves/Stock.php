<?php

namespace App\Common\StockMoves;

use App\Models\StockMove;

class Stock 
{


    public function moveInProd($product, $amount)
    {
        StockMove::create(['product_id' => $product['id'], 'type' => 'production', 'direction' => true, 'amount' => $amount, 'datetime' => now()]);
    }

    public function moveOutProd($product, $amount)
    {
        StockMove::create(['product_id' => $product['id'], 'type' => 'production', 'direction' => false, 'amount' => $amount, 'datetime' => now()]);
    }
}