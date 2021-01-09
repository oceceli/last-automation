<?php

namespace App\Http\Livewire\Sections\Companies;

use App\Http\Livewire\SmartTable;
use App\Models\Company;
use Livewire\Component;

class Datatable extends Component
{
    use SmartTable;

    public $model = Company::class;
    public $view = 'livewire.sections.companies.datatable';

}
