@if ($woLotPickerModal)
    <div x-data="{woLotPickerModal: @entangle('woLotPickerModal')}">
        <x-custom-modal active="woLotPickerModal">
            
            
            <x-slot name="header">
                <div>
                    {{ $selectedProduct->prd_code}}
                    <span class="text-sm">({{ $selectedProduct->prd_name}})</span>
                </div>
            </x-slot>

            @if ($selectedProduct->isInStock)
                <div class="bg-white" wire:key="do_{{ $selectedProduct }}">
                    <div class="py-3 px-4 shadow font-bold text-sm flex justify-between">
                        <div>
                            <span>{{ __('dispatchorders.total_covered') }}:</span>
                            <span class="text-green-600">
                                {{ $this->coveredAmount() }} /
                                <span class="text-ease">
                                    {{ $this->getToBase()['amount'] }}
                                    {{ $selectedProduct->baseUnit->name }}
                                </span>
                            </span>
                        </div>
                        <div>
                            @if ($this->necessaryAmount() == 0)
                                <span class="text-sm text-green-600">
                                    <i class="checkmark icon"></i>
                                    {{ __('dispatchorders.sources_are_enough') }}
                                </span>
                            @else
                                <span>{{ __('dispatchorders.needed_amount' )}}:</span>
                                <span class="text-red-600">
                                    {{ $this->necessaryAmount() }}
                                    {{ $selectedProduct->baseUnit->name }}
                                </span>
                            @endif
                        </div>
                    </div>

                        <div class="p-6 shadow-md flex flex-col gap-8 md:gap-4">
                            @foreach ($rows as $key => $row)
                                <div wire:key="row_{{ $key }}" class="flex flex-col md:flex-row gap-3 border border-dashed p-3 rounded-lg hover:border-orange-400 ease-in-out duration-200">
                                    {{-- <x-dropdown model="rows.{{$key}}.lot_number" :collection="$selectedProduct->lots" value="lot_number" text="lot_number,available_amount_string" sClass="search" 
                                        placeholder="{{ __('dispatchorders.lot_number') }}" sId="do_lot{{ $key }}" noErrors  /> --}}
                                    <select class="form-select text-sm flex-1" wire:model.prevent="rows.{{$key}}.lot_number">
                                        <option value="" selected>{{ __('dispatchorders.select_lot_number') }}</option>
                                        @foreach ($selectedProduct->lots as $index => $lot)
                                            <option value="{{ $lot['lot_number'] }}" class="text-red-700 font-bold">
                                                <span>{{ $lot['lot_number'] }}</span> | 
                                                <span class="text-xs">{{ __('common.available' )}}: {{ $lot['available_amount_string'] }}</span>
                                                @if($lot['reserved_amount'])
                                                    | {{ __('workorders.reserved') }}: {{ $lot['reserved_amount_string'] }}
                                                @endif
                                            </option>
                                        @endforeach
                                    </select>
                                        
                                    <div class="flex gap-4">
                                        @if ($this->inputDisabled($key))
                                            <x-input wire:key="reservedamountinput_{{$key}}" type="number" model="rows.{{$key}}.reserved_amount" placeholder="{{ __('common.amount') }}" innerLabel="{{ $selectedProduct->baseUnit->name }}" iClass="disabled" noErrors class="ui tiny input flex-1" />
                                        @else
                                            <x-input wire:key="reservedamountinput_{{$key}}" type="number" model="rows.{{$key}}.reserved_amount" placeholder="{{ __('common.amount') }}" innerLabel="{{ $selectedProduct->baseUnit->name }}" noErrors class="ui tiny input flex-1" />
                                        @endif
                                        <div  class="flex items-center w-1/12 justify-center">
                                            <i wire:click="removeRow({{ $key }})" class=" cancel red icon @if($this->cannotRemoveRow()) disabled @else cursor-pointer link @endif"></i>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        <div class="flex p-3">
                            <button wire:click="submitLots()" class="ui mini orange w-full button @if($this->cannotSubmit()) disabled @endif">
                                {{ __('common.save') }}
                            </button>
                            <button wire:click="addRow()" class="ui mini icon button @if($this->cannotAddRow()) disabled @endif">
                                <i class="orange plus icon"></i>
                            </button>
                        </div>

                        <x-error-area class="p-4 shadow-inner" />
                </div>
            @else 
                <div class="p-4 shadow-inner bg-red-500">
                    <i class="text-white exclamation triangle icon"></i>
                    <i class="text-white font-bold">{{ __('inventory.out_of_stock') }}</i>
                </div>
            @endif


        </x-custom-modal>
    </div>
@endif