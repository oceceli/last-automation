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
    public $backupCards = [];

    public $askModal = false;

   
    

    /**
     * Whenever product updated
     */
    public function updatedProductId($id)
    {
        $this->reset('selectedProduct', 'cards', 'backupCards');
        $this->backupCards = [];
        $this->cards = [];

        $this->selectedProduct = Product::find($id);

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
        $this->backupCards[" $key"] = $this->cards[$key];
        unset($this->cards[$key]['created_at']); // unlock
    }

    public function lockCard($key)
    {
        // dd($this->backupCards);
        //lock card 
        $this->cards[$key]['created_at'] = $this->backupCards[" $key"]['created_at'];

        // if something changed
        if($this->cards[$key] != $this->backupCards[" $key"]) {
            $this->askModal = true;
        }
    }

    public function cancelModal($key)
    {
        $this->cards[$key] = $this->backupCards[" $key"];
        $this->backupCards = [];

        $this->askModal = false;
    }


    /**
     * Add a card for new unit assigment
     */
    public function addNewCard()
    {
        $this->cards[] = ['operator' => true, 'factor' => null, 'parent_id' => null, 'name' => null, 'abbreviation' => null];
    }
    

    /**
     * Remove a unit card field
     */
    public function removeCard($key)
    {
        if(array_key_exists('id', $this->cards[$key])) {

            $unit = $this->selectedProduct->units->find($this->cards[$key]['id']);
            $result = $unit->delete();

            if($result['type'] == 'success') {
                $this->emit('toast', __('common.delete'), $result['message'], 'success');
                unset($this->cards[$key]);
            } else {
                $this->emit('toast', __('common.unable_to_delete'), $result['message'], 'error');
            }
        } else {
            unset($this->cards[$key]);
        }
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
        if($this->cards[$key]['parent_id'] == 0) {
            return __('common.base');
        } else {
            if($unit = $this->selectedProduct->units->find($this->cards[$key]['parent_id']));
                 return $unit->name;
        }
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
