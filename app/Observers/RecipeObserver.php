<?php

namespace App\Observers;

class RecipeObserver
{
    public function deleting(Recipe $recipe)
    {
        if(auth()->user()->cannot('delete recipes')) return false;

        // if() // !! devam et,
    }

    public function updating()
    {
        if(auth()->user()->cannot('create update recipes')) return false;
    }
}
