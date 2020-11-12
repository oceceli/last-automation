<?php 

namespace App\Common\Units;

use App\Common\Factories\Instantiator;
use App\Models\Product;
use App\Models\Unit;
use Illuminate\Support\Facades\Validator;

class Conversions 
{

    const units = [
        ['id' => 1, 'name' => 'Adet', 'abbreviation' => 'adet'],
        ['id' => 2, 'name' => 'Gram', 'abbreviation' => 'gr'],
        ['id' => 3, 'name' => 'Santimetre', 'abbreviation' => 'cm'],
        ['id' => 4, 'name' => 'Litre', 'abbreviation' => 'lt'],
    ];
    
    

    public static function setBaseUnit($product_id, $unit_id)
    {
        array_map(function($index) use ($product_id, $unit_id){
            if($index['id'] == $unit_id) {
                Unit::create(['name' => $index['name'], 'abbreviation' => $index['abbreviation'], 'product_id' => $product_id, 'factor' => 1, 'operator' => true, 'parent_id' => 0]);
                return true;
            }
        }, self::units);
    }


    public static function addUnit(array $data)
    {
        try {
            Validator::validate($data, Unit::rules()['data']); 
        } catch (\Throwable $th) {
            return false;
        }        
        Unit::create($data);
    }

    /**
     * Convert given unit to product's base unit. 
     */
    private static function converttttt($product_id, $unit_id, $amount)
    {
        // find product
        // get units of product 
        // ask if given unit belongs to that product; if it's not, return @error 
        // find given unit
        // get product's base unit ($product->units ... parent 0)
        // ask if given unit is already base of the product, if so @return it as is.
        $product = Product::find($product_id);
        $unitsOfProduct = $product->units;
        if( ! $unit = $unitsOfProduct->find($unit_id))
            dd('verilen birim bu ürüne ait değil!');
        
    }


    public static function toBase($amount, $unit)
    {
        if($unit->isBase()) {
            return ['unit' => $unit, 'amount' => $amount];
        }

        $parent = $unit->parent;
        $newAmount = $unit->operator 
            ? $amount * $unit->factor
            : $amount / $unit->factor;
        
        return self::toBase($newAmount, $parent);
    }



    public static function convert($amount, $from, $to)
    {
        if( ! $from instanceof Unit)
            $from = Instantiator::make('unit', $from);
        if( ! $to instanceof Unit)
            $to = Instantiator::make('unit', $to);


        $from_toBase = self::toBase($amount, $from);
        $to_toBase = self::toBase(1, $to);

        $result = $to_toBase['amount'] / $from_toBase['amount'];

        dd($result . ' ' . $to->name); 
    }

    

    


}