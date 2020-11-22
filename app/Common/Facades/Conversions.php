<?php

namespace App\Common\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @method static \App\Common\Units\Conversions setBaseUnit($product_id, $unit_id)
 * @method static \App\Common\Units\Conversions addUnit(array $data)
 * @method static \App\Common\Units\Conversions toBase($unit, $amount = 1)
 * @method static \App\Common\Units\Conversions convert($amount, $from, $target)
 */

class Conversions extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'Conversions';
    }
}