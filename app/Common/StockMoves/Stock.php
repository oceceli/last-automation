<?php

namespace App\Common\StockMoves;

use App\Models\StockMove;

class Stock 
{
    // public function types()
    // {
    //     return [
    //         ['value' => 'production', 'text' => __("stockmoves.production")],
    //         ['value' => 'manual', 'text' => __("stockmoves.manual")],
    //     ];
    // }

    // public function directions()
    // {
    //     return [
    //         ['value' => 1, 'text' => __("stockmoves.stock_entry")],
    //         ['value' => 0, 'text' => __("stockmoves.stock_decrease")],
    //     ];
    // }

    public function moveInProduction($workOrder, $amount, $date = null)
    {
        if(!$date) $date = now();
        $workOrder->stockMoves()->create(
            [
                'product_id' => $workOrder->product_id, 
                'direction' => true, 
                'amount' => $amount, 
                'datetime' => $date
            ]
        );
    }

    public function moveOutProduction($workOrder, $amount, $date = null)
    {
        if(!$date) $date = now();
        $workOrder->stockMoves()->create(
            [
                'product_id' => $workOrder->product_id, 
                'direction' => false, 
                'amount' => $amount, 
                'datetime' => $date
            ]
        );
    }

    // public function manualStock($data)
    // {
    //     return $this->newMove($data['product_id'], $data['direction'], $data['amount'], $data['datetime']);
    // }

    public function newMove($productId, $direction, $amount, $datetime, $stockableType = 'manual')
    {
        StockMove::create(
            [
                'product_id' => $productId,
                'direction' => $direction,
                'amount' => $amount,
                'datetime' => $datetime,
                'stockable_type' => $stockableType,
            ]
        );
    }

}