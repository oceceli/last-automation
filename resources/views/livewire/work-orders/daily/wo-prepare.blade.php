<div>
    <x-content>



        <div class="p-5">
            <div class="text-green-500 cursor-default">
                <i class="fast shipping icon"></i>
                <span class="font-bold text-sm">
                    {{ $workOrder->wo_status }}
                </span>
            </div>
        
            <x-table class="single line selectable">       
                <x-tbody>
                    @foreach($ingredientCards as $index => $row)
                        @if ($this->workOrder->areSourcesReadyFor($row['ingredient']['id']))
                            <x-table-row wire:key="dp_tablerow_{{ $index }}" class="positive">
                            
                                <x-tbody-item class="two wide">
                                    <span>
                                        <i class="green check circle icon"></i>
                                        <span class="text-sm">{{ __('common.ready') }}</span>
                                    </span>
                                </x-tbody-item>
                                <x-tbody-item class="three wide">
                                    <span class="font-bold">{{ $row['ingredient']['prd_code'] }}</span>
                                    <span class="text-xs text-ease">{{ $row['ingredient']['prd_name'] }}</span>
                                </x-tbody-item>
                                <x-tbody-item class="">
                                    <span class="font-bold">{{ number_format($row['amount'], 3, ',', '.') }} </span>
                                    <span class="text-sm">{{ $row['unit']['name'] }}</span>
                                </x-tbody-item>

            
                                <x-tbody-item class="right aligned">
                                    <div class="ui mini buttons">
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
                                    </div>
                                </x-tbody-item>
            
                            </x-table-row>    
                            
                        @else 
                            {{-- DUPLICATION --}}
                            <x-table-row wire:key="dp_tablerow_2_{{ $index }}" class="negative">
                                
                                <x-tbody-item class="two wide">
                                    <span>
                                        <i class="red clock icon"></i>
                                        <span class="text-sm">{{ __('dispatchorders.not_prepared_yet') }}</span>
                                    </span>
                                </x-tbody-item>
                                <x-tbody-item class="three wide">
                                    <span class="font-bold">{{ $row['ingredient']['prd_code'] }}</span>
                                    <span class="text-xs text-ease">{{ $row['ingredient']['prd_name'] }}</span>
                                </x-tbody-item>
                                <x-tbody-item class="">
                                    <span class="font-bold">{{ number_format($row['amount'], 3, ',', '.') }} </span>
                                    <span class="text-sm">{{ $row['unit']['name'] }}</span>
                                </x-tbody-item>

            
                                <x-tbody-item class="right aligned">
                                    <div class="ui mini buttons">
                                        <button wire:click.prevent="openWoLotPickerModal({{ $index }})" class="ui mini red button ">
                                            <i class="box icon"></i>
                                            {{ __('dispatchorders.select_products') }}
                                        </button>
                                    </div>
                                </x-tbody-item>
                        @endif
                        </x-table-row>    
                    @endforeach
                </x-tbody>
        
            </x-table>
                

            <x-slot name="bottom">
                @if ($workOrder->isPreparing() || $workOrder->isActive() || $workOrder->isSuspended())
                    <div class="flex items-center justify-between shadow rounded p-2 bg-white">
                        <div class="text-xs text-ease text-orange-600">
                            <i class=" triangle exclamation icon"></i>
                            {{ __('workorders.mark_as_ready_when_all_sources_picked') }}
                        </div>
                        @if ($workOrder->areAllReady())
                            <button wire:click.prevent="markAsCompleted()" class="ui mini label green button">
                                <i class="checkmark icon"></i>
                                {{ __('dispatchorders.mark_as_prepared') }}
                            </button>
                        @endif
                    </div>
                @elseif($workOrder->isPrepared())
                    <div class="flex items-center justify-between shadow rounded p-2 bg-white">
                        <div class="text-xs text-ease text-green-600">
                            <i class="checkmark icon"></i>
                            {{ __('workorders.all_sources_are_prepared_and_wo_can_get_start') }}
                        </div>
                        <div>
                            <button wire:click.prevent="downgradeToPreparing()" class="ui mini label red button">
                                <i class="undo icon"></i>
                                {{ __('workorders.edit_sources_before_start') }}
                            </button>
                            <button wire:click.prevent="markAsCompleted()" class="ui mini label green button">
                                <i class="play icon"></i>
                                {{ __('workorders.wo_start') }}
                            </button>
                        </div>
                    </div>
                {{-- @elseif($workOrder->isPrepared())
                    <div class="shadow rounded p-2 bg-white">
                        <div class="text-xs text-ease text-orange-600">
                            <i class=" triangle exclamation icon"></i>
                            {{ __('workorders.mark_as_ready_when_all_sources_picked') }}
                        </div>
                    </div> --}}
                @endif
            </x-slot>



        </div>
        

        {{-- <div class="p-5">
            @switch($dispatchOrder)
                @case($dispatchOrder->isApproved())
                    @include('web.sections.dispatchorders.daily.prepare.table-by-states.prepare-approved')
                    @break
                @case($dispatchOrder->isCompleted())
                    @include('web.sections.dispatchorders.daily.prepare.table-by-states.prepare-completed')
                    @break
                @case($dispatchOrder->isInProgress())
                    @include('web.sections.dispatchorders.daily.prepare.table-by-states.prepare-inprogress')
                    @break
                @case($dispatchOrder->isActive())
                    @include('web.sections.dispatchorders.daily.prepare.table-by-states.prepare-active')
                    @break
                @case($dispatchOrder->isSuspended())
                    @include('web.sections.dispatchorders.daily.prepare.table-by-states.prepare-suspended')
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