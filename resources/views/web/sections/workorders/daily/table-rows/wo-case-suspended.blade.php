<tr class="text-gray-400">
    <td class="center aligned collapsing">
        <span data-tooltip="{{ __('common.suspended') }}" data-variation="mini">
            <i class="large grey ban icon"></i>
        </span>
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
        <x-crud-actions show edit delete modelName="work-order" gray :modelId="$workOrder->id" />
    </td>
</tr>