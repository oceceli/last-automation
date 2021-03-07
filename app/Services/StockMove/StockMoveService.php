<?php

namespace App\Services\StockMove;

use App\Models\StockMove;

class StockMoveService
{
    // dashboard overview cardda kullanıldı
    public static function getApprovedCountBetween($from, $to)
    {
        return StockMove::whereBetween('created_at', [$from, $to])->manualPositive()->approved()->count();
    }
}