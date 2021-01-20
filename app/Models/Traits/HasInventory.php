<?php

namespace App\Models\Traits;

use App\Common\Facades\StockCalculations;
use App\Services\Stock\LotNumberService;

trait HasInventory
{
    public function getTotalStockAttribute()
    {
        return (new LotNumberService($this))->total();
        // return StockCalculations::getCurrentStockAmountOfProduct($this->id);
    }

    public function getLotsAttribute()
    {
        return (new LotNumberService($this))->allWithAmounts();
        // return StockCalculations::lotNumbersAndAmounts($this->id); // !! use lotnumberservice instead
    }

    public function getIsInStockAttribute()
    {
        return $this->totalStock['amount'] > 0;
    }

    public function getLastMoveAttribute()
    {
        $lastMove = StockCalculations::lastMove($this->id);
        if($lastMove) return [
            'date' => $lastMove->updated_at->diffForHumans(),
            'direction' => $this->directionLookup($lastMove->direction),
        ];
        else return ['date' => null, 'direction' => null];
        dd($lastMove);
    }

    
    public function getStockStatusAttribute()
    {
        if($this->totalStock['amount'] > 0 && $this->totalStock['amount'] < 100) 
        $array = [
            'tr' => 'bg-yellow-100 text text-yellow-500 hover:text-yellow-800 left yellow marked', 
            'icon' => 'exclamation circle icon', 
            'explanation' => __('inventory.lower_than_count_unit', ['count' => $this->min_threshold, 'unit' => $this->baseUnit->abbreviation]),
        ];
        elseif($this->totalStock['amount'] <= 0) 
            $array = [
                'tr' => 'bg-red-50 text-red-500 hover:text-red-800 left red marked', 
                'icon' => 'exclamation icon', 
                'explanation' => __('inventory.out_of_stock'),
            ];
        elseif($this->totalStock['amount'] > 0 && $this->totalStock['amount'] < $this->min_threshold) 
            $array = [
                'tr' => 'bg-yellow-100 text text-yellow-500 hover:text-yellow-800 left yellow marked', 
                'icon' => 'exclamation circle icon', 
                'explanation' => __('inventory.stock_under_100_unit', ['unit' => $this->baseUnit->abbreviation]),
            ];
        else 
            $array = [
                'tr' => 'text-green-500 hover:text-green-800 left green marked', 
                'icon' => 'circle icon', 
                'explanation' => __('inventory.sufficient_amount'),
            ];
        return $array;
    }

    public function directionLookup($direction)
    {
        return [
            true => 'arrow up icon',
            false => 'arrow down icon',
         ][$direction] ?? null;
    }



}