<?php

namespace App\Repositories;

use App\Contracts\ProductContract;
use App\Models\Product;

class ProductRepository extends BaseRepository implements ProductContract
{

    public function __construct(Product $model)
    {
        $this->model = $model;
    }
}