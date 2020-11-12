<?php

namespace App\Common\Factories;

class Instantiator
{
    public static function make($model, $id)
    {
        $modelPath = ModelFactory::make($model);
        if ($instance = $modelPath::find($id)) {
            return $instance;
        } else {
            abort(422, 'Verilen main id\'ye ait instance oluÅŸturulamadÄ±!');
        }
    }

}
