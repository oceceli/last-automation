<div {{ $attributes->merge(['class' => 'mb-6 p-4 border-dashed rounded-sm border hover:border-green-500 flex-1 bg-white shadow'])}}>
    <label class="font-bold">{{ __('inventory.lot_numbers_of_product', ['product' => $product->prd_name]) }}</label>
    <div class="flex flex-col gap-4 pt-4 text-white">
        @forelse ($product->lots as $lot)
            <div class="text-sm px-2 py-2 font-bold bg-green-800 hover:bg-green-600 shadow-md rounded-md flex justify-between duration-200 ease-in-out">
                <div>
                    <i class="box icon"></i>
                    <label class="font-bold">{{ __('inventory.lot_number') }}</label>
                    <span>{{ $lot['lot_number'] }}</span>
                </div>
                <div>
                    @if ($lot['reserved_amount'])
                        <span>{{ $lot['amount'] }}</span>
                        <span class="text-xs text-gray-200"> - {{ $lot['reserved_amount_string'] }}</span>
                    @else 
                        <span>{{ $lot['amount_string'] }}</span>
                    @endif
                </div>
                <div>
                    <span class="px-1 bg-white text-black rounded-sm shadow">{{ $lot['available_amount_string'] }}</span>
                    <span>{{ strtolower(__('inventory.available')) }}</span>
                </div>
            </div>
        @empty
            <div class="p-2 h-full w-full bg-red-900 hover:bg-red-700 font-bold rounded duration-200 ease-in-out">
                <i class="triangle exclamation icon"></i>
                {{ __('inventory.out_of_stock') }}
            </div>
        @endforelse
    </div>
</div>