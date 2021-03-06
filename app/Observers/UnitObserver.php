<?php

namespace App\Observers;

use App\Models\Unit;

class UnitObserver
{
    public function deleting (Unit $unit)
    {
        if($unit->isBase()) return false;
        if($unit->hasChildren()) return false;
        if($unit->isUsedInRecipe()) return false;
        if($unit->isUsedInWorkOrder()) return false;
    }
}
