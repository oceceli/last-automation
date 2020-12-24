<?php

namespace App\Http\Livewire\Sections\Products;

use App\Http\Livewire\SmartTable;
use App\Models\Product;
use Livewire\Component;

class Datatable extends Component
{

    use SmartTable;

    protected $alsoSearch = [
        'category.ctg_name', 'category.id',
    ];

    public $model = Product::class;
    protected $view = 'livewire.sections.products.datatable';


    
    
}
