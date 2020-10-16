<?php

namespace App\Http\Livewire\Sections\Units;

use App\Models\Product;
use Livewire\Component;

class Form extends Component
{

    public $product_id;

    public function getProductsProperty()
    {
        return Product::all();
    }

    public function render()
    {
        return view('livewire.sections.units.form');
    }
}
