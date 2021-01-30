@if ($finalizeModal)
    <div x-data="{finalizeModal: @entangle('finalizeModal')}">
        <x-custom-modal active="finalizeModal" header="{{ $finalizeData->product->name }}">

            <form class="ui tiny form shadow-md" wire:submit.prevent="ConfirmFinalize()">
                <x-form-divider noButtons>

                    <x-slot name="left">
                        <x-dropdown label="{{ __('common.total') }}" iModel="production_total" iPlaceholder="{{ __('stockmoves.total_produced_amount') }}" sClass="basic"
                            model="unit_id" value="id" text="name" :collection="$finalizeData->product->units" placeholder="{{__('modelnames.unit')}}"
                        />
                        <x-input label="{{ __('stockmoves.waste') }}" model="production_waste" placeholder="{{ __('stockmoves.waste_amount')}}">
                            <x-slot name="innerLabel">
                                @if(!empty($selectedUnit)) {{ $selectedUnit->abbreviation }} @else ... @endif
                            </x-slot>
                        </x-input>
                    </x-slot>


                    <x-slot name="right">
                        <div class="h-full">
                            <div class="h-full p-6 flex items-center justify-around flex-col border border-green-200 rounded-sm shadow-inner bg-cool-gray-50">
                                Diğer fireler buraya gelecek
                            </div>
                        </div>
                    </x-slot>
                    
                    
                    <x-slot name="bottom">
                        <div class="h-full p-6 flex items-center justify-around flex-col border border-green-200 rounded-sm shadow-inner bg-cool-gray-50">
                            @if ($production_total)
                                <div class="text-xl font-bold">
                                    <span class="text-ease">{{ (float)$production_total ?? 0 }}</span>
                                    <span class="text-ease-red">- {{ (float)$production_waste ?? 0 }}</span>
                                </div>
                                <div class="text-2xl font-extrabold text-green-800 p-2">
                                    {{ __('common.stock') }}:
                                    {{ (float)$production_total - (int)$production_waste }}
                                    {{ $selectedUnit['name'] }}
                                </div>
                            @else
                                <div class="text-ease p-10"><i class="big calculator icon"></i></div>
                            @endif
                        </div>
                        <div class="pt-5">
                            <button class="ui primary mini button w-full">
                                {{ __('common.do_complete')}}
                            </button>
                        </div>
                    </x-slot>

                </x-form-divider>
            </form>

            <div class="p-4 text-sm text-ease-red" x-data="{confirmation: false}">
                <div x-show="!confirmation">
                    <span @click="confirmation = true" class="cursor-pointer">
                        {{ __('workorders.abort_this_work_order') }}
                    </span>
                    <span data-tooltip="{{ __('workorders.production_results_will_not_be_processed')}}" data-variation="mini" data-position="bottom center">
                        <i class="small circular question mark icon"></i>
                    </span>
                </div>
                <div x-show="confirmation" wire:click="abort({{ $finalizeData->id }})" 
                        class="font-extrabold bg-red-200 text-center border-red-300 text-red-600 cursor-pointer p-2 rounded hover:bg-red-500 ease-in-out hover:text-white duration-200">
                    {{ __('common.abort') }}?
                </div>
            </div>

        </x-custom-modal>
    </div>
@endif