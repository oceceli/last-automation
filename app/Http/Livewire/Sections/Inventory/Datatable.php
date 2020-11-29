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


    public $products;

    public $lotModal = false;
    public $selectedProduct;
 

    public function mount()
    {
        $this->products = Product::all();
    }
    
    public function showLotsOf($productId)
    {
        $this->selectedProduct = $this->products->find($productId);
        $this->lotModal = true;
    }
}
