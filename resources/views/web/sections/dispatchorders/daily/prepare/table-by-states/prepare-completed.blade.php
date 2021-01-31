<div>
    <div class="text-green-500 cursor-default">
        <i class="fast shipping icon"></i>
        <span class="font-bold text-sm">
            {{ __('dispatchorders.products_are_ready_to_dispatch') }}    
        </span>
    </div>


    <x-table class="single line selectable">       

        <x-tbody>
            @foreach($dispatchOrder->dispatchProducts as $key => $dp)
                <x-table-row wire:key="dp_tablerow_{{ $key }}" class="positive">
                    
                    @include('web.sections.dispatchorders.daily.prepare.table-by-states.common.prepare-table-rows')

                    <x-tbody-item class="right aligned">
                        <div class="ui mini buttons">
                            <button wire:click.prevent="openReservationViewModal({{ $dp->id }})" class="ui mini icon basic button ">
                                <i class="eye icon"></i>
                            </button>
                        </div>
                    </x-tbody-item>

                </x-table-row>    
            @endforeach
        </x-tbody>

    </x-table>
        
    

    {{-- Slot of x-content component --}}
    <x-slot name="bottom">
        <div class="flex items-center justify-between shadow rounded p-2 bg-white">
            <div class="text-xs text-ease-red font-bold">
                <i class="checkmark icon"></i>
                {{ __('dispatchorders.all_products_prepared_or_loaded_into_vehicle_waiting_for_approval') }}
            </div>
        </div>
    </x-slot>
</div>