<?php

namespace App\Common\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @method static \App\Common\StockMoves\Stock productionGross($workOrder, $amount, $datetime = null)
 * @method static \App\Common\StockMoves\Stock productionWaste($workOrder, $amount, $datetime = null)
 * @method static \App\Common\StockMoves\Stock moveIn($productId, $amount, $datetime, $stockableType = 'manual')
 * @method static \App\Common\StockMoves\Stock moveOut($productId, $amount, $datetime, $stockableType = 'manual')
 * @method static \App\Common\StockMoves\Stock newMove($productId, $amount, $direction, $datetime, $stockableType = 'manual')
 * @method static \App\Common\StockMoves\Stock decreasedIngredient($workOrder, $ingredientId, $amount, $datetime = null)
 *
 * @see \Illuminate\Contracts\Foundation\Application
 */

class Stock extends Facade
{

    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'Stock';
    }
}