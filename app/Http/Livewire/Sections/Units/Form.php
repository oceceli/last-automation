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

    public $cards = [];


    /**
     * Add a card for new unit assigment
     */
    public function addNewCard()
    {
        $this->cards[] = ['operator' => true, 'factor' => null, 'parent_id' => null, 'name' => null, 'abbreviation' => null, 'locked' => false];
    }

    public function mount()
    {
        $this->addNewCard();
    }


    /**
     * Whenever product updated
     */
    public function updatedProductId($id)
    {
        $this->reset();
        $this->selectedProduct = Product::find($id);
        foreach($this->selectedProduct->units as $unit)
            $this->cards[] = array_merge($unit->toArray(), ['locked' => true]);
    }

    public function isLocked($key)
    {
        return $this->cards[$key]['locked'];
    }

    public function unlockCard($key)
    {
        $this->cards[$key]['locked'] = false;
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
        unset($card['locked']);

        Conversions::addUnit($card) 
            ? $this->emit('toast', 'common.saved.title', __('common.context_created', ['model' => __('modelnames.unit')]), 'success')
            : $this->emit('toast', 'common.somethings_missing', 'sections/units.please_fulfill_all_fields_carefully', 'error');
    }

    // private function ensureCardFulfilled($index)
    // {
    //     $this->validate([
    //         "cards.$index.parent_id" => 'required|int|min:0',
    //         "cards.$index.name" => 'required|max:20',
    //         "cards.$index.abbreviation" => 'required|max:10',
    //         "cards.$index.operator" => 'required|boolean',
    //         "cards.$index.factor" => 'required|numeric',
    //     ]);
    // }


   
}
