<?php

namespace App\Http\Livewire\Sections\Units;

use App\Models\Product;
use Livewire\Component;

class Form extends Component
{
    public $view = 'livewire.sections.units.form';

    public $product_id;

    public $selectedProduct;

    public $unit_id;

    public $fromAmount;

    public $unitFields = 5;


    public function updatedProductId($value)
    {
        // $this->reset();
        $this->selectedProduct = Product::find($value);
    }

    public function addNewUnitField()
    {
        $this->unitFields++;
    }

    public function removeAllUnitFields()
    {
        $this->unitFields = 0;
    }

    public function removeUnitField()
    {
        $this->unitFields--;
    }

    public function getProductsProperty()
    {
        return Product::all();
    }

   
}
