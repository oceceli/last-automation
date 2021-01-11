<?php

namespace App\Http\Livewire\Sections\Polymorphic;

use App\Models\Address;

trait EditableAddress 
{
    public $editableAddressId;
    public $editableAddress;



    public $editMode = false;

    public function updatingEditableAddressId($id)
    {
        $this->reset();
        $this->editableAddress = Address::find($id);
        $this->editMode = false;
    }

    public function enableEditMode()
    {
        $this->editMode = true;
        $this->adr_name = $this->editableAddress->adr_name;
        $this->adr_country = $this->editableAddress->adr_country;
        $this->adr_province = $this->editableAddress->adr_province;
        $this->adr_district = $this->editableAddress->adr_district;
        $this->adr_body = $this->editableAddress->adr_body;
        
        $this->adr_phone = $this->editableAddress->adr_phone;
        $this->adr_note = $this->editableAddress->adr_note;
    }

    public function saveEdited()
    {
        $this->validate();
        dd("doğrulama geçti");
    }
}