<div class="shadow rounded-t-md">
    @if ($workOrder->isCompleted())
        <div class="p-3 rounded-t-md bg-{{ $statusColor }}-200">
            <i class="large text-{{ $statusColor }}-600 {{ __('sections/workorders.wo_completed_icon') }} icon"></i>
            <span class="font-bold text-{{ $statusColor }}-600">{{ __('sections/workorders.production_completed') }} </span>
        </div>
    @elseif($workOrder->isInProgress())
        <div class="p-3 rounded-t-md bg-{{ $statusColor }}-200">
            <i class="large text-{{ $statusColor }}-600 {{ __('sections/workorders.wo_in_progress_icon') }} link icon"></i>
            <span class="font-bold text-{{ $statusColor }}-600">{{ __('sections/workorders.production_continues') }}...</span>
        </div>
    @elseif($workOrder->isActive())
        <div class="p-3 rounded-t-md bg-{{ $statusColor }}-200">
            <i class="large text-{{ $statusColor }}-600 {{ __('sections/workorders.wo_active_icon') }} icon"></i>
            <span class="font-bold text-{{ $statusColor }}-600">{{ __('sections/workorders.waiting_for_production') }}</span>
        </div>
    @else
        <div class="p-3 rounded-t-md bg-gray-300">
            <i class="large text-{{ $statusColor }}-600 {{ __('sections/workorders.wo_inactive_icon') }} icon"></i>
            <span class="font-bold text-{{ $statusColor }}-600">{{ __('common.suspended') }}</span>
        </div>
    @endif
</div>