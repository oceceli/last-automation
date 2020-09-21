<?php

namespace App\Common\Factories;

class Instantiator
{
    public static function make($model, $ID)
    {
        $modelPath = ModelFactory::make($model);
        if ($instance = $modelPath::find($ID)) {
            return $instance;
        } else {
            abort(422, 'Verilen main ID\'ye ait instance oluÅŸturulamadÄ±!');
        }
    }

}
