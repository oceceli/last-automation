<div class="shadow rounded-t-md">
    @if ($workOrder->isCompleted())
        <div class="p-3 rounded-t-md bg-green-200">
            <i class="large {{ __('sections/workorders.wo_completed_icon') }} icon"></i>
            <span class="font-bold text-green-600">{{ __('sections/workorders.production_completed') }} </span>
        </div>
    @elseif($workOrder->inProgress())
        <div class="p-3 rounded-t-md bg-orange-200">
            <i class="large {{ __('sections/workorders.wo_in_progress_icon') }} link icon"></i>
            <span class="font-bold text-red-600">{{ __('sections/workorders.production_continues') }}...</span>
        </div>
    @elseif($workOrder->is_active)
        <div class="p-3 rounded-t-md bg-blue-200">
            <i class="large {{ __('sections/workorders.wo_active_icon') }} icon"></i>
            <span class="font-bold text-blue-600">{{ __('sections/workorders.waiting_for_production') }}</span>
        </div>
    @else
        <div class="p-3 rounded-t-md bg-gray-300">
            <i class="large {{ __('sections/workorders.wo_inactive_icon') }} icon"></i>
            <span class="font-bold text-gray-600">{{ __('common.suspended') }}</span>
        </div>
    @endif
</div>