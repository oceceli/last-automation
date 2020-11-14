<?php

namespace App\Common\Facades;

use Illuminate\Support\Facades\Facade;

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