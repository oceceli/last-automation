<tr class="text-gray-400">
    <td class="center aligned collapsing">
        <span data-tooltip="{{ __('common.suspended') }}" data-variation="mini" data-position="top left">
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
    <td class="collapsing right aligned">
        {{-- <x-menu-dropdown main="{{ __('common.activate')}}" action="woActivate({{ $workOrder->id }})" color="">
            <div wire:click.prevent="openDetailsModal({{ $workOrder->id }})" class="item text-red-600"> 
                <i class="link eye icon"></i>
                {{ __('common.see_details' ) }}
            </div>
        </x-menu-dropdown>  --}}
        <x-menu-dropdown main="{{ __('common.see_details')}}" action="openDetailsModal({{ $workOrder->id }})" color="">
            <div wire:click.prevent="woActivate({{ $workOrder->id }})" class="item text-red-600"> 
                <i class="unlock icon"></i>
                {{ __('common.activate')}}
            </div>
            <a href="{{ route('work-orders.edit', ['work_order' => $workOrder->id])}}" class="item text-red-600"> 
                <i class="edit icon"></i>
                {{ __('common.edit')}}
            </a>
            {{-- <div wire:click.prevent="routePreparePage({{ $workOrder->id }})" class="item text-red-600">
                <i class="play icon"></i>
                {{ __('common.detail')}}
            </div> --}}
            <div wire:click.prevent="delete({{ $workOrder->id }})" class="item text-red-600">
                <i class="trash icon"></i>
                {{ __('common.delete')}}
            </div>
        </x-menu-dropdown> 
        {{-- <x-crud-actions show edit delete modelName="work-order" gray :modelId="$workOrder->id" /> --}}
    </td>
</tr>