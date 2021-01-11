<?php

namespace App\Http\Livewire\Sections\Polymorphic;

use App\Models\Address;

trait EditableAddress 
{
    public $editableAddressId;
    public $editableAddress;

    public $editMode = false;

    public function updatedEditableAddressId($id)
    {
        $this->editableAddress = Address::findOrFail($id);
    }
}