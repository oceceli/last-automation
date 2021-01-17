<?php

namespace App\Http\Livewire\Sections\Dispatchorders;

use App\Http\Livewire\SmartTable;
use App\Models\DispatchOrder;
use Livewire\Component;

class Datatable extends Component
{
    use SmartTable;

    public $model = DispatchOrder::class;
    public $view = 'livewire.sections.dispatchorders.datatable';

    protected $alsoSearch = [
        'company.cmp_name', 
        'company.cmp_current_code',
        'address.adr_name',
    ];


}
