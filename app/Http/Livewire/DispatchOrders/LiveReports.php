<?php

namespace App\Http\Livewire\DispatchOrders;

use App\Models\DispatchOrder;
use App\Services\Dispatch\DispatchOrderReportsService;
use Livewire\Component;

class LiveReports extends Component
{

    public $doDetailsModal = false;
    public $modalSelectedDispatchOrder;

    
    public function openDoDetailsModal($dispatchOrderId)
    {
        $this->doDetailsModal = true;
        $this->modalSelectedDispatchOrder = DispatchOrder::find($dispatchOrderId);
    }

    public function getLiveReportsProperty()
    {
        $dispatchOrder = DispatchOrderReportsService::getLiveReports();
        $arr = [];
        foreach ($dispatchOrder as $dispatchOrder) {
            $arr[] = [
                'dispatchOrder' => $dispatchOrder,
                'status' => $dispatchOrder->statusLookup,
                // ['icon' => 'green double check icon', 'explanation' => __('common.approved')],
            ];
        }
        return $arr;
    }

    public function render()
    {
        return view('livewire.dispatch-orders.live-reports');
    }
}
