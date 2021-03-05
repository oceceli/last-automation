<?php

namespace App\Services\Dispatch;

use App\Models\DispatchOrder;

class DispatchOrderReportsService
{
    public static function getLiveReports()
    {
        return DispatchOrder::where('do_status', 'in_progress')
            ->orWhere('do_status', 'completed')
            ->get();
    }
}