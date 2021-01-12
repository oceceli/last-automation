<?php

namespace App\Http\Livewire\Sections\Companies;

use App\Http\Livewire\Sections\Polymorphic\AddressForm;
use App\Http\Livewire\SmartTable;
use App\Models\Address;
use App\Models\Company;
use Livewire\Component;

class Datatable extends Component
{
    use SmartTable;
    use AddressForm;

    public $model = Company::class;
    public $view = 'livewire.sections.companies.datatable';

    public $addressModal = false;
    public $showModal = false;
    
    public $selectedCompany;

    public $editMode = false;
    public $editableAddressId;
    public $editableAddress;


    public function addAddress($companyId)
    {
        $this->addressable_id = $companyId;
        $this->addressModal = true;
    }


    public function updatedAddressModal($value)
    {
        if(!$value) $this->reset();
    }

    public function openShowModal($companyId)
    {
        $this->selectedCompany = Company::find($companyId);
        $this->showModal = true;
    }

    public function updatedShowModal($value)
    {
        if(!$value) $this->reset();
    }


    public function updatingEditableAddressId($id)
    {
        // $this->reset();
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

    public function cancelEditing()
    {
        $this->editableAddress = Address::find($this->editableAddressId);
        $this->editMode = false;
    }

    public function saveEdited()
    {
        $data = $this->validate();
        $this->editableAddress->update($data);
        $this->editMode = false;
    }

}
