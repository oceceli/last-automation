<?php

namespace App\Http\Livewire\Sections\Dispatchorders;

use App\Models\Company;
use Carbon\Carbon;
use Livewire\Component;

class Form extends Component
{
    use DispatchProduct;

    public $do_number;
    public $do_datetime;
    public $company_id;
    public $address_id;

    public $selectedCompany;

    
    public function mount()
    {
        $this->do_datetime = Carbon::today();
    }
    

    public function updatedCompanyId($id)
    {
        $this->selectedCompany = Company::findOrFail($id);
        $this->emit('do_company_selected');
    }

    public function getCompanyAddressesProperty()
    {
        return $this->selectedCompany->addresses->toArray();
    }

    

    public function getCompaniesProperty()
    {
        return Company::all();
    }


    public function render()
    {
        return view('livewire.sections.dispatchorders.form');
    }
}
