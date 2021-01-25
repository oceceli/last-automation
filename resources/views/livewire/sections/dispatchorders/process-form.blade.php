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
                            {{ __('dispatchorders.there_are_number_variety_of_products_which_is_waiting_for_the_dispatch', ['number' => $dispatchOrder->reservedStocks->count()]) }}
                        </span>
                    </div>
                    <div class="text-xs text-ease">!!! İlgili ürünün üzerine tıklayarak lot numaralarını belirtebilirsiniz</div>
                    <div class="mt-2 p-2 border shadow-inner rounded border-red-200">
                        @foreach($dispatchOrder->reservedStocks as $key => $reservation)
                            <div wire:click.prevent="openDoLotModal({{ $reservation->id }})" class="font-bold hover:bg-orange-200 hover:shadow p-1 rounded cursor-pointer">
                                <span class="text-blue-600">{{ $reservation->product->code }}</span>
                                <span class="text-xs text-ease">{{ $reservation->product->name }}</span>
                                <span>- {{ $reservation->reserved_amount }} {{ $reservation->product->baseUnit->name }}</span>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </x-content>

    
    @if ($doLotModal)
        <div x-data="{doLotModal: @entangle('doLotModal')}">
            <x-custom-modal active="doLotModal" header="!!! header">

                <div class="bg-cool-gray-50">
                    <div class="flex flex-col gap-5">
                        {{-- @foreach ($dispatchOrder->reservedStocks as $index => $reservation) --}}
                            <div class="bg-white shadow-md relative p-3" wire:key="do_{{ $selectedReservation->id }}">
                                <div class="border-b border-dashed pb-2 flex justify-between font-bold">
                                    <div>
                                        {{ $selectedReservation->product->code}} -
                                        {{ $selectedReservation->product->name}}
                                    </div>
                                    <div class="text-red-700">
                                        {{ $selectedReservation->reserved_amount }}
                                        {{ $selectedReservation->product->baseUnit->name }}
                                    </div>
                                </div>
                                @if ($selectedReservation->product->isInStock)
                                    <div class="mt-2">
                                        @foreach ($cards as $key => $card)
                                            <div wire:key="card_{{ $key }}" class="ui tiny form">
                                                <div class="equal width fields">
                                                    <x-dropdown model="cards.{{$key}}.lot_number" :collection="$selectedReservation->product->lots" value="lot_number" text="lot_number,available_amount_string" sClass="search" 
                                                        placeholder="{{ __('dispatchorders.lot_number') }}" sId="do_lot{{ $key }}" noErrors  />
                                                        
                                                    <x-input model="cards.{{$key}}.reserved_amount" placeholder="{{ __('common.amount') }}" innerLabel="{{ $selectedReservation->product->baseUnit->name }}">
                                                        
                                                    </x-input>
                                                    <div wire:click="removeCard({{ $key }})" class="flex items-center w-1/12 cursor-pointer justify-center">
                                                        <i class="large link cancel red icon"></i>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                        <div class="w-full flex border-t pt-3">
                                            <button wire:click="submitLots()" class="ui mini primary w-full button">
                                                !!Kaydet
                                            </button>
                                            <button wire:click="addCard()" class="ui green mini icon button">
                                                <i class="white plus icon"></i>
                                            </button>
                                        </div>
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