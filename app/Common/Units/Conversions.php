<?php 

namespace App\Common\Units;

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


    


}