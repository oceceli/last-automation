<div>
    <x-content>

        <div class="p-5">
            <div class="{{ $classes['statusClass'] }} cursor-default">
                <i class="{{ $classes['statusIcon'] }}"></i>
                <span class="font-bold text-sm">
                    {{ __("workorders.{$workOrder->getStatus()}") }}
                </span>
            </div>
        
            <x-table class="single line selectable">       
                <x-tbody>
                    @foreach($ingredientCards as $index => $card)
                        @if ($this->isRowReady($index))
                            <tr wire:key="dp_tablerow_{{ $index }}" class="positive">
                        @else 
                            <tr wire:key="dp_tablerow_{{ $index }}" class="negative">
                        @endif
                                <x-tbody-item class="two wide">
                                    <span>
                                        @if ($this->isRowReady($index))
                                            <i class="green check circle icon"></i>
                                            <span class="text-sm">{{ __('common.ready') }}</span>
                                        @else
                                            <i class="red clock icon"></i>
                                            <span class="text-sm">{{ __('dispatchorders.not_prepared_yet') }}</span>
                                        @endif
                                    </span>
                                </x-tbody-item>
                                <x-tbody-item class="three wide">
                                    <span class="font-bold">{{ $card['ingredient']['prd_code'] }}</span>
                                    <span class="text-xs text-ease">{{ $card['ingredient']['prd_name'] }}</span>
                                </x-tbody-item>
                                <x-tbody-item class="">
                                    <span class="font-bold">{{ number_format($card['amount'], 3, ',', '.') }} </span>
                                    @if (! $card['ingredient']['pivot']['literal'])
                                        ± %{{ $workOrder->product->recipe->tolerance_factor }}
                                    @endif
                                    <span class="text-sm">{{ $card['unit']['name'] }}</span>
                                </x-tbody-item>
                                <x-tbody-item class="right aligned">
                                    <div class="ui mini buttons">
                                        @if ($workOrder->isActive() || $workOrder->isPreparing())
                                            @if ($this->isRowReady($index))
                                                <button wire:key="empty_{{$index}}" wire:click.prevent="emptyIngredientReserveds({{ $index }})"  class="ui mini orange basic icon button" data-tooltip="{{ __('dispatchorders.unload_products') }}" data-position="left center" data-variation="mini">
                                                    <i class="red trash alternate link icon"></i>
                                                </button>
                                                <button wire:key="viewModal_{{$index}}" wire:click.prevent="openReservationViewModal({{ $index }})" class="ui  icon basic orange button ">
                                                    <i class="eye icon"></i>
                                                </button>
                                                <button wire:click.prevent="openWoLotPickerModal({{ $index }})" class="ui mini orange button ">
                                                    <i class="open box icon"></i>
                                                    {{ __('common.look_over') }}
                                                </button>
                                            @else
                                                <button wire:click.prevent="openWoLotPickerModal({{ $index }})" class="ui mini red button ">
                                                    <i class="box icon"></i>
                                                    {{ __('dispatchorders.select_products') }}
                                                </button>
                                            @endif
                                        @else
                                            <button wire:key="viewModal_{{$index}}" wire:click.prevent="openReservationViewModal({{ $index }})" class="ui  icon basic orange button ">
                                                <i class="eye icon"></i>
                                            </button>
                                        @endif
                                    </div>
                                </x-tbody-item>
            
                            </tr>    
                            
                    @endforeach
                </x-tbody>
        
            </x-table>
                

            <x-slot name="bottom">

                <div class="flex items-center justify-between shadow rounded p-2 bg-white">

                    <div class="text-xs text-ease {{ $classes['statusClass'] }}">
                        <i class="triangle exclamation icon"></i>
                        {{ $classes['explanation'] }}
                    </div>

                    @if ($workOrder->isPreparing())
                        @if ($workOrder->areAllReady())
                            <button wire:click.prevent="markAsCompleted()" class="ui mini label green button">
                                <i class="checkmark icon"></i>
                                {{ __('dispatchorders.mark_as_prepared') }}
                            </button>
                        @endif

                    @elseif($workOrder->isPrepared())
                        <div>
                            <button wire:click.prevent="downgradeToPreparing()" class="ui mini label red button">
                                <i class="undo icon"></i>
                                {{ __('workorders.edit_sources_before_start') }}
                            </button>
                            {{-- <button wire:click.prevent="woStart()" class="ui mini label green button">
                                <i class="play icon"></i>
                                {{ __('workorders.wo_start') }}
                            </button> --}}
                        </div>
                    @endif

                </div>

            </x-slot>

        </div>
        

        {{-- <div class="p-5">
            @switch($workOrder)
                @case($workOrder->isApproved())
                    @include('web.sections.workorders.daily.prepare.table-by-states.wo-prepare-approved')
                    @break
                @case($workOrder->isCompleted())
                    @include('web.sections.workorders.daily.prepare.table-by-states.wo-prepare-completed')
                    @break
                @case($workOrder->isInProgress())
                    @include('web.sections.workorders.daily.prepare.table-by-states.wo-prepare-inprogress')
                    @break
                @case($workOrder->isPrepared())
                    @include('web.sections.workorders.daily.prepare.table-by-states.wo-prepare-prepared')
                    @break
                @case($workOrder->isPreparing())
                    @include('web.sections.workorders.daily.prepare.table-by-states.wo-prepare-preparing')
                    @break
                @case($workOrder->isActive())
                    @include('web.sections.workorders.daily.prepare.table-by-states.wo-prepare-active')
                    @break
                @case($workOrder->isSuspended())
                    @include('web.sections.workorders.daily.prepare.table-by-states.wo-prepare-suspended')
                    @break
                @default
            @endswitch
        </div> --}}

    </x-content>



    @if ($reservationViewModal)
        <div x-data="{reservationViewModal: @entangle('reservationViewModal')}">
            <x-custom-modal active="reservationViewModal" header="{{ $selectedIngredient->prd_name }}">
                <x-reserved-stocks-table :reservations="$workOrder->reservationsFor($selectedIngredient->id)->get()" class="p-2" />
            </x-custom-modal>
        </div>
    @endif
    
    @include('web.sections.workorders.daily.prepare.work-order-lot-picker')


</div>