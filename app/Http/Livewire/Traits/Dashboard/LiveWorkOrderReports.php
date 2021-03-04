<?php

namespace App\Http\Livewire\Traits\Dashboard;

use App\Services\WorkOrder\WorkOrderReportsService;

trait LiveWorkOrderReports
{
    public function getWorkOrderLiveReportsProperty()
    {
        $workOrders = WorkOrderReportsService::getLiveReports();
        foreach ($workOrders as $workOrder) {
            $arr[] = [
                'workOrder' => $workOrder,
                'status' => $workOrder->statusLookup,
                // ['icon' => 'green double check icon', 'explanation' => __('common.approved')],
            ];
        }
        return $arr;
    }
}