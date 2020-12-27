<div class="w-full">

    
    <div class="p-4 shadow-md flex flex-col gap-4 bg-cool-gray-100 relative">
        @foreach ($lotCards as $key => $lotCard)
            <div wire:key="{{ $key }}" class="p-3 shadow-md rounded font-bold border border-purple-200 hover:border-purple-300 ease-in-out duration-200 bg-white">
                <div class="flex justify-between gap-3 " wire:model="test">
                    <div class="field flex gap-1 items-center text-ease">
                        <span class="">{{ $lotCard['ingredient']->name }}</span>
                        <span class="text-xs hidden md:block"> ({{ $lotCard['ingredient']->code }})</span> 
                    </div>
                    <div class="text-ease">
                        @if ($lotCard['ingredient']->pivot->literal) <span class="text-xs text-red-800">{{ __('common.net') }}</span>
                        @else <span class="text-xs text-green-800">{{ __('common.variable') }}</span>
                        @endif
                        <span class="text-sm" data-tooltip="{{ __('sections/workorders.necessary_amount') }}" data-variation="mini" data-position="left center">
                            {{ number_format($lotCard['amount'], 2, ',', '') }}
                            {{ $lotCard['unit']->abbreviation}}
                        </span>
                    </div>
                </div>

                <div class="pt-2">
                    <x-dropdown-multiple>

                    </x-dropdown-multiple>
                </div>
                <div class="pt-2 text-xs text-ease-red">Yeterlilik</div>

            </div>
        @endforeach
    </div>
    

    <div class="p-5 border-t border-orange-100 bg-orange-50">
        <button class="ui orange button w-full" wire:click="start()">
            {{ __('common.confirm') }}
            <i class="right arrow icon"></i>
            {{-- {{ __('sections/workorders.start')}} --}}
        </button>
    </div>


</div>





{{-- <div>
    @if ($lotCard['ingredient']->lots)
        <select class="form-select text-sm" wire:model.defer="selectedLots.lot_{{ $key }}">
            <option selected class="text-xs">{{ __('sections/workorders.select_lot_number')}}...</option>
            @foreach ($lotCard['ingredient']->lots as $lot)
                <option wire:key="{{ $loop->index }}" value="{{ $lotCard['ingredient']->id }},{{ $lot['lot_number'] }}">
                    {{ $lot['lot_number'] }} - {{ $lot['amount'] }} {{ $lot['unit']->name }}
                </option>
            @endforeach
        </select>
    @else
        <span class="text-xs text-ease-red">!!! Stokta hiç {{ $lotCard['ingredient']->name }} bulunmuyor. Üretim yapmadan önce kullanılacak lot numarası belirtilecektir.</span>
    @endif
</div> --}}