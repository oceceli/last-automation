<div>
    <x-content>



        <div class="p-5">
            {{-- <div class="text-green-500 cursor-default">
                <i class="fast shipping icon"></i>
                <span class="font-bold text-sm">
                    {{ __('dispatchorders.dispatch_process_finalized') }}
                </span>
            </div> --}}
        
        
            <x-table class="single line selectable">       
        
                <x-tbody>
                    @foreach($ingredientCards as $index => $row)
                        <x-table-row wire:key="dp_tablerow_{{ $index }}" class="negative">
                            
                            <x-tbody-item class="two wide">
                                @if ($row['is_ready'])
                                    <span>
                                        <i class="green check circle icon"></i>
                                        <span class="text-sm">{{ __('common.ready') }}</span>
                                    </span>
                                @else
                                    <span>
                                        <i class="red clock icon"></i>
                                        <span class="text-sm">{{ __('dispatchorders.not_prepared_yet') }}</span>
                                    </span>
                                @endif
                            </x-tbody-item>
                            <x-tbody-item class="three wide">
                                <span class="font-bold">{{ $row['ingredient']['prd_code'] }}</span>
                                <span class="text-xs text-ease">{{ $row['ingredient']['prd_name'] }}</span>
                            </x-tbody-item>
                            <x-tbody-item class="">
                                <span class="font-bold">{{ (float)$row['amount'] }} </span>
                                <span class="text-sm">{{ $row['unit']['name'] }}</span>
                            </x-tbody-item>

        
                            <x-tbody-item class="right aligned">
                                <div class="ui mini buttons">
                                    <button wire:click.prevent="openWoLotPickerModal({{ $index }})" class="ui mini red button ">
                                        <i class="dolly icon"></i>
                                        {{ __('dispatchorders.select_products') }}
                                    </button>
                                </div>
                            </x-tbody-item>
        
                        </x-table-row>    
                    @endforeach
                </x-tbody>
        
            </x-table>
                
            
        
            {{-- Slot of x-content component --}}
            <x-slot name="bottom">
                <div class="shadow rounded p-2 bg-white text-xs">
                    <span class="text-ease-green">
                        <i class="check double icon"></i>
                        {{ __('common.approved') }}
                    </span>
                    <span class="text-ease">
                        {{-- - {{ $dispatchOrder->do_actual_datetime }} --}}
                    </span>
        
                </div>
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


    {{-- @if ($reservationViewModal)
        <div x-data="{reservationViewModal: @entangle('reservationViewModal')}">
            <x-custom-modal active="reservationViewModal" header="test">
                <x-reserved-stocks-table :model="$selectedDispatchProduct" class="p-2" />
            </x-custom-modal>
        </div>
    @endif --}}

    
    @include('web.sections.workorders.daily.prepare.work-order-lot-picker')


</div>