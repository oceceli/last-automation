<div>
    <div class="flex flex-col gap-4 p-4 h-full">
        @foreach ($selectedProduct->recipe->ingredients as $ingredient)
            <div wire:key="{{ $loop->index }}" class="p-3 shadow-md rounded font-bold border border-purple-200 hover:border-purple-300 ease-in-out duration-200 bg-white">

                <div class="flex justify-between gap-3 ">
                    <div class="field flex gap-1 items-center text-ease">
                        <span class="">{{ $ingredient->name }}</span>
                        <span class="text-xs hidden md:block"> ({{ $ingredient->code }})</span> 
                    </div>
                    <div class="text-sm text-ease" data-tooltip="{{ __('sections/workorders.necessary_amount') }}" data-variation="mini" data-position="top right">
                        @if ($ingredient->pivot->literal) {{ __('common.net') }}
                        @else {{ __('common.least') }}
                        @endif
                        <span>
                            {{ $this->calculateNeeds($ingredient)['amount'] }} {{ $this->calculateNeeds($ingredient)['unit']->name }}
                        </span>
                    </div>
                </div>

                <div>
                    @if ($ingredient->lots)
                        <select class="form-select text-sm">
                            <option selected disabled class="text-xs">{{ __('sections/workorders.select_lot_number')}}...</option>
                            @foreach ($ingredient->lots as $lot)
                                <option value="{{ $lot['lot_number'] }}">{{ $lot['lot_number'] }} - {{ $lot['amount'] }} {{ $lot['unit']->name }}</option>
                            @endforeach
                        </select>
                    @else
                        <span class="text-xs text-ease-red">Stokta hiç {{ $ingredient->name }} bulunmuyor. Üretim yapmadan önce kullanılacak lot numarası belirtilecektir.</span>
                    @endif
                </div>
            </div>
        @endforeach
    </div>
</div>