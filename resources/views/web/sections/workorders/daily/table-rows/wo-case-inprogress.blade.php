<tr class="{{ $workOrder->statusColor }} font-bold cursor-default">
    <td class="center aligned collapsing">
        @if ( ! $workOrder->isToday())
            <span data-tooltip="{{ __('workorders.this_work_order_is_not_finished_in_time_should_end_now')}}" data-variation="mini" data-position="top left">
                <i class="large red attention icon"></i>
            </span>
        @else
            <span data-tooltip="{{ __('workorders.production_continues') }}" data-variation="mini">
                <i class="large {{ __('workorders.wo_in_progress_icon')}} icon"></i>
            </span>
        @endif
    </td>
    <td>{{ $workOrder->product->prd_name }}</td>
    <td>
        <span>{{ $workOrder->wo_amount }} {{ $workOrder->unit->name }}</span>
        @if ( ! $workOrder->unitIsAlreadyBase())
            <span class="text-xs text-ease">({{ round($workOrder->convertedBaseAmount(),3) }} {{ $workOrder->convertedBaseUnit()->name }})</span>
        @endif
    </td>
    <td class="">{{ $workOrder->wo_lot_no }}</td>
    <td class="center aligned collapsing">{{ $workOrder->wo_queue }}</td>
    <td class="center aligned collapsing">{{ $workOrder->wo_code }}</td>
    <td class="collapsing">
        <x-crud-actions show edit gray modelName="work-order" :modelId="$workOrder->id">
            <div wire:key="showReserved{{ $workOrder->id }}" wire:click.prevent="showReservedSources({{ $workOrder->id }})" data-tooltip="{{ __('workorders.reserved_sources') }}" data-variation="mini" data-position="top right">
                <i class="search link icon"></i>
            </div>
            <div wire:key="complete{{ $workOrder->id }}" wire:click.prevent="FinalizeProcess({{ $workOrder->id }})" data-tooltip="{{ __('workorders.wo_complete') }}" data-variation="mini">
                <i class="{{ __('workorders.wo_complete_icon') }} red link icon"></i>
            </div>
        </x-crud-actions>
    </td>
</tr>