<x-table-row class="warning font-bold">
    <x-tbody-item class="center aligned">
        <x-span tooltip="{{ __('dispatchorders.all_products_loaded_into_vehicle_waiting_for_approval') }}" position="top left">
            <i class="checkmark icon"></i>
        </x-span>
    </x-tbody-item>

    @include('web.sections.dispatchorders.daily.table-rows.row-common')

    <x-tbody-item class="right aligned">
        <button wire:click.prevent="openApproveModal({{ $dispatchOrder->id }})" class="ui orange label button">
            <i class="triangle exclamation icon"></i>
            {{ __('common.approve') }} S
        </button>
        <a href="{{ route('dispatchorders.prepare', ['dispatchOrder' => $dispatchOrder]) }}" class="ui green label button">
            {{ __('dispatchorders.dispatch_details') }} U
            <i class="right arrow icon"></i>
        </a>
    </x-tbody-item>
    
</x-table-row>