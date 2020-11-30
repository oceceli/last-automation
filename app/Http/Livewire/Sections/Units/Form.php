<?php

namespace App\Http\Livewire\Sections\Units;

use App\Common\Units\Conversions;
use App\Models\Product;
use App\Models\Unit;
use Illuminate\Support\Facades\Validator;
use Livewire\Component;

class Form extends Component
{
    public $view = 'livewire.sections.units.form';

    public $product_id;
    public $selectedProduct;

    public $cards = [];

   
    
    /**
     * Whenever product updated
     */
    public function updatedProductId($id)
    {
        $this->reset('selectedProduct', 'cards');
        $this->selectedProduct = Product::find($id);
        $this->fetchAndPlaceToCards();
    }

    private function fetchAndPlaceToCards()
    {
        $this->cards = $this->selectedProduct->units->toArray();
    }

    /**
     * Determining if the card is locked.
     * 'created_at' gives us a clue about where card filled from (fetch database)
     */
    public function isLocked($key)
    {
        return isset($this->cards[$key]['created_at']);
    }

    /**
     * Unsetting 'created_at' element will unlock the card  
     */
    public function unlockCard($key)
    {
        unset($this->cards[$key]['created_at']);
    }

    public function lockCard($key)
    {
        $this->cards[$key]['created_at'] = '';
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
        $this->reset('cards');
    }

    /**
     * Remove a unit card field
     */
    public function removeCard($key)
    {
        if(array_key_exists('id', $this->cards[$key])) {
            Unit::find($this->cards[$key]['id'])->delete(); // DEVAM soru sor
        }
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

    public function getParentName($key)
    {
        if($unit = $this->selectedProduct->units->find($this->cards[$key]['parent_id']))
            return $unit->name;
    }

    /**
     * Submits the form
     */
    public function submit($index)
    {
        $data = $this->customValidate($index);

        $unit = Unit::create(array_merge($data, ['product_id' => $this->product_id]));

        // swap current card with created one
        if($unit) {
            $this->emit('toast', 'common.saved.title', __('common.context_created', ['model' => __('modelnames.unit')]), 'success');
            unset($this->cards[$index]);
            $this->cards[$index] = $unit->toArray();
        } 
        else $this->emit('toast', 'common.somethings_missing', 'sections/units.please_fulfill_all_fields_carefully', 'error');

    }



    public function customValidate($key)
    {
        $validator = Validator::make($this->cards[$key], [
            'parent_id' => 'required|int|min:0',
            // 'product_id' => 'required|int|min:1',
            'name' => 'required|max:30',
            'abbreviation' => 'required|max:20',
            'operator' => 'required|boolean',
            'factor' => 'required|numeric'
        ]);
        
        if($validator->fails())
            $this->emit('toast', '', $validator->errors()->first(), 'error'); // show errors 

        return $validator->validate();
    }
   
}
