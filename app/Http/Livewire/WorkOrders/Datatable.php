<?php

namespace App\Http\Livewire\WorkOrders;

use App\Http\Livewire\SmartTable;
use App\Models\WorkOrder;
use Livewire\Component;

class Datatable extends Component
{
    use SmartTable;

    protected $alsoSearch = [
        'product.name',
    ];

    public $model = WorkOrder::class;
    protected $view = 'livewire.work-orders.datatable';



}
