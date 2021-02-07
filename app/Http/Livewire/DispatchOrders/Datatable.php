<?php

namespace App\Http\Livewire\DispatchOrders;

use App\Http\Livewire\SmartTable;
use App\Models\DispatchOrder;
use Livewire\Component;

class Datatable extends Component
{
    use SmartTable;

    public $detailsModal = false;
    public $selectedDo;

    public $model = DispatchOrder::class;
    public $view = 'livewire.dispatch-orders.datatable';

    protected $alsoSearch = [
        'company.cmp_name', 
        'company.cmp_current_code',
        'address.adr_name',
    ];

    public function openDetailsModal($dispatchOrderId)
    {
        $this->selectedDo = DispatchOrder::find($dispatchOrderId);
        $this->detailsModal = true;
    }

    public function updatedDetailsModal($bool)
    {
        if($bool == false) $this->reset();
    }

    public function statusClass()
    {
        if($this->selectedDo->isApproved()) {
            $arr = [
                'bottomClass' => 'bg-green-100',
                'lClass' => 'bg-green-50',
                'rClass' => 'bg-green-50',
            ];
        } else {
            $arr = [
                'bottomClass' => 'bg-orange-100',
                'lClass' => 'bg-orange-50',
                'rClass' => 'bg-orange-50',
            ];
        }
        return $arr;
    }


}
