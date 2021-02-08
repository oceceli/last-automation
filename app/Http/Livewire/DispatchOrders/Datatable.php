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


    

    public function tableClass($dispatchOrder)
    {
        if($dispatchOrder->isApproved()) {
            $arr = [
                'status' => 'double check icon',
                'row' => 'positive',
            ];
        } elseif($dispatchOrder->isCompleted()) {
            $arr = [
                'status' => 'checkmark icon',
                'row' => 'red font-bold',
            ];
        } elseif($dispatchOrder->isInProgress()) {
            $arr = [
                'status' => 'loading cog icon',
                'row' => 'yellow font-bold',
            ];
        } elseif($dispatchOrder->isActive()) {
            $arr = [
                'status' => 'clock icon',
                'row' => '',
            ];
        } elseif($dispatchOrder->isSuspended()) {
            $arr = [
                'status' => 'ban icon',
                'row' => 'grey',
            ];
        }
        return $arr;
    }




    public function statusClass()
    {
        if($this->selectedDo->isApproved()) {
            $arr = [
                'bottomClass' => 'bg-green-100',
                'lClass' => '',
                'rClass' => '',
            ];
        } elseif($this->selectedDo->isCompleted()) {
            $arr = [
                'bottomClass' => 'bg-orange-100',
                'lClass' => '',
                'rClass' => '',
            ];
        } elseif($this->selectedDo->isInProgress()) {
            $arr = [
                'bottomClass' => 'bg-yellow-200',
                'lClass' => '',
                'rClass' => '',
            ];
        } elseif($this->selectedDo->isActive()) {
            $arr = [
                'bottomClass' => '',
                'lClass' => '',
                'rClass' => '',
            ];
        } elseif($this->selectedDo->isSuspended()) {
            $arr = [
                'bottomClass' => 'bg-gray-100',
                'lClass' => '',
                'rClass' => '',
            ];
        } 
        return $arr;
    }




}
