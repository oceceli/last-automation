<div>
    <x-content>
        <div>
            
            {{-- <h5 class="">
                {{ __('dispatchorders.dispatch_address') }}
            </h5> --}}

            <div class="p-5 shadow-md relative">
                <div class="flex justify-between border-b text-ease pb-2">
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




            <div class="p-5 bg-gray-200">
                <div class="flex flex-col gap-4">
                    @foreach ($dispatchOrder->reservedStocks as $index => $reservation)
                        <div class="white-area p-3" wire:key="do_{{ $index }}">
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
                            <div class="mt-6">
                                @if ($cards)
                                    @foreach ($cards[$index]['rows'] as $key => $row)
                                        <div class="ui tiny form border-b">
                                            <div class="equal width fields">
                                                <x-dropdown model="cards.{{$index}}.rows.{{$key}}" :collection="$reservation->product->lots" value="lot_number" text="lot_number,available_amount_string" sClass="search" 
                                                    placeholder="{{ __('dispatchorders.lot_number') }}" sId="do_lot{{ $key }}" noErrors  />
                                                
                                                <x-input model="test" placeholder="{{ __('common.amount') }}" innerLabel="{{ $reservation->product->baseUnit->name }}">
                                                    
                                                </x-input>
                                            </div>
                                        </div>
                                    @endforeach
                                @endif
                                <div class="text-right">
                                    <button wire:click="addRow({{ $index }})" class="ui mini icon button">
                                        <i class="green plus icon"></i>
                                    </button>
                                </div>
                            </div>
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