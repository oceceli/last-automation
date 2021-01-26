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
                            <div wire:click.prevent="openDoLotModal({{ $reservation->id }})" class="font-bold hover:bg-orange-200 hover:shadow p-1 rounded cursor-pointer">
                                <span class="text-blue-600">{{ $reservation->product->code }}</span>
                                <span class="text-xs text-ease">{{ $reservation->product->name }}</span>
                                <span>- {{ $reservation->dp_amount }} {{ $reservation->product->baseUnit->name }}</span>
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

                <div class="bg-cool-gray-50">
                    <div class="flex flex-col gap-5">
                        {{-- @foreach ($dispatchOrder->reservedStocks as $index => $reservation) --}}
                            <div class="bg-white shadow-md relative" wire:key="do_{{ $dispatchPivot->id }}">
                                <div class="border-b border-dashed pb-2 font-bold p-3">
                                    <x-slot name="header">
                                        <div>
                                            {{ $dispatchPivot->product->code}}
                                            <span class="text-ease text-xs">({{ $dispatchPivot->product->name}})</span> -
                                            <span>
                                                <span class="">
                                                    {{ $dispatchPivot->dp_amount }}
                                                    {{ $dispatchPivot->product->baseUnit->name }}
                                                </span>
                                            </span>
                                        </div>
                                    </x-slot>
                                    <div>
                                        <span class="text-ease text-xs">
                                            {{ __('dispatchorders.total_covered') }}:
                                        </span>
                                        <span class="text-green-800 text-sm">
                                            {{ $this->coveredAmount() }}
                                            {{ $dispatchPivot->product->baseUnit->name }}
                                        </span>
                                    </div>
                                    <div class="text-ease">
                                        <span class="text-xs">{{ __('dispatchorders.needed_amount' )}}</span>:
                                        <span class="font-bold text-sm text-red-600">
                                            {{ $dispatchPivot->dp_amount - $this->coveredAmount() }}
                                            {{ $dispatchPivot->product->baseUnit->name }}
                                        </span>
                                    </div>
                                </div>
                                @if ($dispatchPivot->product->isInStock)
                                    <div class="mt-2 py-4 px-6 shadow flex flex-col gap-6">
                                        @foreach ($cards as $key => $card)
                                            <div wire:key="card_{{ $key }}">
                                                <div class="flex flex-col md:flex-row gap-4">
                                                    {{-- <x-dropdown model="cards.{{$key}}.lot_number" :collection="$dispatchPivot->product->lots" value="lot_number" text="lot_number,available_amount_string" sClass="search" 
                                                        placeholder="{{ __('dispatchorders.lot_number') }}" sId="do_lot{{ $key }}" noErrors  /> --}}
                                                    <select class="form-select text-xs flex-1" wire:model="cards.{{$key}}.lot_number">
                                                        <option selected>{{ __('dispatchorders.select_lot_number') }}</option>
                                                        @foreach ($dispatchPivot->product->lots as $lot)
                                                            <option value="{{ $lot['lot_number'] }}" class="text-red-700 font-bold">
                                                                {{ $lot['lot_number'] }} | {{ __('inventory.in_stock')}}: {{ $lot['available_amount_string'] }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                        
                                                    <div class="flex gap-4">
                                                        <x-input model="cards.{{$key}}.reserved_amount" placeholder="{{ __('common.amount') }}" innerLabel="{{ $dispatchPivot->product->baseUnit->name }}" class="ui tiny input flex-1" />
                                                        <div  class="flex items-center w-1/12 justify-center">
                                                            <i wire:click="removeCard({{ $key }})" class="large cancel red icon @if($this->cannotRemoveCard()) disabled @else cursor-pointer link @endif"></i>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                    <div class="w-full flex border-t p-3 bg-gray-100">
                                        <button wire:click="submitLots()" class="ui mini primary w-full button @if($this->cannotSubmit()) disabled @endif">
                                            {{ __('common.save') }}
                                        </button>
                                        <button wire:click="addCard()" class="ui green mini icon button @if($this->cannotAddCard()) disabled @endif">
                                            <i class="white plus icon"></i>
                                        </button>
                                    </div>
                                @else 
                                    <div class="mt-4 p-4 bg-red-100 shadow-inner">
                                        <i class="text-ease">{{ __('inventory.out_of_stock') }}</i>
                                    </div>
                                @endif
                            </div>
                        {{-- @endforeach --}}
                    </div>
                </div>

            </x-custom-modal>
        </div>
    @endif


</div>



{{-- <x-page-header header="test">
    <x-slot name="buttons">
        <div class="ui mini icon buttons">
            <button wire:click.prevent="addCard" class="ui mini teal button" data-tooltip="{{ __('sections/recipes.add_ingredients') }}" data-variation="mini">
                <i class="plus icon"></i>
            </button>
        </div>
    </x-slot>
</x-page-header> --}}