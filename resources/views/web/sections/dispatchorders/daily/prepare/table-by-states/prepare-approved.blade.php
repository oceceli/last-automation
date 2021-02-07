<div>
    <div class="text-green-500 cursor-default">
        <i class="fast shipping icon"></i>
        <span class="font-bold text-sm">
            {{ __('dispatchorders.dispatch_process_finalized') }}
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
        <div class="shadow rounded p-2 bg-white text-xs">
            <span class="text-ease-green">
                <i class="check double icon"></i>
                {{ __('common.approved') }}
            </span>
            <span class="text-ease">
                - {{ $dispatchOrder->do_actual_datetime }}
            </span>

        </div>
    </x-slot>
</div>