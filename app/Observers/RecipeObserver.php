<?php

namespace App\Observers;

use App\Models\Recipe;

class RecipeObserver
{
    public function deleting(Recipe $recipe)
    {
        if(auth()->user()->cannot('delete recipes')) return false;

        // if() // !! devam et,
        if($recipe->usingInAnActiveWorkOrder()) return false;
    }

    public function updating()
    {
        if(auth()->user()->cannot('create update recipes')) return false;
    }
}
