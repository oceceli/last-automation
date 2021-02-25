<?php

namespace App\Http\Livewire\Products;

use Livewire\Component;

class DetailsComponent extends Component
{
    public $product;

    public function __construct($product)
    {
        $this->product = $product;
    }


    public function tabDefinition()
    {
        // dd("tabDetails");
    }
    
    public function tabStocks()
    {
        // dd("stok");
    }
    
    public function tabProduction()
    {
        // dd("production");
    }

    public function tabDispatch()
    {
        // dd("dispatch");
    }
    

    public function render()
    {
        return view('livewire.products.details-component');
    }
}
