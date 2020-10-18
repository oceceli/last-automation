<?php 

namespace App\Common\Units;

use App\Models\Unit;

class Conversions 
{

    const units = [
        'Adet',
        'Gram',
        'Cm',
        'Litre',
    ];
    
    

    public static function initUnit($product_id, $unitName)
    {
        if(in_array($unitName, self::units)) {
            Unit::create(['name' => $unitName, 'product_id' => $product_id, 'multiplier' => 1, 'parent_id' => 0]);
        }
    }


    


}