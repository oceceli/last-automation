<?php

namespace App\Repositories;

use App\Contracts\RoleContract;
use App\Models\Role;

class RoleRepository extends BaseRepository implements RoleContract
{

    public function __construct(Role $model)
    {
        $this->model = $model;
    }
}