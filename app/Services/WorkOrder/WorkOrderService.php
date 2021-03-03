<?php 

namespace App\Services\WorkOrder;

use App\Models\WorkOrder;
use Carbon\Carbon;

class WorkOrderService
{
    public static function getTodaysList()
    {
        return WorkOrder
            ::where('wo_datetime', Carbon::today())
            ->orWhere('wo_status', 'in_progress')
            ->orderBy('wo_queue', 'asc')
            ->get();
    }


    public static function inProgressCurrently()
    {
        return WorkOrder::where('wo_status', 'in_progress')->first();
    }


    public static function getUniqueWoCodes()
    {
        return WorkOrder::select('wo_code')->distinct()->pluck('wo_code');
    }

    public static function getUniqueWoQueues()
    {
        return WorkOrder::select('wo_queue')->distinct()->pluck('wo_queue');
    }


    public static function getApprovedCountBetween($from, $to)
    {
        return WorkOrder::whereBetween('created_at', [$from, $to])->approved()->count();
    }



    // public static function productSpecific()
    // {

    // }


}