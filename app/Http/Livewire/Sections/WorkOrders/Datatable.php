<?php

namespace App\Http\Livewire\Sections\WorkOrders;

use App\Http\Livewire\SmartTable;
use App\Models\WorkOrder;
use Livewire\Component;

class Datatable extends Component
{
    use SmartTable;

    protected $view = 'livewire.sections.workorders.datatable';

    public $model = WorkOrder::class;


}
