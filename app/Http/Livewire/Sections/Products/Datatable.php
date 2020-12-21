<?php

namespace App\Http\Livewire\Sections\Products;

use App\Http\Livewire\TableHelpers;
use App\Models\Product;
use Livewire\Component;

class Datatable extends Component
{

    use TableHelpers;

    public $model = Product::class;
    protected $view = 'livewire.sections.products.datatable';


    
    
}
