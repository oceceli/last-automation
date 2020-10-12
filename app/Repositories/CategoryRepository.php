<?php

namespace App\Repositories;

use App\Contracts\CategoryContract;
use App\Models\Category;

class CategoryRepository extends BaseRepository implements CategoryContract
{

    public function __construct(Category $model)
    {
        $this->model = $model;
    }
}