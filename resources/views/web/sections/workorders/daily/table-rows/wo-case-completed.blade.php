<tr class="left green marked text-green-600 bg-teal-50 ">
    <td class="center aligned collapsing" data-tooltip="{{ __('workorders.production_is_completed') }} - {{ $workOrder->completedAt() }}" 
            data-variation="mini" data-position="top left">
        <i class="large green checkmark icon"></i>
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
    <td class="collapsing selectable">
        <span class="px-2 shadow rounded bg-white" data-tooltip="{{ __('common.see_details') }}" data-variation="mini" data-position="top right">
            <a class="text-teal-600 text-lg" href="{{ route('work-orders.show', ['work_order' => $workOrder]) }}">
                {{ round($workOrder->getProductionResults()['net'],2) }} {{ $workOrder->product->baseUnit->name }}
            </a>
        </span>
    </td>
</tr>