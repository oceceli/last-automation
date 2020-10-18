<?php

namespace App\Http\Livewire\Sections\Units;

use App\Models\Product;
use Livewire\Component;

class Form extends Component
{

    public $product_id;

    public $selectedProduct;

    public $unit_id;

    public $fromAmount;


    public function updatedProductId($value)
    {
        // $this->reset();
        $this->selectedProduct = Product::find($value);
    }



    public function getProductsProperty()
    {
        return Product::all();
    }

    public function render()
    {
        return view('livewire.sections.units.form');
    }
}
