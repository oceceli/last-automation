<?php

namespace App\Http\Livewire\Sections\Companies;

use App\Http\Livewire\Sections\Polymorphic\AddressForm;
use App\Http\Livewire\Sections\Polymorphic\EditableAddress;
use App\Http\Livewire\SmartTable;
use App\Models\Company;
use Livewire\Component;

class Datatable extends Component
{
    use SmartTable;
    use AddressForm;
    use EditableAddress;

    public $model = Company::class;
    public $view = 'livewire.sections.companies.datatable';

    public $addressModal = false;
    


    public function addAddress($companyId)
    {
        $this->addressable_id = $companyId;
        $this->addressModal = true;
    }


    public function updatedAddressModal($value)
    {
        if(!$value) $this->reset();
    }

}
