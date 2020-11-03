<?php 

namespace App\Common\Units;

use App\Models\Unit;
use Illuminate\Support\Facades\Validator;

class Conversions 
{

    const units = [
        ['text' => 'Adet'],
        ['text' => 'Gram'],
        ['text' => 'Cm'],
        ['text' => 'Litre'],
    ];
    
    

    public static function setBaseUnit($product_id, $unitName)
    {
        if(in_array($unitName, array_column(self::units, 'text'))) {
            Unit::create(['name' => $unitName, 'product_id' => $product_id, 'factor' => 1, 'multiplier' => true, 'parent_id' => 0]);
        } else dd("unit kaydedilemedi!");
    }


    public static function addUnit(array $data)
    {
        $validator = Validator::validate($data, Unit::rules()['data']);
        Unit::create($data);
    }


    


}