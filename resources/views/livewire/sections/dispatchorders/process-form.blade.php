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
                        @foreach($dispatchOrder->dispatchProducts as $key => $reservation)
                            <div class="flex gap-4 justify-between items-center">
                                <div wire:click.prevent="openDoLotModal({{ $reservation->id }})" class="font-bold hover:bg-orange-200 hover:shadow p-1 rounded cursor-pointer flex-1">
                                    <span class="text-blue-600">{{ $reservation->product->code }}</span>
                                    <span class="text-xs text-ease">{{ $reservation->product->name }}</span>
                                    <span>- {{ $reservation->dp_amount }} {{ $reservation->product->baseUnit->name }}</span>
                                </div>
                                <x-span tooltip="{{ __('dispatchorders.ready_to_dispatch') }}" position="left center">
                                    <i class="green checkmark icon"></i>
                                </x-span>
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
                        {{ $dispatchPivot->product->code}}
                        <span class="text-sm">({{ $dispatchPivot->product->name}})</span>
                    </div>
                </x-slot>

                <div class="bg-white" wire:key="do_{{ $dispatchPivot->id }}">
                    <div class="p-3 shadow font-bold text-sm flex justify-between">
                        <div>
                            <span>{{ __('dispatchorders.total_covered') }}:</span>
                            <span class="text-green-600">
                                {{ $this->coveredAmount() }} /
                                <span class="text-ease">
                                    {{ $dispatchPivot->dp_amount }}
                                    {{ $dispatchPivot->product->baseUnit->name }}
                                </span>
                            </span>
                        </div>
                        <div>
                            @if ($this->necessaryAmount() == 0)
                                <span class="text-sm text-ease-green">
                                    <i class="checkmark icon"></i>
                                    {{ __('dispatchorders.sources_are_enough') }}
                                </span>
                            @else
                                <span>{{ __('dispatchorders.needed_amount' )}}:</span>
                                <span class="text-red-600">
                                    {{ $this->necessaryAmount() }}
                                    {{ $dispatchPivot->product->baseUnit->name }}
                                </span>
                            @endif
                        </div>
                    </div>

                    @if ($dispatchPivot->product->isInStock)
                        <div class="p-6 shadow-md flex flex-col gap-8 md:gap-4">
                            @foreach ($cards as $key => $card)
                                <div wire:key="card_{{ $key }}" class="flex flex-col md:flex-row gap-3 border border-dashed p-3 rounded-lg hover:border-orange-400 ease-in-out duration-200">
                                    {{-- <x-dropdown model="cards.{{$key}}.lot_number" :collection="$dispatchPivot->product->lots" value="lot_number" text="lot_number,available_amount_string" sClass="search" 
                                        placeholder="{{ __('dispatchorders.lot_number') }}" sId="do_lot{{ $key }}" noErrors  /> --}}
                                    <select class="form-select text-sm flex-1" wire:model="cards.{{$key}}.lot_number">
                                        <option selected>{{ __('dispatchorders.select_lot_number') }}</option>
                                        @foreach ($dispatchPivot->product->lots as $index => $lot)
                                            <option value="{{ $lot['lot_number'] }}" class="text-red-700 font-bold">
                                                {{ $lot['lot_number'] }} | {{ __('inventory.in_stock')}}: {{ $lot['available_amount_string'] }}
                                            </option>
                                        @endforeach
                                    </select>
                                        
                                    <div class="flex gap-4">
                                        @if ($this->inputDisabled($key))
                                            <x-input wire:key="reservedamountinput_{{$key}}" type="number" model="cards.{{$key}}.reserved_amount" placeholder="{{ __('common.amount') }}" innerLabel="{{ $dispatchPivot->product->baseUnit->name }}" iClass="disabled" noErrors class="ui tiny input flex-1" />
                                        @else
                                            <x-input wire:key="reservedamountinput_{{$key}}" type="number" model="cards.{{$key}}.reserved_amount" placeholder="{{ __('common.amount') }}" innerLabel="{{ $dispatchPivot->product->baseUnit->name }}" noErrors class="ui tiny input flex-1" />
                                        @endif
                                        <div  class="flex items-center w-1/12 justify-center">
                                            <i wire:click="removeCard({{ $key }})" class="large cancel red icon @if($this->cannotRemoveCard()) disabled @else cursor-pointer link @endif"></i>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        <div class="flex p-3">
                            <button wire:click="submitLots()" class="ui mini orange w-full button @if($this->cannotSubmit()) disabled @endif">
                                {{ __('common.save') }}
                            </button>
                            <button wire:click="addCard()" class="ui black mini icon button @if($this->cannotAddCard()) disabled @endif">
                                <i class="white plus icon"></i>
                            </button>
                        </div>

                        <x-error-area class="p-4 shadow-inner" />

                    @else 
                        <div class="mt-4 p-4 bg-red-100 shadow-inner">
                            <i class="text-ease">{{ __('inventory.out_of_stock') }}</i>
                        </div>
                    @endif
                </div>

            </x-custom-modal>
        </div>
    @endif


</div>