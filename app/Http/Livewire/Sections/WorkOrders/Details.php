<?php

namespace App\Http\Livewire\Sections\WorkOrders;

use App\Models\Unit;
use Livewire\Component;

class Details extends Component
{
    // model
    public $workOrder;

    // attribute
    public $is_active;

    // relational
    public $product;
    // public $unit;

    


    public function mount($workOrder)
    {
        $this->workOrder = $workOrder;
        $this->is_active = $workOrder->is_active;
        $this->product = $workOrder->product;
        // $this->unit = Unit::find($workOrder->unit_id);
    }

    public function updatingIsActive($value)
    {
        // if work order is not completed, then should change the is_active column // backend security
        if($this->workOrder->isNotCompleted() && is_bool($value)) {
            $this->workOrder->update(['is_active' => $value]);
            $value 
                ? $this->emit('toast', '', __('sections/workorders.wo_unsuspended'), 'success')
                : $this->emit('toast', '', __('sections/workorders.wo_suspended'), 'info');
        }
        
    }

    public function render()
    {
        return view('livewire.sections.workorders.details');
    }
}
