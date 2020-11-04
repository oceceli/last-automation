<?php

namespace App\Http\Livewire\Sections\Units;

use App\Common\Units\Conversions;
use App\Models\Product;
use Livewire\Component;

class Form extends Component
{
    public $view = 'livewire.sections.units.form';

    public $product_id;

    public $selectedProduct;

    public $cards = [
        ['operator' => true, 'factor' => null, 'parent_id' => null, 'name' => null, 'abbreviation' => null],
    ];

    /**
     * Whenever product updated
     */
    public function updatedProductId($id)
    {
        $this->reset();
        $this->selectedProduct = Product::find($id);
    }

    /**
     * Add a card for new unit assigment
     */
    public function addNewCard()
    {
        $this->cards[] = ['operator' => true, 'factor' => null, 'parent_id' => null, 'name' => null, 'abbreviation' => null];
    }

    /**
     * Remove all cards
     */
    public function removeAllCards()
    {
        $this->cards = [];
    }

    /**
     * Remove specified unit card field
     */
    public function removeCard($key)
    {
        unset($this->cards[$key]);
    }

    /**
     * Toggles the operator
     */
    public function toggleOperator($key)
    {
        $this->cards[$key]['operator'] = ! $this->cards[$key]['operator'];
    }

    /**
     * Get all products for unit assigment 
     */
    public function getProductsProperty()
    {
        return Product::all()->toArray();
    }

    /**
     * Submits the form
     */
    public function submit($index)
    {
        $card = $this->cards[$index];
        $card['product_id'] = $this->selectedProduct->id;

        Conversions::addUnit($card); 
        $this->emit('toast', 'common.saved.title', __('common.context_created', ['model' => __('modelnames.unit')]), 'success');
    }


   
}
