<?php

namespace App\Http\Livewire\WorkOrders;

use App\Models\WorkOrder;
use App\Services\WorkOrder\WorkOrderReportsService;
use Livewire\Component;

class LiveReports extends Component
{

    public $woDetailsModal = false;
    public $modalSelectedWorkOrder;

    
    public function openWoDetailsModal($workOrderId)
    {
        $this->woDetailsModal = true;
        $this->modalSelectedWorkOrder = WorkOrder::find($workOrderId);
    }
    

    public function getLiveReportsProperty()
    {
        $workOrders = WorkOrderReportsService::getLiveReports();
        $arr = [];
        foreach ($workOrders as $workOrder) {
            $arr[] = [
                'workOrder' => $workOrder,
                'status' => $workOrder->statusLookup,
                // ['icon' => 'green double check icon', 'explanation' => __('common.approved')],
            ];
        }
        return $arr;
    }

    

    public function render()
    {
        return view('livewire.work-orders.live-reports');
    }
}
