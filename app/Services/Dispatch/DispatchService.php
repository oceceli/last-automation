<?php

namespace App\Services\Dispatch;

use App\Models\DispatchOrder;
use Carbon\Carbon;

class DispatchService
{
    public static function getDaily()
    {
        return DispatchOrder // !! burayı geliştir
            ::where('do_planned_datetime', Carbon::today())
            ->orWhere('do_status', 'completed')
            ->orWhere('do_status', 'in_progress')
            ->orWhere('do_status', 'active')
            ->orWhere('do_status', 'suspended')
            ->get();
    }
}

// 'approved',
// 'completed',
// 'in_progress',
// 'active',
// 'suspended',