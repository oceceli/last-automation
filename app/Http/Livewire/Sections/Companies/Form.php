<?php

namespace App\Http\Livewire\Sections\Companies;

use App\Http\Livewire\FormHelpers;
use App\Models\Company;
use Livewire\Component;

class Form extends Component
{

    use FormHelpers;

    public $cmp_name;
    public $cmp_current_code;
    public $cmp_commercial_title;
    
    public $cmp_tax_number;
    public $cmp_note;
    public $cmp_phone;

    public $company;
    public $editMode = false;


    public function rules()
    {
        return [
            'cmp_name' => 'required|unique:companies,cmp_name,' . optional($this->company)->id,
            'cmp_current_code' => 'required|unique:companies,cmp_current_code,' . optional($this->company)->id,
            'cmp_commercial_title' => 'required|unique:companies,cmp_commercial_title,' . optional($this->company)->id,
            
            'cmp_tax_number' => 'nullable|unique:companies,cmp_tax_number,' . optional($this->company)->id,
            'cmp_phone' => 'nullable|max:12|unique:companies,cmp_phone,' . optional($this->company)->id,
            'cmp_note' => 'nullable',
        ];
    }


    public function mount(Company $company)
    {
        $this->editMode = true;
        $this->setEditMode($company);
    }

    
    public function submit()
    {
        $validatedData = $this->validate();

        if($this->editMode && $this->company) {
            $this->company->update($validatedData);
            // $this->emit('toast','', __('companies.company_info_updated'), 'success');
            session()->flash('success', __('companies.company_info_updated'));
            return redirect()->route('companies.index');
        } else {
            Company::create($validatedData);
            $this->emit('toast','', __('companies.company_defined'), 'success');
            $this->reset();
        }
    }


    public function setEditMode(Company $company)
    {
        $this->cmp_name = $company->cmp_name;
        $this->cmp_current_code = $company->cmp_current_code;
        $this->cmp_commercial_title = $company->cmp_commercial_title;
        $this->cmp_tax_number = $company->cmp_tax_number;
        $this->cmp_note = $company->cmp_note;
        $this->cmp_phone = $company->cmp_phone;
    }

    public function render()
    {
        return view('livewire.sections.companies.form');
    }
}
