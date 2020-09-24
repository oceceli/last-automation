<?php

namespace App\Repositories;

use App\Contracts\RecipeContract;
use App\Models\Recipe;

class RecipeRepository extends BaseRepository implements RecipeContract
{

    public function __construct(Recipe $model)
    {
        $this->model = $model;
    }
}