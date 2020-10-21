<?php

namespace App\Http\Livewire\Sections\Units;

use App\Common\Units\Conversions;
use App\Models\Product;
use App\Models\Unit;
use Livewire\Component;

class Form extends Component
{
    public $view = 'livewire.sections.units.form';

    public $product_id;

    public $selectedProduct;

    public $unitFields = [
        ['multiplier' => true, 'factor' => null, 'parent_id' => null, 'name' => null],
    ];


    public function updatedProductId($id)
    {
        // $this->reset();
        $this->selectedProduct = Product::find($id);
    }

    public function addNewUnitField()
    {
        $this->unitFields[] = ['multiplier' => true, 'factor' => null, 'parent_id' => null, 'name' => null];
    }

    public function removeAllUnitFields()
    {
        $this->unitFields = [];
    }

    public function removeUnitField($key)
    {
        unset($this->unitFields[$key]);
    }

    public function toggleMultiplier($key)
    {
        $this->unitFields[$key]['multiplier'] = ! $this->unitFields[$key]['multiplier'];
    }

    public function getProductsProperty()
    {
        return Product::all();
    }

    public function submit($index)
    {
        $unitField = $this->unitFields[$index];
        $unitField['product_id'] = $this->selectedProduct->id;
        // if($unitField['parent_id'] == null) $unitField['parent_id'] = 0;

        Conversions::addUnit($unitField); 
    }


   
}
