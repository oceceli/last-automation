<div>
    <div class="text-red-600 cursor-default">
        <i class="shipping fast icon"></i>
        <span class="font-bold text-sm">
            {{ __('dispatchorders.there_are_number_of_products_that_need_to_be_prepared', ['number' => $dispatchOrder->dispatchProducts->count()]) }}
        </span>
    </div>

    <x-table class="single line selectable">
        @foreach($dispatchOrder->dispatchProducts as $key => $dp)
            <tr wire:key="dp_tablerow_{{ $key }}" class="@if($dp->isReady()) positive @else negative @endif">
                    
                @include('web.sections.dispatchorders.daily.prepare.table-by-states.common.prepare-table-rows')

                <x-tbody-item class="right aligned">
                    <div class="ui mini buttons">
                        <button wire:click.prevent="openDoLotModal({{ $dp->id }})" class="ui mini red button ">
                            <i class="dolly icon"></i>
                            {{ __('dispatchorders.select_products') }}
                        </button>
                    </div>
                </x-tbody-item>

            </tr>    
        @endforeach
    </x-table>
    

    {{-- Slot of x-content component --}}
    <x-slot name="bottom">
        <div class="flex items-center justify-between shadow rounded p-2 bg-white">
            <div class="text-xs text-ease ">
                <i class="yellow triangle exclamation icon"></i>
                {{ __('dispatchorders.whenever_products_prepared_or_loaded_on_vehicle_then_it_must_be_marked_as_ready') }}
            </div>
        </div>
    </x-slot>
</div>
