<?php

namespace App\View\Components;

use Illuminate\View\Component;

class DispatchorderDetails extends Component
{

    public $dispatchOrder;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($dispatchOrder)
    {
        $this->dispatchOrder = $dispatchOrder;
    }


    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|string
     */
    public function render()
    {
        return view('components.dispatchorder-details', ['tableClass' => $this->tableClass()]);
    }



    private function tableClass()
    {
        if($this->dispatchOrder->isApproved()) {
            $arr = [
                'icon' => 'double check icon',
                'tableRow' => 'positive',
                'statusColor' => 'text-green-500',
                'borderColor' => 'border-green-500',
                'bottomClass' => 'bg-green-500',
            ];
        } elseif($this->dispatchOrder->isCompleted()) {
            $arr = [
                'icon' => 'checkmark icon',
                'tableRow' => 'red font-bold',
                'statusColor' => 'text-red-500',
                'borderColor' => 'border-red-500',
                'bottomClass' => 'bg-red-500',
            ];
        } elseif($this->dispatchOrder->isInProgress()) {
            $arr = [
                'icon' => 'loading cog icon',
                'tableRow' => 'yellow font-bold',
                'statusColor' => 'text-yellow-500',
                'borderColor' => 'border-yellow-400',
                'bottomClass' => 'bg-yellow-400',
            ];
        } elseif($this->dispatchOrder->isActive()) {
            $arr = [
                'icon' => 'clock icon',
                'tableRow' => '',
                'statusColor' => 'text-teal-500',
                'borderColor' => 'border-teal-900',
                'bottomClass' => 'bg-teal-900',
            ];
        } elseif($this->dispatchOrder->isSuspended()) {
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
