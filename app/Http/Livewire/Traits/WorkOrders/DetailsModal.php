<?php

namespace App\Http\Livewire\Traits\WorkOrders;

use App\Models\WorkOrder;

trait DetailsModal
{
    public $detailsModal = false;
    public $modalSelectedWorkOrder;


    public function openDetailsModal($workOrderId)
    {
        $this->detailsModal = true;
        $this->modalSelectedWorkOrder = WorkOrder::find($workOrderId);
    }

    public function updatedDetailsModal($bool)
    {
        if(!$bool) $this->reset('modalSelectedWorkOrder');
    }
}