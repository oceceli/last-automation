<?php

namespace App\Http\Livewire\Inventory;

use App\Http\Livewire\SmartTable;
use App\Models\Product;
use App\Models\StockMove;
use App\Services\Stock\LotNumberService;
use Livewire\Component;

class Datatable extends Component
{
    use SmartTable;

    public $model = Product::class;
    protected $view = 'livewire.inventory.datatable';


    public $lotModal = false;
    public $selectedProduct;
 
    // public function mount()
    // {
    //     $service = (new LotNumberService(Product::where('code', 'SDYMBKR')->first()));
    //     dd($service->allWithAmounts());
    // }
    
    public function lots($productId)
    {
        $this->selectedProduct = $this->model::find($productId);
        $this->lotModal = true;
    }
}
