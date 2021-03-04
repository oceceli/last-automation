<?php

namespace App\Services\WorkOrder;

use App\Models\WorkOrder;

class WorkOrderReportsService 
{
    public static function getLiveReports()
    {
        return WorkOrder::where('wo_status', 'preparing')
            ->orWhere('wo_status', 'prepared')
            ->orWhere('wo_status', 'in_progress')
            ->orWhere('wo_status', 'completed')
            ->get();
    }
}
