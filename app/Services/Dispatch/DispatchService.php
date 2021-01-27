<?php

namespace App\Services\Dispatch;

use App\Models\DispatchOrder;
use Carbon\Carbon;

class DispatchService
{
    public static function getDaily()
    {
        return DispatchOrder
            ::where([
                'do_datetime' => Carbon::today()->format('d.m.Y'),
                'status' => 'active',
            ])
            ->get();
    }
}