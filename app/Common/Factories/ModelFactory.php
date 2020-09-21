<?php

namespace App\Common\Factories;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Str;

class ModelFactory
{

    /**
     * Model files inside of 
     */
    private const modelPath = 'App\Models\\';



    public static function make($class)
    {
        $class = self::modelPath . Str::singular(ucfirst(trim($class)));
        if(class_exists($class))
            return $class;
        throw new ModelNotFoundException($class . ' isimli model bulunamadı!');
        // abort(422, 'Class oluşturma hatası! ' . self::class);
    }




    
}