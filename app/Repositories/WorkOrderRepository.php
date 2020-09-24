<?php

namespace App\Repositories;

use App\Contracts\WorkOrderContract;
use App\Models\WorkOrder;

class WorkOrderRepository extends BaseRepository implements WorkOrderContract
{

    public function __construct(WorkOrder $model)
    {
        $this->model = $model;
    }
}