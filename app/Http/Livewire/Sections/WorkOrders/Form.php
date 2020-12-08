<?php

namespace App\Http\Livewire\Sections\WorkOrders;

use App\Common\Facades\Conversions;
use App\Http\Livewire\FormHelpers;
use App\Models\Product;
use App\Models\Unit;
use App\Models\WorkOrder;
use Carbon\Carbon;
use Livewire\Component;

class Form extends Component
{
    use FormHelpers;

    public $view = 'livewire.sections.workorders.form';

    // workorder attributes
    public $product_id;
    public $lot_no;
    public $amount;
    public $datetime;
    public $code;
    public $queue;
    public $status = 'active';
    public $note;

    public $unit_id;

    public $test;

    // comes from dropdown
    public $selectedProduct;

    // is lot stock prefering available?
    public $preferStock = false;
    public $preferredStockCards = [];

    // edit mode
    public $editMode = false;
    public $workOrder;

    public $deleteModal = false;

    protected $rules = [
        'product_id' => 'required|min:1',
        'unit_id' => 'required|min:1',
        'code' => 'required|integer|min:0', // iş emri no
        'lot_no' => 'required',
        'amount' => 'required|numeric|min:0.1',
        'datetime' => 'required|date',
        'queue' => 'required|int|min:0',
        'status' => 'required|max:15',
        'note' => 'nullable',
    ];

    public function mount($workOrder = null) 
    {
        if($workOrder) {
            $this->setEditMode($workOrder);
        } else {
            $this->datetime = Carbon::tomorrow()->format('d.m.Y');
        }
    }

    public function updatingProductId($id)
    {
        if($this->editMode) return;

        $this->reset();
        $this->selectedProduct = Product::find($id); // !!! get it from getProductsProperty
        $this->emit('woProductChanged'); // fill the units

        $this->guessFields($this->selectedProduct);
    }


    public function activatePreferStock()
    {
        $this->preferStock = true;
    }
    

    public function getProductsProperty()
    {
        return Product::has('recipe')->get()->toArray();
    }


    public function getUnitsProperty()
    {
        if($this->productSelected()) {
            return $this->selectedProduct->units->toArray();
        }
    }

    
    // @override
    public function submit()
    {
        dd($this->preferredStockCards);
        $data = $this->validate();

        if($this->workOrder && $this->editMode) {
            $this->workOrder->update($data);
            $this->emit('toast', '', __('common.saved.changes'), 'success');
        } else {
            WorkOrder::create($data);
            $this->emit('toast', '', __('sections/workorders.workorder_saved_successfully'), 'success');
            $this->emit('new_work_order_created');
            $this->reset();
        } 

        $this->setPreferredStocks();
    }

    public function setPreferredStocks()
    {
        
    }

    public function openDeleteModal()
    {
        if($this->editMode)
            $this->deleteModal = true;
    }

    public function confirmDelete()
    {
        if($this->editMode && $this->workOrder) {
            $this->workOrder->delete();
            return redirect()->route('work-orders.index');
        }
    }
    public function updatedDeleteModal($bool)
    {
        !$bool ? $this->deleteModal = false : null;
    }


    public function calculateNeeds($ingredient)
    {
        $convertedIngredient = Conversions::toBase($ingredient->pivot->unit_id, $ingredient->pivot->amount);
        
        if($this->amount && $this->unit_id) {
            $convertedIngredient = Conversions::toBase($ingredient->pivot->unit_id, $ingredient->pivot->amount);
            $selectedProductAmount = Conversions::toBase($this->unit_id, $this->amount)['amount'];

            $result = ['amount' => $selectedProductAmount * $convertedIngredient['amount'], 'unit' => $convertedIngredient['unit']];
            if( ! $ingredient->pivot->literal) $result['amount'] = floor($selectedProductAmount * $convertedIngredient['amount']);

            return $result;
        } 
        
        else return ['amount' => 0, 'unit' => $convertedIngredient['unit']];
    }


    /**
     * Sets the attributes for editing
     */
    public function setEditMode($workOrder)
    {
        $this->editMode = true;
        $this->workOrder = $workOrder;
        $this->selectedProduct = $workOrder->product;


        $this->product_id = $workOrder->product_id;
        $this->lot_no = $workOrder->lot_no;
        $this->amount = $workOrder->amount;
        $this->datetime = $workOrder->datetime;
        $this->code = $workOrder->code;
        $this->queue = $workOrder->queue;
        $this->unit_id = $workOrder->unit_id;
        // $this->is_active = $workOrder->is_active;
        // $this->in_progress = $workOrder->in_progress;
        $this->note = $workOrder->note;
        $this->emit('woProductChanged'); // fill the units

    }



    public function productSelected()
    {
        return ! empty($this->product_id);
    }

    public function redirectForAddIngredients()
    {
        return redirect()->route('recipes.edit', ['recipe' => $this->selectedProduct->recipe]);
    }

    

    public function guessFields($product)
    {
        $latestWO = $product->getLastCreatedWorkOrder();
        $globalWO = WorkOrder::latest()->first();

        if($latestWO) {
            if(is_numeric($latestWO->lot_no)) {
                $this->lot_no = $latestWO->lot_no + 1;
            } else {
                $this->lot_no = substr($latestWO->lot_no, 0, (strlen($latestWO->lot_no) - 2));
            }
    
            $this->amount = $latestWO->amount;
            $this->unit_id = $latestWO->unit_id;
        }
        
        $this->datetime = now();
        if($globalWO) {
            $this->queue = $globalWO->queue + 1;
            $this->code = $globalWO->code;
        }
    }


}
