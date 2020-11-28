<?php

namespace App\Models\Traits;

use App\Common\Facades\StockCalculations;

trait HasInventory
{
    public function getTotalStockAttribute()
    {
        return StockCalculations::getCurrentStockAmountOfProduct($this->id);
    }

    public function getLotsAttribute()
    {
        return StockCalculations::lotNumbersAndAmounts($this->id);
    }

    public function getStockStatusColorsAttribute()
    {
        if($this->totalStock <= 0) $color = ['header' => 'bg-red-50', 'text' => 'text-red-400 hover:text-red-600'];
        elseif($this->totalStock > 0 && $this->totalStock < $this->min_threshold) $color = ['header' => 'bg-yellow-100', 'text' => 'text-yellow-400 hover:text-yellow-600'];
        else $color = ['header' => 'bg-green-100', 'text' => 'text-green-400 hover:text-green-600'];


        return $color;
    }



}