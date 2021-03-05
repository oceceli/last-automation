<?php

namespace App\View\Components;

use App\Models\WorkOrder;
use Illuminate\View\Component;

class WorkorderDetails extends Component
{

    public $workOrder;

    public $viewOnly;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct(WorkOrder $workOrder, $viewOnly = false)
    {
        $this->workOrder = $workOrder;
        $this->viewOnly = $viewOnly;
    }


    public function templateClasses()
    {
        $arr = [
            'icon' => '',
            // 'tableRow' => '',
            // 'statusColor' => '',
            'borderColor' => '',
            'bottomClass' => '',
            'explanation' => '',
        ];
        if($this->workOrder->isApproved()) {
            $arr = [
                'icon' => 'double check icon',
                // 'tableRow' => 'positive',
                // 'statusColor' => 'text-green-700',
                'borderColor' => 'border-green-700',
                'bottomClass' => 'bg-green-700',
                'explanation' => __('workorders.completed_at_time', ['time' => $this->workOrder->completedAt()]),
            ];
        } elseif($this->workOrder->isCompleted()) {
            $arr = [
                'icon' => 'checkmark icon',
                // 'tableRow' => 'red font-bold',
                // 'statusColor' => 'text-red-700',
                'borderColor' => 'border-red-700',
                'bottomClass' => 'bg-red-700',
                'explanation' => __('workorders.waiting_for_approval'),
            ];
        } elseif($this->workOrder->isInProgress()) {
            $arr = [
                'icon' => 'loading cog icon',
                // 'tableRow' => 'yellow font-bold',
                // 'statusColor' => 'text-yellow-700',
                'borderColor' => 'border-yellow-700',
                'bottomClass' => 'bg-yellow-700',
                'explanation' => __('workorders.production_started_at_time', ['time' => $this->workOrder->startedAt()->diffForHumans()]),
            ];
        } elseif($this->workOrder->isPrepared()) {
            $arr = [
                'icon' => 'pause icon',
                // 'tableRow' => 'blue font-bold',
                // 'statusColor' => 'text-blue-700',
                'borderColor' => 'border-purple-700',
                'bottomClass' => 'bg-purple-700',
                'explanation' => __('workorders.sources_are_prepared_waiting_for_start_signal'),
            ];
        } elseif($this->workOrder->isPreparing()) {
            $arr = [
                'icon' => 'loading clock icon',
                // 'tableRow' => 'blue font-bold',
                // 'statusColor' => 'text-blue-700',
                'borderColor' => 'border-teal-700',
                'bottomClass' => 'bg-teal-700',
                'explanation' => __('workorders.sources_are_preparing'),
            ];
        } elseif($this->workOrder->isActive()) {
            $arr = [
                'icon' => 'clock icon',
                // 'tableRow' => '',
                // 'statusColor' => 'text-teal-500',
                'borderColor' => 'border-teal-900',
                'bottomClass' => 'bg-teal-900',
                'explanation' => __('workorders.get_sources_ready_to_be_prepared'),
            ];
        } elseif($this->workOrder->isSuspended()) {
            $arr = [
                'icon' => 'ban icon',
                // 'tableRow' => 'grey',
                // 'statusColor' => 'text-gray-700',
                'borderColor' => 'border-gray-700',
                'bottomClass' => 'bg-gray-700',
                'explanation' => __('workorders.activate_first_to_get_in_progress'),
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
