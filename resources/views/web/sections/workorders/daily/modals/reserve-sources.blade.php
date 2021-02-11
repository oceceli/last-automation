@if ($reserveSourcesModal)
        <div x-data="{reserveSourcesModal: @entangle('reserveSourcesModal')}">
            <x-custom-modal active="reserveSourcesModal" header="{{ __('workorders.reserve_sources_for_product', ['product' => $woStartData->product->name]) }}">

                <div class="w-full">

                    <div class="p-4 shadow-md flex flex-col gap-4 bg-cool-gray-100 relative">
                        @foreach ($lotCards as $key => $lotCard)
                            <div wire:key="{{ $key }}" class="p-3 shadow-md rounded font-bold border border-orange-200 hover:border-orange-400 ease-in-out duration-200 bg-white">
                                <div class="flex justify-between gap-3">

                                    <div class="field flex gap-1 items-center text-ease">
                                        <span class="">{{ $lotCard['ingredient']['name'] }}</span>
                                        <span class="text-xs hidden md:block"> ({{ $lotCard['ingredient']['code'] }})</span> 
                                    </div>

                                    <div class="text-ease">
                                        @if ($lotCard['ingredient']['pivot']['literal'])
                                            <span class="text-xs text-red-800">{{ __('common.net') }}</span>
                                            <span class="text-sm" data-tooltip="{{ __('workorders.necessary_amount') }}" data-variation="mini" data-position="left center">
                                                {{ number_format($lotCard['amount'], 3, ',', '') }}
                                                {{ $lotCard['unit']['name']}}
                                            </span>
                                        @else 
                                            <span class="text-xs text-green-800">{{ __('common.variable') }}</span>
                                            <span class="text-sm">
                                                <span data-tooltip="{{ __('workorders.necessary_amount') }}" data-variation="mini" data-position="top center">
                                                    {{ number_format($lotCard['amount'], 3, ',', '') }}
                                                </span>
                                                <span class="text-lg text-green-700 font-bold">±</span>
                                                <span data-tooltip="{{ __('common.tolerance') }}" data-variation="mini" data-position="top center">
                                                    {{ number_format($this->calculateTolerance($lotCard['amount']), 3, ',', '') }}
                                                </span>
                                                {{ $lotCard['unit']['name']}}
                                            </span>
                                        @endif
                                    </div>

                                </div>

                                <div class="pt-2" wire:key="dropdown{{ $key }}">
                                    {{-- {{ __('workorders.lot_no')}}:  --}}
                                    <x-dropdown-multiple model="inputModels.{{ $key }}" sId="{{ 'multipledropdown'. $key }}" class="mini">

                                        @foreach(App\Models\Product::find($lotCard['ingredient']['id'])->lots as $selectLot)
                                            @if ($selectLot['available_amount'] > 0 || $selectLot['reserved_amount'])
                                                <option value="{{ $selectLot['lot_number'] }},{{ $selectLot['available_amount'] }}">
                                                    <span>{{ $selectLot['lot_number'] }}</span> | 
                                                    <span class="text-xs">{{ __('common.available' )}}: {{ $selectLot['available_amount_string'] }}</span>
                                                    @if($selectLot['reserved_amount'])
                                                        | {{ __('workorders.reserved') }}: {{ $selectLot['reserved_amount_string'] }}
                                                    @endif
                                                </option>
                                            @endif
                                        @endforeach
                                        
                                    </x-dropdown-multiple>

                                </div>
                                <div class="pt-2 text-xs {{ $this->displayCoveredAmount($key)['class'] }}">
                                    {{ $this->displayCoveredAmount($key)['text'] }}
                                </div>

                            </div>
                        @endforeach
                    </div>
                    

                    <div class="p-5 border-t border-orange-100 bg-orange-50">
                        <button class="ui orange button w-full" wire:click="confirmStart()">
                            {{ __('common.confirm') }}
                            <i class="right arrow icon"></i>
                            {{-- {{ __('workorders.start')}} --}}
                        </button>
                    </div>

                </div>
        </x-custom-modal>
    </div>
@endif