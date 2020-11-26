<?php

namespace App\Common\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @method static \App\Common\StockMoves\Stock productionGross($workOrder, $amount, $unitId, $datetime = null)
 *
 */

class StockCalculations extends Facade
{

    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'StockCalculations';
    }
}