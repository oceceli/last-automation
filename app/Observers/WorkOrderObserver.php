<?php

namespace App\Observers;

use App\Models\WorkOrder;

class WorkOrderObserver
{
    public function deleting(WorkOrder $workOrder)
    {
        // delete only when workorder is active or suspended
        if( ! ($workOrder->isSuspended() || $workOrder->isActive())) return false;
    }


    public function deleted(WorkOrder $workOrder)
    {
        // $workOrder->reservedStocks()->delete(); // !!! devam edilecek
    }


    public function updating(WorkOrder $workOrder)
    {
        // update only when workorder is active or suspended
        if( ! ($workOrder->isSuspended() || $workOrder->isActive())) return false;
    }


}
