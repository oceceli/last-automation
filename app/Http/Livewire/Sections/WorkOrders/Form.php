<?php

namespace App\Http\Livewire\Sections\WorkOrders;

use App\Http\Livewire\Form as BaseForm;
use App\Models\Product;
use App\Models\WorkOrder;
use Carbon\Carbon;

class Form extends BaseForm
{
    public $model = WorkOrder::class;
    public $view = 'livewire.sections.workorders.form';


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
    public $recipeOfSelectedProduct;

    // edit mode
    public $editMode = false;
    public $workOrder;

    public function mount($workOrder = null) 
    {
        if($workOrder) {
            $this->setEditMode($workOrder);
        } else {
            $this->datetime = Carbon::tomorrow()->format('d.m.Y');
        }
    }

    public function updatedProductId($id)
    {
        $this->selectedProduct = Product::find($id); // get it from getProductsProperty 
        $this->emit('woProductChanged'); // fill the units
        $this->recipeOfSelectedProduct = $this->selectedProduct->recipe;

        $this->guessFields($this->selectedProduct);
    }
    

    public function getUnitsProperty()
    {
        if($this->selectedProduct) {
            return $this->selectedProduct->units->toArray();
        }
    }


    public function getProductsProperty()
    {
        return Product::has('recipe')->get()->toArray();
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


    /**
     * Sets the attributes for editing
     */
    public function setEditMode($workOrder)
    {
        $this->editMode = true;
        $this->workOrder = $workOrder;

        $this->product_id = $workOrder->product_id;
        $this->lot_no = $workOrder->lot_no;
        $this->amount = $workOrder->amount;
        $this->datetime = $workOrder->datetime;
        $this->code = $workOrder->code;
        $this->queue = $workOrder->queue;
        // $this->is_active = $workOrder->is_active;
        // $this->in_progress = $workOrder->in_progress;
        $this->note = $workOrder->note;
    }

    // @override
    public function submit()
    {
        $this->create();
        $this->emit('new_work_order_created');
        $this->reset();
    }


}
