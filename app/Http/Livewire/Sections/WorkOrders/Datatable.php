<?php

namespace App\Http\Livewire\Sections\WorkOrders;

use App\Http\Livewire\TableHelpers;
use App\Models\WorkOrder;
use Livewire\Component;

class Datatable extends Component
{
    use TableHelpers;

    protected $view = 'livewire.sections.workorders.datatable';

    public $model = WorkOrder::class;


}
