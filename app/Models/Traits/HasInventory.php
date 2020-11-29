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

    
    public function getStockStatusAttribute()
    {
        if($this->totalStock['amount'] <= 0) 
            $array = [
                'tr' => 'bg-red-50 text-red-500 hover:text-red-800 left red marked', 
                'icon' => 'exclamation icon', 
                'explanation' => __('inventory.out_of_stock'),
            ];
        elseif($this->totalStock['amount'] > 0 && $this->totalStock['amount'] < $this->min_threshold) 
            $array = [
                'tr' => 'bg-yellow-100 text text-yellow-500 hover:text-yellow-800 left yellow marked', 
                'icon' => 'exclamation circle icon', 
                'explanation' => __('inventory.at_least_count_unit_needed', ['count' => $this->min_threshold, 'unit' => $this->baseUnit->abbreviation]),
            ];
        else 
            $array = [
                'tr' => 'text-green-500 hover:text-green-800 left green marked', 
                'icon' => 'circle icon', 
                'explanation' => __('inventory.sufficient_amount'),
            ];
        return $array;
    }



}