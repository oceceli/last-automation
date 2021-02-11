<?php

namespace App\Http\Livewire\Roles;

use App\Models\Permission;
use App\Models\Role;
use Livewire\Component;

class Roles extends Component
{

    public $permissionsModal = false;
    public $permissionIds;
     
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
        return Role::all();
    }

    public function getPermissionsProperty()
    {
        return Permission::all();
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

    public function closeNewRoleModal()
    {
        $this->reset('name', 'newRoleModal');
    }

    public function render()
    {
        return view('livewire.roles.roles');
    }
}
