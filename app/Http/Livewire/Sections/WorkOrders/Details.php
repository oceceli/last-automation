<?php

namespace App\Http\Livewire\Sections\WorkOrders;

use App\Models\Unit;
use Livewire\Component;

class Details extends Component
{
    // model
    public $workOrder;
    public $productionResults;

    // attribute
    public $status;

    public $statusColor;

    


    public function mount($workOrder)
    {
        $this->workOrder = $workOrder;
        $this->productionResults = $this->workOrder->getProductionResults();

        $this->status = $workOrder->isActive();
        $this->statusColor = $workOrder->statusColor;
        // $this->product = $workOrder->product;
        // $this->unit = Unit::find($workOrder->unit_id);
    }

    public function updatingStatus($value)
    {
        $this->workOrder->setActivation($value);
        $this->statusColor = $this->workOrder->statusColor;
        $value 
            ? $this->emit('toast', '', __('sections/workorders.wo_unsuspended'), 'success')
            : $this->emit('toast', '', __('sections/workorders.wo_suspended'), 'info');
    }


    public function render()
    {
        return view('livewire.sections.workorders.details');
    }
}
