<?php

namespace App\Observers;

use App\Models\DispatchOrder;

class DispatchOrderObserver
{

    // !! eksiklerimiz var

    public function updating(DispatchOrder $dispatchOrder)
    {
        return $dispatchOrder->isSuspended() || $dispatchOrder->isActive();
    }

    public function deleting(DispatchOrder $dispatchOrder)
    {
        return $dispatchOrder->isSuspended() || $dispatchOrder->isActive();
    }
    


}
