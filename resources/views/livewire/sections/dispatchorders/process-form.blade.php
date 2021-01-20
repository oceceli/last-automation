<div>
    <x-content>
        <div>
            
            {{-- <h5 class="">
                {{ __('dispatchorders.dispatch_address') }}
            </h5> --}}

            <div class="p-5 shadow-lg relative bg-teal-100">
                <div class="flex justify-between border-b border-white text-ease pb-2">
                    <div>
                        <h5 class="">
                            {{ $dispatchOrder->company->cmp_commercial_title }}
                        </h5>
                    </div>
                    <div>
                        <h5 class="">
                            {{ $dispatchOrder->address->adr_name }}
                        </h5>
                    </div>
                </div>

                <div>
                    <div class="flex flex-col py-2 text-ease text-sm">
                        <span>{{ $dispatchAddress }}</span>
                        <div>{{ __('validation.attributes.adr_phone') }}: {{ $dispatchOrder->address->adr_phone  }}</div>
                    </div>
                    @if ($dispatchOrder->do_note)
                        <div class="mt-4 p-2 border rounded shadow">
                            <i class="comment alternate outline flipped icon"></i>
                            <i class="text-green-700">“{{ $dispatchOrder->do_note }}”</i>
                        </div>
                    @endif
                </div>
            </div>




            <div class="pt-6 bg-cool-gray-50">
                <div class="flex flex-col gap-5">
                    @foreach ($dispatchOrder->reservedStocks as $index => $reservation)
                        <div class="bg-white shadow-md border-t border-b relative p-3" wire:key="do_{{ $index }}">
                            <div class="border-b border-dashed pb-2 flex justify-between font-bold">
                                <div>
                                    {{ $reservation->product->code}} -
                                    {{ $reservation->product->name}}
                                </div>
                                <div class="text-red-700">
                                    {{ $reservation->reserved_amount }}
                                    {{ $reservation->product->baseUnit->name }}
                                </div>
                            </div>
                            @if ($cards && $reservation->product->isInStock)
                                <div class="mt-6">
                                    @foreach ($cards[$index]['rows'] as $key => $row)
                                        <div class="ui tiny form">
                                            <div class="equal width fields">
                                                <x-dropdown model="cards.{{$index}}.rows.{{$key}}.lot_number" :collection="$reservation->product->lots" value="lot_number" text="lot_number,available_amount_string" sClass="search" 
                                                    placeholder="{{ __('dispatchorders.lot_number') }}" sId="do_lot{{ $key }}" noErrors  />
                                                
                                                <x-input model="cards.{{$index}}.rows.{{$key}}.reserved_amount" placeholder="{{ __('common.amount') }}" innerLabel="{{ $reservation->product->baseUnit->name }}">
                                                    
                                                </x-input>
                                            </div>
                                        </div>
                                    @endforeach
                                    <div class="w-full flex border-t pt-3">
                                        <button class="ui mini primary w-full button">
                                            Kaydet
                                        </button>
                                        <button wire:click="addRow({{ $index }})" class="ui black mini icon button">
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
                    @endforeach
                </div>
            </div>


        </div>
    </x-content>
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