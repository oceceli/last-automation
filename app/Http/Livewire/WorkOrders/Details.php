<?php

namespace App\Http\Livewire\WorkOrders;

use App\Models\Unit;
use App\Models\WorkOrder;
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

    // public function updatingStatus($value) // !! düzenlenecek
    // {
    //     $this->workOrder->setActivation($value);
    //     $this->statusColor = $this->workOrder->statusColor;
    //     $value 
    //         ? $this->emit('toast', '', __('sections/workorders.wo_unsuspended'), 'success')
    //         : $this->emit('toast', '', __('sections/workorders.wo_suspended'), 'info');
    // }

    public function getInProductionProperty()
    {
        return WorkOrder::inProgressCurrently();
    }


    public function render()
    {
        return view('livewire.work-orders.details');
    }
}
