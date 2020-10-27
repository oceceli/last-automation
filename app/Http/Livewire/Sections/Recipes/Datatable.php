<?php

namespace App\Http\Livewire\Sections\Recipes;

use App\Models\Recipe;
use App\Http\Livewire\Datatable as BaseDatatable;

class Datatable extends BaseDatatable
{

    protected $view = 'livewire.sections.recipes.datatable';

    public $model = Recipe::class;


    public function deleteRecipe($id)
    {
        $this->model::find($id)->delete();
    }
    
}
