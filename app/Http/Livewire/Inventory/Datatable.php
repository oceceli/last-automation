<?php

namespace App\Http\Livewire\Inventory;

use App\Http\Livewire\SmartTable;
use App\Models\Product;
use App\Models\StockMove;
use Livewire\Component;

class Datatable extends Component
{
    use SmartTable;

    public $model = Product::class;
    protected $view = 'livewire.inventory.datatable';


    public $lotModal = false;
    public $selectedProduct;
 
    
    public function lots($productId)
    {
        $this->selectedProduct = $this->model::find($productId);
        $this->lotModal = true;
    }
}
