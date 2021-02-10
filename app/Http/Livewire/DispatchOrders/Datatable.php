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
        'salesType.st_name',
        'salesType.st_abbr',
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


    

    public function tableClass($dispatchOrder)
    {
        if($dispatchOrder->isApproved()) {
            $arr = [
                'icon' => 'double check icon',
                'tableRow' => 'positive',
                'statusColor' => 'text-green-500',
                'borderColor' => 'border-green-500',
                'bottomClass' => 'bg-green-500',
            ];
        } elseif($dispatchOrder->isCompleted()) {
            $arr = [
                'icon' => 'checkmark icon',
                'tableRow' => 'red font-bold',
                'statusColor' => 'text-red-500',
                'borderColor' => 'border-red-500',
                'bottomClass' => 'bg-red-500',
            ];
        } elseif($dispatchOrder->isInProgress()) {
            $arr = [
                'icon' => 'loading cog icon',
                'tableRow' => 'yellow font-bold',
                'statusColor' => 'text-yellow-500',
                'borderColor' => 'border-yellow-400',
                'bottomClass' => 'bg-yellow-400',
            ];
        } elseif($dispatchOrder->isActive()) {
            $arr = [
                'icon' => 'clock icon',
                'tableRow' => '',
                'statusColor' => 'text-teal-500',
                'borderColor' => 'border-teal-900',
                'bottomClass' => 'bg-teal-900',
            ];
        } elseif($dispatchOrder->isSuspended()) {
            $arr = [
                'icon' => 'ban icon',
                'tableRow' => 'grey',
                'statusColor' => 'text-gray-500',
                'borderColor' => 'border-gray-500',
                'bottomClass' => 'bg-gray-500',
            ];
        }
        return $arr;
    }




}
