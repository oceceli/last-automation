<?php

namespace App\View\Components;

use App\Models\WorkOrder;
use Illuminate\View\Component;

class WorkorderDetails extends Component
{

    public $workOrder;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct(WorkOrder $workOrder)
    {
        $this->workOrder = $workOrder;
    }


    public function templateClasses()
    {
        $arr = [
            'icon' => '',
            // 'tableRow' => '',
            'statusColor' => '',
            'borderColor' => '',
            'bottomClass' => '',
            'explanation' => '',
        ];
        if($this->workOrder->isApproved()) {
            $arr = [
                'icon' => 'double check icon',
                // 'tableRow' => 'positive',
                'statusColor' => 'text-green-500',
                'borderColor' => 'border-green-500',
                'bottomClass' => 'bg-green-500',
                'explanation' => $this->workOrder->wo_completed_at,
            ];
        } elseif($this->workOrder->isCompleted()) {
            $arr = [
                'icon' => 'checkmark icon',
                // 'tableRow' => 'red font-bold',
                'statusColor' => 'text-red-500',
                'borderColor' => 'border-red-500',
                'bottomClass' => 'bg-red-500',
                'explanation' => __('workorders.production_is_completed'),
            ];
        } elseif($this->workOrder->isInProgress()) {
            $arr = [
                'icon' => 'loading cog icon',
                // 'tableRow' => 'yellow font-bold',
                'statusColor' => 'text-yellow-500',
                'borderColor' => 'border-yellow-400',
                'bottomClass' => 'bg-yellow-400',
                'explanation' => __('workorders.production_continues'),
            ];
        } elseif($this->workOrder->isPrepared()) {
            $arr = [
                'icon' => 'loading cog icon',
                // 'tableRow' => 'purple font-bold',
                'statusColor' => 'text-purple-500',
                'borderColor' => 'border-purple-400',
                'bottomClass' => 'bg-purple-400',
                'explanation' => __('workorders.production_continues'),
            ];
        } elseif($this->workOrder->isPreparing()) {
            $arr = [
                'icon' => 'loading cog icon',
                // 'tableRow' => 'purple font-bold',
                'statusColor' => 'text-purple-500',
                'borderColor' => 'border-purple-400',
                'bottomClass' => 'bg-purple-400',
                'explanation' => __('workorders.production_continues'),
            ];
        } elseif($this->workOrder->isActive()) {
            $arr = [
                'icon' => 'clock icon',
                // 'tableRow' => '',
                'statusColor' => 'text-teal-500',
                'borderColor' => 'border-teal-900',
                'bottomClass' => 'bg-teal-900',
                'explanation' => __('workorders.waiting_for_production'),
            ];
        } elseif($this->workOrder->isSuspended()) {
            $arr = [
                'icon' => 'ban icon',
                // 'tableRow' => 'grey',
                'statusColor' => 'text-gray-500',
                'borderColor' => 'border-gray-500',
                'bottomClass' => 'bg-gray-500',
                'explanation' => __('workorders.suspended'),
            ];
        }
        return $arr;
    }


    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|string
     */
    public function render()
    {
        return view('components.workorder-details', ['classes' => $this->templateClasses()]);
    }
}
