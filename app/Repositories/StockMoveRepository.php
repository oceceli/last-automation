<?php

namespace App\Repositories;

use App\Contracts\StockMoveContract;
use App\Models\StockMove;

class StockMoveRepository extends BaseRepository implements StockMoveContract
{

    public function __construct(StockMove $model)
    {
        $this->model = $model;
    }
}