<?php

namespace App\Http\Livewire\Sections\Products;

use App\Models\Product;
use App\Models\Unit;
use Livewire\Component;

class Details extends Component
{
    public $product; 

    public $recipe;

    public $baseUnit;

    
    public function mount(Product $product)
    {
        if($product->recipe()->exists()) {
            $this->recipe = $product->recipe;
        }
        $this->baseUnit = Unit::getBaseUnit($product->id);
    }

    public function delete()
    {
        if($this->product->delete()) {
            $this->emit('toast', 'crud.deleted', 'crud.content_deleted_smoothly', 'info');
        } else {
            $this->emit('toast', 'crud.unable_to_delete', 'crud.something_happened_while_deleting_the_content', 'error');
        }
    }


    public function render()
    {
        return view('livewire.sections.products.details');
    }
}
