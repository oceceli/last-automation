<?php 

namespace App\Common\Units;

use App\Common\Factories\Instantiator;
use App\Models\Product;
use App\Models\Unit;

class Conversions 
{

    const units = [
        ['id' => 1, 'name' => 'Adet', 'abbreviation' => 'adet'],
        ['id' => 2, 'name' => 'Kilogram', 'abbreviation' => 'kg'],
        ['id' => 3, 'name' => 'Santimetre', 'abbreviation' => 'cm'],
        ['id' => 4, 'name' => 'Litre', 'abbreviation' => 'lt'],
    ];
    
    

    public static function setBaseUnit($product_id, $unit_id)
    {
        array_map(function($index) use ($product_id, $unit_id){
            if($index['id'] == $unit_id) {
                Unit::create(['name' => $index['name'], 'abbreviation' => $index['abbreviation'], 'product_id' => $product_id, 'factor' => 1, 'operator' => true, 'is_base' => true]);
                return true;
            }
        }, self::units);
    }



    /**
     * Convert given unit to product's base unit. 
     */
    // private static function converttttt($product_id, $unit_id, $amount)
    // {
    //     $product = Product::find($product_id);
    //     $unitsOfProduct = $product->units;
    //     if( ! $unit = $unitsOfProduct->find($unit_id))
    //         dd('verilen birim bu ürüne ait değil!');
        
    // }


    public static function toBase($unit, $amount = 1)
    {
        if( ! $unit instanceof Unit && is_numeric((int)$unit))
            $unit = Instantiator::make('unit', $unit);

        if($unit->isBase()) {
            return self::output($unit, $amount);
        }

        $parent = $unit->parent;
        $convertedAmount = $unit->operator 
            ? $amount * $unit->factor
            : $amount / $unit->factor;
        
        return self::toBase($parent, $convertedAmount);
    }



    public static function convert($amount, $from, $target)
    {
        if( ! $from instanceof Unit && is_numeric($from))
            $from = Instantiator::make('unit', $from);
        if( ! $target instanceof Unit && is_numeric($target))
            $target = Instantiator::make('unit', $target);


        $fromBase = self::toBase($from, $amount);
        $targetBase = self::toBase($target);
        
        $convertedAmount = ! $target->isBase()
            ? $fromBase['amount'] / $targetBase['amount']
            : $fromBase['amount'];

        return self::output($target, $convertedAmount);

        // dd($convertedAmount . ' ' . $targetBase['unit']->name); 
    }

    public static function output($unit, $amount)
    {
        return ['unit' => $unit, 'amount' => $amount];
    }

    

    


}