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

    // public $unitFields = 5;
    public $unitFields = [
        ['multiplier' => 'times', 'amount' => null, 'fromUnit' => null], 
        ['multiplier' => 'divide', 'amount' => null, 'fromUnit' => null],
    ];

    // public $multiplier = 'times';


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

    public function toggleMultiplier($key)
    {
        if($this->unitFields[$key]['multiplier'] === 'times') {
            $this->unitFields[$key]['multiplier'] = 'divide';
        } else {
            $this->unitFields[$key]['multiplier'] = 'times';
        }
    }

    public function getProductsProperty()
    {
        return Product::all();
    }

   
}
