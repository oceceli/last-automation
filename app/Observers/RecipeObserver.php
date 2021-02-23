<?php

namespace App\Observers;

class RecipeObserver
{
    public function deleting()
    {
        if(auth()->user()->cannot('delete recipes')) return false;
    }

    public function updating()
    {
        if(auth()->user()->cannot('create update recipes')) return false;
    }
}
