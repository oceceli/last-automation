<?php

namespace App\Http\Livewire\Users;

use App\Models\Role;
use App\Models\User;
use Livewire\Component;

class UserRoles extends Component
{

    public $rolesModal = false;
    public $selectedUser;
    public $roleIds = [];
     
    // public $newRoleModal = false;
    // public $name;


    public function getUsersProperty()
    {
        return User::all();
    }

    public function getRolesProperty()
    {
        return Role::all();
    }


    public function openRolesModal($userId)
    {
        $this->selectedUser = $this->getUsersProperty()->find($userId);
        $this->roleIds = $this->selectedUser->roles->pluck('id')->toArray();
        $this->rolesModal = true;
    }

    public function delete($id)
    {
        User::findAndDelete($id);
    }

    public function closeRolesModal()
    {
        $this->reset('rolesModal', 'selectedUser', 'roleIds');
    }

    public function updatedRolesModal($bool)
    {
        if($bool == false) $this->closeRolesModal();
    }

    public function submitRoles()
    {
        if(!$this->selectedUser) return;
        $this->selectedUser->syncRoles($this->roleIds);
        $this->closeRolesModal();
    }


    public function render()
    {
        return view('livewire.users.user-roles');
    }
}
