<?php

namespace App\Http\Livewire\Sections\Recipes;

use App\Models\Recipe;
use App\Http\Livewire\TableHelpers;
use Livewire\Component;

class Datatable extends Component
{
    use TableHelpers;

    protected $view = 'livewire.sections.recipes.datatable';

    public $model = Recipe::class;

    
}
