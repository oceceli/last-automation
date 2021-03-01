<?php

namespace App\Http\Livewire\Companies;

use App\Http\Livewire\Traits\Polymorphic\AddressForm;
use App\Http\Livewire\SmartTable;
use App\Http\Livewire\Traits\Exportable;
use App\Models\Address;
use App\Models\Company;
use Livewire\Component;

class Datatable extends Component
{
    use SmartTable;
    use AddressForm;
    use Exportable;

    public $model = Company::class;
    public $view = 'livewire.companies.datatable';

    public $addressModal = false;
    public $showModal = false;
    
    public $selectedCompany;

    public $editMode = false;
    public $editableAddressId;
    public $editableAddress;


    // filter models
    public $cmp_supplier;
    public $cmp_customer;


    protected $queryString = ['cmp_customer', 'cmp_supplier'];

    public function resetFilters()
    {
        $this->reset('cmp_customer', 'cmp_supplier');
    }

    private function advancedFilters()
    {
        return [
            ['cmp_customer' => $this->cmp_customer],
            ['cmp_supplier' => $this->cmp_supplier],
        ];
    }


    public function addAddress($companyId)
    {
        $this->selectedCompany = Company::find($companyId); 
        $this->addressable_id = $companyId;
        $this->addressModal = true;
    }

    public function updatedAddressModal($value)
    {
        if(!$value) $this->clearOut();
    }

    private function clearOut()
    {
        $this->clearFields();
        $this->reset('addressModal', 'showModal', 'selectedCompany', 'editMode', 'editableAddressId', 'editableAddress');
    }

    public function openShowModal($companyId)
    {
        $this->selectedCompany = Company::find($companyId);
        $this->updatingEditableAddressId(optional($this->selectedCompany->addresses->first())->id);
        $this->showModal = true;
    }

    public function updatedShowModal($value)
    {
        if(!$value) $this->clearOut();
    }


    public function updatingEditableAddressId($id)
    {
        $this->editableAddressId = $id;
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
