<?php

namespace App\Repositories;

use App\Contracts\UnitContract;
use App\Models\Unit;

class UnitRepository extends BaseRepository implements UnitContract
{

    public function __construct(Unit $model)
    {
        $this->model = $model;
    }
}