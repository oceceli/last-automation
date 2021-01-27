<div>
    <x-content>
        <div>
            
            {{-- <h5 class="">
                {{ __('dispatchorders.dispatch_address') }}
            </h5> --}}

            <div class="m-4 p-5 border rounded-sm shadow-lg relative bg-teal-1000">
                <div class="flex justify-between border-b border-white text-ease pb-2">
                    <div>
                        <h5 class="">
                            {{ $dispatchOrder->company->cmp_commercial_title }}
                        </h5>
                    </div>
                    <div>
                        <span class="text-xs">{{ __('dispatchorders.dispatch') }}</span>:
                        <span class="">
                            {{ $dispatchOrder->do_number }}
                        </span>
                    </div>
                </div>

                <div>
                    <div class="flex flex-col py-2 gap-2 text-ease">
                        <span>{{ $dispatchAddress }}</span>
                        <div>{{ __('validation.attributes.adr_phone') }}: {{ $dispatchOrder->address->adr_phone }}</div>
                    </div>
                    @if ($dispatchOrder->do_note)
                        <div class="mt-4 p-2 border rounded shadow">
                            <i class="comment alternate outline flipped icon"></i>
                            <i class="text-green-700">“{{ $dispatchOrder->do_note }}”</i>
                        </div>
                    @endif
                </div>
            </div>


            <div class="py-5 px-4">
                <div>
                    <div class="text-red-700 cursor-default">
                        <i class="shipping fast icon"></i>
                        <span class="font-bold">
                            {{ __('dispatchorders.there_are_number_variety_of_products_which_is_waiting_for_the_dispatch', ['number' => $dispatchOrder->dispatchProducts->count()]) }}
                        </span>
                    </div>
                    <div class="text-xs text-ease">!!! İlgili ürünün üzerine tıklayarak lot numaralarını belirtebilirsiniz</div>
                    <div class="mt-2 p-2 border shadow-inner rounded border-red-200">
                        @foreach($dispatchOrder->dispatchProducts as $key => $dispatchProduct)
                            <div class="pl-3 flex gap-4 justify-between items-center">
                                <div>
                                    @if (optional($dispatchProduct)->isReady())
                                        <x-span tooltip="{{ __('dispatchorders.ready_to_dispatch') }}" position="top left">
                                            <i class="green checkmark icon"></i>
                                        </x-span>
                                    @else
                                        <x-span tooltip="{{ __('dispatchorders.lot_sources_not_specified_yet') }}" position="top left">
                                            <i class="orange wait icon"></i>
                                        </x-span>
                                    @endif
                                </div>
                                <div wire:click.prevent="openDoLotModal({{ $dispatchProduct->id }})" class="font-bold hover:bg-orange-100 hover:shadow p-1 rounded cursor-pointer flex-1">
                                    <span class="text-blue-600">{{ $dispatchProduct->product->code }}</span>
                                    <span class="text-xs text-ease">{{ $dispatchProduct->product->name }}</span>
                                    <span>- {{ $dispatchProduct->dp_amount }} {{ $dispatchProduct->product->baseUnit->name }}</span>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>


        </div>
    </x-content>

    



    @if ($doLotModal)
        <div x-data="{doLotModal: @entangle('doLotModal')}">
            <x-custom-modal active="doLotModal">

                <x-slot name="header">
                    <div>
                        {{ $selectedDispatchProduct->product->code}}
                        <span class="text-sm">({{ $selectedDispatchProduct->product->name}})</span>
                    </div>
                </x-slot>

                @if ($selectedDispatchProduct->product->isInStock)
                    <div class="bg-white" wire:key="do_{{ $selectedDispatchProduct->id }}">
                        <div class="py-3 px-4 shadow font-bold text-sm flex justify-between">
                            <div>
                                <span>{{ __('dispatchorders.total_covered') }}:</span>
                                <span class="text-green-600">
                                    {{ $this->coveredAmount() }} /
                                    <span class="text-ease">
                                        {{ $selectedDispatchProduct->dp_amount }}
                                        {{ $selectedDispatchProduct->product->baseUnit->name }}
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
                                        {{ $selectedDispatchProduct->product->baseUnit->name }}
                                    </span>
                                @endif
                            </div>
                        </div>

                            <div class="p-6 shadow-md flex flex-col gap-8 md:gap-4">
                                @foreach ($rows as $key => $row)
                                    <div wire:key="row_{{ $key }}" class="flex flex-col md:flex-row gap-3 border border-dashed p-3 rounded-lg hover:border-orange-400 ease-in-out duration-200">
                                        {{-- <x-dropdown model="rows.{{$key}}.lot_number" :collection="$selectedDispatchProduct->product->lots" value="lot_number" text="lot_number,available_amount_string" sClass="search" 
                                            placeholder="{{ __('dispatchorders.lot_number') }}" sId="do_lot{{ $key }}" noErrors  /> --}}
                                        <select class="form-select text-sm flex-1" wire:model="rows.{{$key}}.lot_number">
                                            <option value="" selected>{{ __('dispatchorders.select_lot_number') }}</option>
                                            @foreach ($selectedDispatchProduct->product->lots as $index => $lot)
                                                <option value="{{ $lot['lot_number'] }}" class="text-red-700 font-bold">
                                                    {{ $lot['lot_number'] }} | {{ __('inventory.in_stock')}}: {{ $lot['available_amount_string'] }}
                                                </option>
                                            @endforeach
                                        </select>
                                            
                                        <div class="flex gap-4">
                                            @if ($this->inputDisabled($key))
                                                <x-input wire:key="reservedamountinput_{{$key}}" type="number" model="rows.{{$key}}.reserved_amount" placeholder="{{ __('common.amount') }}" innerLabel="{{ $selectedDispatchProduct->product->baseUnit->name }}" iClass="disabled" noErrors class="ui tiny input flex-1" />
                                            @else
                                                <x-input wire:key="reservedamountinput_{{$key}}" type="number" model="rows.{{$key}}.reserved_amount" placeholder="{{ __('common.amount') }}" innerLabel="{{ $selectedDispatchProduct->product->baseUnit->name }}" noErrors class="ui tiny input flex-1" />
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


</div>