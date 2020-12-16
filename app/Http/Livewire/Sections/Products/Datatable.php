<?php

namespace App\Http\Livewire\Sections\Products;

use App\Http\Livewire\Table;
use App\Models\Product;
use Livewire\Component;

class Datatable extends Component
{
    use Table;

    public $model = Product::class;
    protected $view = 'livewire.sections.products.datatable';


    
    
}
