<?php

namespace App\Http\Livewire\Sections\Inventory;

use App\Http\Livewire\TableHelpers;
use App\Models\Product;
use App\Models\StockMove;
use Livewire\Component;

class Datatable extends Component
{
    use TableHelpers;

    public $model = Product::class;
    protected $view = 'livewire.sections.inventory.datatable';


    public $lotModal = false;
    public $selectedProduct;
 
    
    public function lots($productId)
    {
        $this->selectedProduct = $this->model::find($productId);
        $this->lotModal = true;
    }
}
