<?php

namespace App\Http\Livewire\Products;

use App\Models\Product;
use App\Models\Unit;
use Livewire\Component;

class Details extends Component
{
    public $product; 

    
    public function mount(Product $product)
    {
        $this->product = $product;
    }

    public function delete()
    {
        $this->product->delete();
        session()->flash('success', __('common.context_deleted'));

        return redirect()->route('products.index');
    }


    public function render()
    {
        return view('livewire.products.details');
    }
}
