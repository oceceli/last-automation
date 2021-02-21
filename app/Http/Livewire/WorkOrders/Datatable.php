<?php

namespace App\Http\Livewire\WorkOrders;

use App\Http\Livewire\SmartTable;
use App\Http\Livewire\Traits\WorkOrders\DetailsModal;
use App\Models\WorkOrder;
use Livewire\Component;

class Datatable extends Component
{
    use SmartTable;
    use DetailsModal;
     

    protected $alsoSearch = [
        'product.name',
    ];

    public $model = WorkOrder::class;
    protected $view = 'livewire.work-orders.datatable';





}
