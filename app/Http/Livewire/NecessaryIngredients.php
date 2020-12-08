<?php

namespace App\Http\Livewire;

use Livewire\Component;

class NecessaryIngredients extends Component
{
    public $product;

    protected $listeners = ['refreshChild' => '$refresh'];

    public function mount($product)
    {
        $this->product = $product;
    }

    public function render()
    {
        return view('livewire.necessary-ingredients');
    }
}
