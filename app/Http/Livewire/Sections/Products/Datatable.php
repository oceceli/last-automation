<?php

namespace App\Http\Livewire\Sections\Products;

use App\Http\Livewire\Datatable as BaseDatatable;
use App\Models\Product;

class Datatable extends BaseDatatable
{

    public $model = Product::class;
    protected $view = 'livewire.sections.products.datatable';


    
}
