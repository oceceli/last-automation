<div>
    <div class="text-orange-500 cursor-default">
        <i class="shipping fast icon"></i>
        <span class="font-bold text-sm">
            {{ __('dispatchorders.products_preparing', ['number' => $dispatchOrder->dispatchProducts->count()]) }}
        </span>
    </div>

    <x-table class="single line selectable">
        @foreach($dispatchOrder->dispatchProducts as $key => $dp)
            <tr wire:key="dp_tablerow_{{ $key }}" class="@if($dp->isReady()) warning @else negative @endif">
                    
                @include('web.sections.dispatchorders.daily.prepare.table-by-states.common.prepare-table-rows')

                <x-tbody-item class="right aligned">
                    <div class="ui mini buttons">
                        @if ($dp->isReady())
                            <button wire:key="empty_{{$key}}" wire:click.prevent="emptyDpReserveds({{ $dp->id }})"  class="ui mini orange basic icon button" data-tooltip="{{ __('dispatchorders.unload_products') }}" data-position="top right" data-variation="mini">
                                <i class="red trash alternate link icon"></i>
                            </button>
                            <button wire:key="viewModal_{{$key}}" wire:click.prevent="openReservationViewModal({{ $dp->id }})" class="ui  icon basic orange button ">
                                <i class="eye icon"></i>
                            </button>
                            <button wire:key="doLotModal_{{$key}}" wire:click.prevent="openDoLotModal({{ $dp->id }})" class="ui mini orange button ">
                                <i class="dolly icon"></i>
                                {{ __('common.edit') }}
                            </button>
                        @else 
                            <button wire:key="doLotModal2_{{$key}}" wire:click.prevent="openDoLotModal({{ $dp->id }})" class="ui mini red button ">
                                <i class="dolly icon"></i>
                                {{ __('dispatchorders.select_products') }}
                            </button>
                        @endif
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
            @if ($dispatchOrder->isAllReady())
                <button wire:click.prevent="markAsCompleted()" class="ui mini label green button">
                    <i class="checkmark icon"></i>
                    {{ __('dispatchorders.mark_as_prepared') }}
                </button>
            @endif
        </div>
    </x-slot>
</div>
