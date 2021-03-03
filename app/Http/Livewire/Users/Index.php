<?php

namespace App\Http\Livewire\Users;

use App\Http\Livewire\Deletable;
use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Livewire\Component;

class Index extends Component
{
    use Deletable;
    public $model = User::class;

    public $rolesModal = false;
    public $selectedUser;
    public $roleIds = [];
     
    // public $newRoleModal = false;
    // public $name;


    public function getUsersProperty()
    {
        return User::allExceptSU();
    }

    public function getRolesProperty()
    {
        return Role::allExceptSU();
    }


    public function openRolesModal($userId)
    {
        $this->selectedUser = $this->getUsersProperty()->find($userId);
        $this->roleIds = $this->selectedUser->roles->pluck('id')->toArray();
        $this->rolesModal = true;
    }


    public function closeRolesModal()
    {
        $this->reset('rolesModal', 'selectedUser', 'roleIds');
    }

    public function updatedRolesModal($bool)
    {
        if($bool == false) $this->closeRolesModal();
    }

    public function updatedRoleIds()
    {
        if($this->selectedUser->isLastAdmin() || $this->selectedUser->isSystemAdmin()) {
            $this->roleIds = $this->selectedUser->roles->pluck('id')->toArray();
            $this->emit('toast', '', __('roles.there_must_be_at_least_one_admin_in_the_system'), 'warning');
        }
    }

    public function submitRoles()
    {
        if(!$this->selectedUser) return;
        $this->selectedUser->syncRoles($this->roleIds);
        $this->closeRolesModal();
    }


    public function render()
    {
        return view('livewire.users.index');
    }
}
