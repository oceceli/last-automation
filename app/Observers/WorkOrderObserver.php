<?php

namespace App\Observers;

use App\Models\WorkOrder;

class WorkOrderObserver
{
    public function deleting(WorkOrder $workOrder)
    {
        // delete only when workorder is active or suspended
        return $workOrder->isSuspended() || $workOrder->isActive();

    }


    public function deleted(WorkOrder $workOrder)
    {
        // $workOrder->reservedStocks()->delete(); // !!! devam edilecek
    }


    public function updating(WorkOrder $workOrder)
    {
        // update only when workorder is active or suspended
        return $workOrder->isSuspended() || $workOrder->isActive();
    }


}
