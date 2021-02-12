<?php

namespace App\Models;

use App\Models\Traits\ModelHelpers;
use Spatie\Permission\Models\Role as SpatieRoleModel;

class Role extends SpatieRoleModel
{
    use ModelHelpers;

    public function delete()
    {
        if($this->name === 'admin' || $this->name === 'super user') return;

        $this->permissions()->detach();
        $this->users()->detach();

        parent::delete();
    }


    public function isAdmin()
    {
        return $this->name === 'admin' || $this->name === 'super user';
    }


    /**
     * Exclude the 'super user' role
     */
    public static function allExceptSU()
    {
        return self::where('name', '!=', 'super user')->get();
    }

}
