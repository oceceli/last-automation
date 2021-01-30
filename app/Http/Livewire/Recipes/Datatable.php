<?php

namespace App\Http\Livewire\Recipes;

use App\Models\Recipe;
use App\Http\Livewire\SmartTable;
use Livewire\Component;

class Datatable extends Component
{
    use SmartTable;

    protected $alsoSearch = ['product.name'];

    protected $view = 'livewire.recipes.datatable';
    protected $model = Recipe::class;

    
}
