<?php

namespace App\Services\Dispatch;

use App\Models\DispatchOrder;
use Carbon\Carbon;

class DispatchService
{
    public static function getDaily()
    {
        return DispatchOrder // !! burayı geliştir
            ::where('do_datetime', Carbon::today()->format('d.m.Y'))
            ->orWhere('status', 'active')
            ->orWhere('status', 'completed')
            ->get();
    }
}