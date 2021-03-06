<?php

namespace App\Http\Livewire\Units;

use App\Common\Units\Conversions;
use App\Models\Product;
use App\Models\Unit;
use Illuminate\Support\Facades\Validator;
use Livewire\Component;

class Form extends Component
{
    public $view = 'livewire.units.form';

    public $product_id;
    public $selectedProduct;

    public $cards = [];
    public $backupCards = [];

    public $questionModal = false;
    public $editingCardKey; // for modal to know which card is it 

    public $confirmModal = false;
    public $deletingCardKey;

   
    public function mount()
    {
        // $unit = Unit::find(1); 
        // dd($unit->hasDescendant(41));
    }


    /**
     * Whenever product is updating
     */
    public function updatingProductId($id)
    {
        $this->reset('selectedProduct', 'cards', 'backupCards', 'questionModal', 'editingCardKey', 'confirmModal', 'deletingCardKey');

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
        // get a copy of card for comparison with original, in case if user try to lock the card after doing some changes
        $this->backupCards["wire$key"] = $this->cards[$key]; 

        // unlock the card
        unset($this->cards[$key]['created_at']);
    }


    /**
     * Lock the card so it will be non-editable 
     */
    public function lockCard($key)
    {
        $this->equalizeCreatedAts($key);

        // if something changed in the card, ask user to save or discard changes
        if($this->cards[$key] != $this->backupCards["wire$key"]) {
            $this->askForSaveEditedFields($key);
        } 
        else {
            $this->unsetBackup($key); // expel the backup as no need it anymore
        }
    }

    private function unsetBackup($key)
    {
        unset($this->backupCards["wire$key"]);
    }


    /**
     * Open modal and ask if user wants to save changes
     */
    public function askForSaveEditedFields($key)
    {
        $this->questionModal = true;
        $this->editingCardKey = $key;
    }

    /**
     * If user don't want to save changes, restore the card from backup
     */
    public function modalCancel()
    {
        $key = $this->editingCardKey;

        // restore card
        $this->cards[$key] = $this->backupCards["wire$key"];

        // toss backup 
        unset($this->backupCards["wire$key"]);

        // close the modal 
        $this->questionModal = false;
    }


    /**
     * If user choosed to save changes, push new data to database and close the modal 
     */
    public function modalSaveEdited()
    {
        $this->submit($this->editingCardKey);
        $this->questionModal = false;
    }

    /**
     * If modal closed in any way, behave user clicked at "cancel" 
     */
    public function updatedQuestionModal($value)
    {
        if($value === false) $this->modalCancel();
    }


    /**
     * Add a card for new unit assignment
     */
    public function addNewCard()
    {
        $this->cards[] = ['operator' => true, 'factor' => null, 'parent_id' => null, 'name' => null, 'abbreviation' => null];
    }
    

    public function callDeleteModal($key)
    {
        if($this->isSavedBefore($key)) {
            $this->deletingCardKey = $key; 
            $this->confirmModal = true;
        } else {
            unset($this->cards[$key]);
        }
    }


    /**
     * Delete a unit and unset the card
     */
    public function confirmDelete()
    {
        $key = $this->deletingCardKey;
        if(array_key_exists('id', $this->cards[$key])) {
            $unit = $this->selectedProduct->units->find($this->cards[$key]['id']);
            if($unit->delete()) {
                unset($this->cards[$key]);
                $this->emit('toast', '', __('common.context_deleted'), 'success');
            } else {
                $this->lockCard($key);
                $this->emit('toast', '', __('common.unable_to_delete'), 'warning');
            }

            // if($result['type'] == 'success') {
            //     $this->emit('toast', __('common.delete'), $result['message'], 'success');
            //     unset($this->cards[$key]);
            // } else {
            //     $this->lockCard($key);
            //     $this->emit('toast', __('common.unable_to_delete'), $result['message'], 'warning');
            // }
        } else {
            unset($this->cards[$key]);
        }
        // unset($this->backupCards["wire$key"]);
        $this->unsetBackup($key);
        $this->confirmModal = false;
    }

