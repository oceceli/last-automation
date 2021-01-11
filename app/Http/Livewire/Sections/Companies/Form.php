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


    protected $rules = [
        'cmp_name' => 'required|unique:companies',
        'cmp_current_code' => 'required|unique:companies',
        'cmp_commercial_title' => 'required|unique:companies',
        
        'cmp_tax_number' => 'nullable|unique:companies',
        'cmp_phone' => 'nullable|max:12|unique:companies',
        'cmp_note' => 'nullable',
    ];

    public function render()
    {
        return view('livewire.sections.companies.form');
    }

    public function submit()
    {
        Company::create($this->validate());
        $this->emit('toast','', __('companies.company_defined'), 'success');
    }
}
