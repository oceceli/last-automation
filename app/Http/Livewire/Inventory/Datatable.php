<?php

namespace App\Http\Livewire\Inventory;

use App\Http\Livewire\SmartTable;
use App\Http\Livewire\Traits\Exportable;
use App\Models\Product;
use Livewire\Component;

class Datatable extends Component
{
    use SmartTable;
    use Exportable;

    public $model = Product::class;
    protected $view = 'livewire.inventory.datatable';


    public $lotModal = false;
    public $selectedProduct;
 
    
    public function showLots($productId)
    {
        $this->selectedProduct = $this->model::find($productId);
        $this->lotModal = true;
    }

    public function updatedLotModal($bool)
    {
        if(!$bool) $this->reset('lotModal', 'selectedProduct');
    }
}
