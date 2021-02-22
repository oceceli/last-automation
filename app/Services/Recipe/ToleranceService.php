<?php

namespace App\Services\Recipe;

use App\Models\Recipe;

class ToleranceService
{
    /**
     * Returns tolerance amount based on product's amount
     */
    public static function toleranceOf(Recipe $recipe, $amount)
    {
        $toleranceFactor = $recipe->tolerance_factor; // !! reçete tablosuna ekle 
        return ($amount * $toleranceFactor) / 100;
    }


    public static function withTolerance(Recipe $recipe, $amount) 
    {
        $tolerance = self::toleranceOf($recipe, $amount);
        return $amount + $tolerance;
    }

}