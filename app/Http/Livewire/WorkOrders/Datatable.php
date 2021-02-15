<?php

namespace App\Http\Livewire\WorkOrders;

use App\Http\Livewire\SmartTable;
use App\Models\WorkOrder;
use Livewire\Component;

class Datatable extends Component
{
    use SmartTable;

    public $detailsModal = false;
    public $selectedWorkOrder;

    protected $alsoSearch = [
        'product.name',
    ];

    public $model = WorkOrder::class;
    protected $view = 'livewire.work-orders.datatable';



    public function openDetailsModal($workOrderId)
    {
        $this->detailsModal = true;
        $this->selectedWorkOrder = WorkOrder::find($workOrderId);
    }

}
