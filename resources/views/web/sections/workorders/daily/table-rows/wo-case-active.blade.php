<tr class="font-semibold cursor-default hover:bg-cool-gray-50 ease-in duration-200">
    <td class="center aligned collapsing">
        <span data-tooltip="{{ __('workorders.waiting_for_production') }}" data-variation="mini">
            <i class="large primary clock outline icon"></i>
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

    <x-menu-dropdown main="{{ __('common.start')}}" action="startProcess({{ $workOrder->id }})" color="orange">
        <div wire:click.prevent="test" class="item"> 
            <i class="link eye icon"></i>
            {{ __('common.see_details' ) }}
        </div>
    </x-menu-dropdown>

          
    </td>
</tr>

