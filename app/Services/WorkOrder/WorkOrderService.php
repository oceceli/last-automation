<?php 

namespace App\Services\WorkOrder;

use App\Models\WorkOrder;
use Carbon\Carbon;

class WorkOrderService
{
    public static function getTodaysList()
    {
        return WorkOrder
            ::whereDate('wo_datetime', Carbon::today())
            ->orWhere('wo_status', 'completed')
            ->orWhere('wo_status', 'in_progress')
            ->orWhere('wo_status', 'prepared')
            ->orWhere('wo_status', 'preparing')
            ->orderBy('wo_queue', 'asc')
            ->get();
    }

    // return [
    //     'approved',
    //     'completed',
    //     'in_progress',
    //     'prepared',
    //     'preparing',
    //     'active',
    //     'suspended',
    // ];


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