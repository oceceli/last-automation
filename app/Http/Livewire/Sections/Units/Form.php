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

    public $cards = [];


    protected $rules = [
        'cards.*.parent_id' => 'required|int|min:0',
        // 'cards.*.product_id' => 'required|int|min:1',
        'cards.*.name' => 'required|max:30',
        'cards.*.abbreviation' => 'required|max:10',
        'cards.*.operator' => 'required|boolean',
        'cards.*.factor' => 'required|numeric'
    ];

    
    /**
     * Add a card for new unit assigment
     */
    public function addNewCard()
    {
        $this->cards[] = ['operator' => true, 'factor' => null, 'parent_id' => null, 'name' => null, 'abbreviation' => null, 'locked' => false];
    }


    /**
     * Whenever product updated
     */
    public function updatedProductId($id)
    {
        // $this->reset('cards', 'product_id', 'selectedProduct');
        $this->selectedProduct = Product::find($id);
        $this->fetchAndPlaceToCards();
    }

    private function fetchAndPlaceToCards()
    {
        $this->reset('cards');
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
        $this->validate();
        $card = $this->cards[$index];

            
        $unit = Unit::create([
            'product_id' => $this->selectedProduct->id, 
            'operator' => $card['operator'], 
            'factor' => $card['factor'], 
            'parent_id' => $card['parent_id'], 
            'name' => $card['name'], 
            'abbreviation' => $card['abbreviation']
        ]);

        if($unit) {
            $this->emit('toast', 'common.saved.title', __('common.context_created', ['model' => __('modelnames.unit')]), 'success');
            unset($this->cards[$index]);
            $this->cards[$index] = array_merge($unit->toArray(), ['locked' => true]);
        } else $this->emit('toast', 'common.somethings_missing', 'sections/units.please_fulfill_all_fields_carefully', 'error');

    }
   
}
