<x-table-row class="warning font-bold">
    <x-tbody-item class="center aligned">
        <x-span tooltip="{{ __('dispatchorders.all_products_loaded_into_vehicle_waiting_for_approval') }}" position="top left">
            <i class="checkmark icon"></i>
        </x-span>
    </x-tbody-item>

    @include('web.sections.dispatchorders.daily.table-rows.do-row-common')

    <x-tbody-item class="right aligned">


        <x-menu-dropdown main="{{ __('common.approve') }} S" action="openApproveModal({{ $dispatchOrder->id }})" color="red" icon="tools icon">
            <div wire:click.prevent="redirectPrepare({{ $dispatchOrder->id }})" class="item text-red-600"> 
                <i class="right arrow icon"></i>
                {{ __('dispatchorders.dispatch_details') }} U
            </div>
            {{-- <div wire:click.prevent="redirectPrepare({{ $dispatchOrder->id }})" class="item text-red-600"> 
                <i class="right arrow icon"></i>
                {{ __('dispatchorders.dispatch_details') }} U
            </div> --}}
        </x-menu-dropdown>

    </x-tbody-item>
    
</x-table-row>