<tr class="font-semibold cursor-default hover:bg-cool-gray-50 ease-in duration-200">
    <td class="center aligned collapsing">
        <span data-tooltip="{{ __('workorders.waiting_for_production') }}" data-variation="mini" data-position="top left">
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
    <td class="collapsing right aligned">
        <x-menu-dropdown main="{{ __('common.prepare')}}" action="routePreparePage({{ $workOrder->id }})" color="blue" icon="box icon">
            <div wire:click.prevent="openDetailsModal({{ $workOrder->id }})" class="item text-red-600"> 
                <i class="link eye icon"></i>
                {{ __('common.see_details' ) }}
            </div>
            <div wire:click.prevent="woSuspend({{ $workOrder->id }})" class="item text-red-600"> 
                <i class="ban icon"></i>
                {{ __('common.suspend' ) }}
            </div>
            <a href="{{ route('work-orders.edit', ['work_order' => $workOrder->id])}}" class="item text-red-600"> 
                <i class="edit icon"></i>
                {{ __('common.edit')}}
            </a>
            <div wire:click.prevent="delete({{ $workOrder->id }})" class="item text-red-600">
                <i class="trash icon"></i>
                {{ __('common.delete')}}
            </div>
        </x-menu-dropdown>          
    </td>
</tr>

