<?php

namespace App\Models\Traits;

use App\Common\Facades\StockCalculations;
use App\Services\Stock\LotNumberService;

trait HasInventory
{
    public function getTotalStockAttribute()
    {
        return (new LotNumberService($this))->total();
    }

    public function getLotsAttribute()
    {
        return (new LotNumberService($this))->allWithAmounts();
    }

    public function onlyLot($lotNumber)
    {
        return (new LotNumberService($this))->only($lotNumber);
    }

    public function lotcount()
    {
        return (new LotNumberService($this))->count();
    }

    public function getIsInStockAttribute()
    {
        return $this->totalStock['amount'] > 0;
    }

    public function getLastMoveAttribute() // !! buna gerek olmayabilir
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
        if($this->totalStock['amount'] > 0 && $this->totalStock['amount'] < 100) {
            $array = [
                'tr' => 'warning left yellow marked', 
                'icon' => 'exclamation circle icon', 
            ];
            $array['explanation'] = $this->min_threshold
                ? __('inventory.lower_than_count_unit', ['count' => $this->min_threshold, 'unit' => $this->baseUnit->abbreviation])
                : __('inventory.stock_under_100_unit', ['unit' => $this->baseUnit->abbreviation]);
            
        }
        elseif($this->totalStock['amount'] <= 0) 
            $array = [
                'tr' => 'negative left red marked', 
                'icon' => 'exclamation triangle  icon', 
                'explanation' => __('inventory.out_of_stock'),
            ];
        else 
            $array = [
                'tr' => 'positive left green marked', 
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