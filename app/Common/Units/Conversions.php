<?php 

namespace App\Common\Units;

use App\Models\Unit;
use Illuminate\Support\Facades\Validator;

class Conversions 
{

    const units = [
        'Adet',
        'Gram',
        'Cm',
        'Litre',
    ];
    
    

    public static function setBaseUnit($product_id, $unitName)
    {
        if(in_array($unitName, self::units)) {
            Unit::create(['name' => $unitName, 'product_id' => $product_id, 'factor' => 1, 'multiplier' => true, 'parent_id' => 0]);
        }
    }


    public static function addUnit(array $data)
    {
        $validator = Validator::validate($data, Unit::rules()['data']);
        Unit::create($data);
    }


    


}