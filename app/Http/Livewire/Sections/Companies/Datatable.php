<?php

namespace App\Http\Livewire\Sections\Companies;

use App\Http\Livewire\SmartTable;
use Livewire\Component;

class Datatable extends Component
{
    use SmartTable;

    public function render()
    {
        return view('livewire.sections.companies.datatable');
    }
}