    public function denyDelete()
    {
        // $this->deletingCardKey = null;
        // $this->confirmModal = false;
        // $this->lockCard($key);
        // unset($this->backupCards["wire$key"]);
    }

    public function updatedConfirmModal($value)
    {
        if($value === false)
            $this->denyDelete();
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
     * Get units to be parent which is not includes itself 
     * Will be used for dropdown
     */
    public function unitsOfSelectedProduct($key)
    {
        // get units of selected product 
        $units = $this->selectedProduct->units;
        $currentUnit = $this->initiateUnit($key);

        // discard the unit from collection so the unit will not be parent to itself or child to children 
        if($this->isSavedBefore($key)) {
            $units = $units->reject(function($unit) use ($currentUnit) {
                return $unit->id == $currentUnit->id || $currentUnit->hasDescendant($unit);
            });
        }

        return $units;
    }


    public function isBaseUnit($key)
    {
        $unit = $this->initiateUnit($key);
        return $unit ? $unit->isBase() : false;
    }

    // public function hasChildren($key)
    // {
    //     $unit = $this->initiateUnit($key);
    //     return $unit ? $unit->hasChildren() : false;
    // }


    public function getParentName($key)
    {
        if($this->cards[$key]['parent_id'] == 0) {
            return __('common.base');
        } else {
            if($unit = $this->selectedProduct->units->find($this->cards[$key]['parent_id']));
                 return $unit->name;
        }
    }

    public function initiateUnit($key)
    {
        if($this->isSavedBefore($key)) {
            return $this->selectedProduct->units->find($this->cards[$key]['id']);
        }
    }

    
    /**
     * Is a card has an id key. If it does, that means it saved before
     */
    public function isSavedBefore($key)
    {
        return array_key_exists('id', $this->cards[$key]);
    }


    private function equalizeCreatedAts($key)
    {
        $this->cards[$key]['created_at'] = $this->backupCards["wire$key"]['created_at'];
    }

    private function backupExistsFor($key)
    {
        return isset($this->backupCards["wire$key"]);
    }

    /**
     * Submits the form
     */
    public function submit($key)
    {
        // if nothing changed, do not push exact data to database | editing case 
        if($this->backupExistsFor($key)) {
            $this->equalizeCreatedAts($key);
            if($this->backupCards["wire$key"] == $this->cards[$key]) 
                return $this->unsetBackup($key);
        }

        // validate first
        $data = $this->customValidate($key);
        

        // If ID exists in the card, it means it should be updated
        if($this->isSavedBefore($key)) {

            $unit = $this->initiateUnit($key);

            // update unless unit is not base 
            if(!$unit->isBase()) $unit->update($data);

            $this->emit('toast', 'güncellendi', 'başarılı falan', 'success');
            
        } 
        // if no ID inside card create a new unit for selected product 
        else {
            $unit = Unit::create(array_merge($data, ['product_id' => $this->product_id]));
            $this->emit('toast', 'common.saved.title', __('common.context_created', ['model' => __('modelnames.unit')]), 'success');
        }

        // swap editable card with newly added unit entry 
        unset($this->cards[$key]);
        $this->cards[$key] = $unit->toArray();

        // close the modal and toss out backup data
        $this->askModal = false;
        unset($this->backupCards["wire$key"]);
    }



    /**
     * Create a validator to validate only a card at a time
     */
    public function customValidate($key)
    {
        $validator = Validator::make($this->cards[$key], [
            'parent_id' => 'required|int|min:1',
            // 'product_id' => 'required|int|min:1',
            'name' => 'required|max:30',
            'abbreviation' => 'required|max:20',
            'operator' => 'required|boolean',
            'factor' => 'required|numeric'
        ]);
        
        // assist user to correct mistakes 
        if($validator->fails()) {
            $this->questionModal = false;
            $this->emit('toast', '', $validator->errors()->first(), 'warning'); // show errors 
        }

        // return validated data 
        return $validator->validate();
    }
   
}
