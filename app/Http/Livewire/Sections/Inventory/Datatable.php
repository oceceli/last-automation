<?php

namespace App\Http\Livewire\Sections\Inventory;

use App\Common\Facades\StockCalculations;
use App\Http\Livewire\Datatable as BaseDatatable;
use App\Models\Product;
use App\Models\StockMove;

class Datatable extends BaseDatatable
{
    public $model = StockMove::class;
    protected $view = 'livewire.sections.inventory.datatable';


    public $stocks;
    public $products;


    public function mount()
    {
        // dump(StockCalculations::test());
        // $this->stocks = StockCalculations::total();
        // dd($this->stocks);
        $this->products = Product::all();
    }
}
