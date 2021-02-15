<?php

namespace App\Observers;

use App\Models\WorkOrder;

class WorkOrderObserver
{
    public function deleting(WorkOrder $workOrder)
    {
        if($workOrder->isInProgress()) return false;

        $workOrder->reservedStocks()->delete(); // !!! devam edilecek
        
        if($workOrder->isCompleted()) {
            $workOrder->stockMoves()->delete();
        }
    }
}
