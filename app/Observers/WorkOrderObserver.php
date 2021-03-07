<?php

namespace App\Observers;

use App\Models\WorkOrder;

class WorkOrderObserver
{
    public function deleting(WorkOrder $workOrder)
    {
        // delete only when workorder is active, suspended or approved
        return $workOrder->canBeDeleted();

    }


    public function deleted(WorkOrder $workOrder)
    {
        if($workOrder->isApproved()) {
            $workOrder->stockMoves()->delete();
        }
        // $workOrder->reservedStocks()->delete(); // ?? approve olduğunda zaten siliniyor
    }


    public function updating(WorkOrder $workOrder)
    {
        // update only when workorder is active or suspended
        return $workOrder->canBeUpdated();
    }


}
