<?php

namespace App\Http\Livewire\Roles;

use App\Models\Permission;
use App\Models\Role;
use Livewire\Component;

class Roles extends Component
{

    public $permissionsModal = false;
    public $selectedRole;
    public $permissionIds = [];
     
    public $newRoleModal = false;
    public $name;

    protected function rules()
    {
        return [
            'name' => 'required|unique:roles',
        ];
    }

    public function getRolesProperty()
    {
        return Role::allExceptSU();
    }

    public function getPermissionsProperty()
    {
        return Permission::all();
    }

    public function openPermissionsModal($roleId)
    {
        $this->selectedRole = $this->getRolesProperty()->find($roleId);
        $this->permissionIds = $this->selectedRole->permissions->pluck('id')->toArray();
        $this->permissionsModal = true;
    }

    public function closePermissionsModal()
    {
        $this->reset('permissionsModal', 'selectedRole', 'permissionIds');
    }

    public function updatedPermissionsModal($bool)
    {
        if($bool == false) $this->closePermissionsModal();
    }

    public function updatedPermissionIds()
    {
        if($this->selectedRole->name === 'admin')
            $this->permissionIds = $this->selectedRole->permissions->pluck('id')->toArray();
    }

    public function delete($id)
    {
        Role::findAndDelete($id);
    }

    public function submitRole()
    {
        $data = $this->validate();
        Role::create($data);

        $this->closeNewRoleModal();

        $this->emit('toast', '', __('common.saved.saved_successfully'), 'success');
    }

    public function submitPermissions()
    {
        if(!$this->selectedRole) return;
        $this->selectedRole->syncPermissions($this->permissionIds);
        $this->closePermissionsModal();
    }

    public function closeNewRoleModal()
    {
        $this->reset('name', 'newRoleModal');
    }

    public function render()
    {
        return view('livewire.roles.roles');
    }
}
