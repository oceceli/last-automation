<div x-data="{seePrepared: false}">
    <div class="text-orange-600 cursor-default">
        <i class="shipping fast icon"></i>
        <span class="font-bold">
            {{ __('dispatchorders.there_are_number_variety_of_products_which_is_waiting_for_the_dispatch', ['number' => $dispatchOrder->dispatchProducts->count()]) }}
        </span>
    </div>

    <x-table class="single line selectable orange">
        @include('web.sections.dispatchorders.daily.prepare.table-by-states.prepare-common')
        <x-tbody>
            @foreach($dispatchOrder->dispatchProducts as $key => $dp)
                <x-tbody-item class="collapsing center aligned one wide">
                    <x-span tooltip="{{ __('common.ready') }}" position="top left">
                        <i class="green check circle icon"></i>
                    </x-span>
                </x-tbody-item>
                <x-tbody-item class="three wide">
                    <span class="font-bold">{{ $dp->product->code }}</span>
                    <span class="text-xs text-ease">{{ $dp->product->name }}</span>
                </x-tbody-item>
                <x-tbody-item class="">
                    <span class="font-bold">{{ (float)$dp->dp_amount }} </span>
                    <span class="text-sm">{{ $dp->product->baseUnit->name }}</span>
                </x-tbody-item>
                <x-tbody-item class="right aligned">
                    <div class="ui mini buttons">
                        <button @click="seePrepared = true" class="ui mini basic icon button" data-tooltip="{{ __('dispatchorders.see_prepared_products') }}" data-position="top right" data-variation="mini">
                            <i class="eye icon"></i>
                        </button>
                        <button wire:click.prevent="emptyDpReserveds({{ $dp->id }})"  class="ui mini red icon button" data-tooltip="{{ __('dispatchorders.unload_products') }}" data-position="top right" data-variation="mini">
                            <i class="white trash alternate link icon"></i>
                        </button>
                        <button wire:click.prevent="openDoLotModal({{ $dp->id }})" class="ui mini orange button ">
                            <i class="dolly icon"></i>
                            @if ($dp->isReady())
                            {{ __('common.edit') }}
                            @else
                            {{ __('dispatchorders.select_products') }}
                            @endif
                        </button>
                    </div>
                    <div wire:key="seePreparedModal_{{ $key }}">
                        <x-custom-modal active="seePrepared" header="{{ __('validation.attributes.do_number') }}: {{ $dispatchOrder->do_number}} - {{ $dispatchOrder->address->adr_name }}">
                            <x-reserved-stocks-table :model="$dp" class="p-3" />
                            {{-- <div class="p-3 text-left text-orange-600">
                                <i class="small info icon"></i>
                                <span class="font-bold text-sm">{{ __('dispatchorders.preparing_or_loading_on_vehicle_in_progress') }}</span>
                            </div> --}}
                        </x-custom-modal>
                    </div>
                </x-tbody-item>
                @endforeach
            </x-tbody>
        </x-table>
        
        


    {{-- Slot of x-content component --}}
    <x-slot name="bottom">
        <div class="flex items-center justify-between shadow rounded p-2 bg-white">
            <div class="text-xs text-ease ">
                <i class="yellow triangle exclamation icon"></i>
                {{ __('dispatchorders.whenever_products_prepared_or_loaded_on_vehicle_then_it_must_be_marked_as_ready') }}
            </div>
            @if ($dispatchOrder->isAllReady())
                <button wire:click.prevent="markAsCompleted()" class="ui mini label green button">
                    <i class="checkmark icon"></i>
                    {{ __('dispatchorders.mark_as_prepared') }}
                </button>
            @endif
        </div>
    </x-slot>
</div>