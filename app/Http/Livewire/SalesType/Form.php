<?php

namespace App\Http\Livewire\SalesType;

use App\Http\Livewire\Traits\SalesTypeTrait;
use App\Models\SalesType;
use Livewire\Component;

class Form extends Component
{

    use SalesTypeTrait;
   

    public function render()
    {
        return view('livewire.sales-type.form');
    }

    
}
