<?php

namespace App\Common\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @method static \App\Common\StockMoves\Stock saveProductionGross($workOrder, $amount, $unitId, $datetime = null)
 * @method static \App\Common\StockMoves\Stock saveProductionWaste($workOrder, $amount, $unitId, $datetime = null)
 * @method static \App\Common\StockMoves\Stock moveIn($productId, $amount, $unitId, $datetime, $stockableType = 'manual')
 * @method static \App\Common\StockMoves\Stock moveOut($productId, $amount, $unitId, $datetime, $stockableType = 'manual')
 * @method static \App\Common\StockMoves\Stock newMove($productId, $amount, $unitId, $direction, $datetime, $stockableType = 'manual')
 * @method static \App\Common\StockMoves\Stock decreasedIngredient($workOrder, $ingredientId, $amount, $unitId, $datetime = null)
 *
 * @see \Illuminate\Contracts\Foundation\Application
 */

class Moves extends Facade
{

    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'Moves';
    }
}