<?php

namespace App\Models\Traits;

use App\Role;

/**
 * Spatie permissions kullanılacak
 */
trait HasRolesYEDEK
{

    protected $assignedRoles;


    /**
     * A user can have multiple Roles
     */
    public function roles()
    {
        return $this->belongsToMany(Role::class)->withTimestamps();
    }

    /**
     * Return all given attributes
     * @param string $attr
     */
    public function allRoles(string $attr)
    {
        if($this->hasAnyRoles()) {
            foreach($this->roles as $role) {
                $array[] = $role->$attr;
            }
            return $array;
        }
    }


    /**
     * Check if user has any role.
     */
    public function hasAnyRoles()
    {
        return $this->roles()->exists();
    }


    /**
     * Assign a role to User
     */
    public function assignRole($roles)
    {
        return $this->roles()->syncWithoutDetaching($roles);
    }

    /**
     * Remove an existing role of User
     */
    public function removeRole($roles)
    {
        return $this->roles()->detach($roles);
    }

    /**
     * Check if given roles exists
     * @return boolean
     */
    public function hasRoles(array $roleNames)
    {
        $arr = [];
        foreach($this->roles as $role)
        {
            array_push($arr, $role->name);
        }
        return array_intersect($arr, $roleNames);
    }

    /**
     * Check if user has admin privileges
     *
     * @return boolean
     */
    public function isAdmin()
    {
        return $this->hasRoles(['admin']);
    }

    /**
     * Check if user is root
     */
    public function isRoot()
    {
        return $this->hasRoles(['root']);
    }

    /**
     * doesn't work right now
     */
    public function getRoles()
    {
        return $this->assignedRoles;
    }


    /**
     * Get user's all permissions without roles
     * @return array
     */
    public function getPermissions()
    {
        $arr = [];
        foreach ($this->roles as $role) {
            foreach ($role->Permissions as $permission) {
                array_push($arr, $permission->name);
            }
        }
        return array_unique($arr);
    }


    /**
     * Check if user has any permissions
     * @return bool
     */
    public function hasAnyPermissions()
    {
        return count($this->getPermissions()) > 0;
    }
    

    /**
     * @return boolean
     */
    public function hasPermission($permission)
    {
        $permission = is_array($permission) ? $permission : func_get_args();
        return array_intersect($this->getPermissions(), $permission) ? true : false;
    }

}
