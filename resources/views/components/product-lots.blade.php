<div {{ $attributes->merge(['class' => 'mb-6 p-4 rounded-sm flex-1 bg-white'])}}>
    <div class="font-bold pb-2">{{ __('inventory.lot_numbers_of_product', ['product' => $product->prd_name]) }}</div>
    <div class="flex flex-col gap-4 text-white border p-4 rounded-t">
        @forelse ($product->lots as $lot)
            <div class="text-sm px-2 py-2 font-bold bg-green-800 hover:bg-green-600 shadow-md rounded-md flex justify-between duration-200 ease-in-out">
                <div>
                    <i class="box icon"></i>
                    <label class="font-bold">{{ __('inventory.lot_number') }}</label>
                    <span>{{ $lot['lot_number'] }}</span>
                </div>
                <div>
                    @if ($lot['reserved_amount'])
                        <span>{{ $lot['amount_string'] }}</span>
                        <span class="text-xs text-gray-200"> - {{ $lot['reserved_amount_string'] }}</span>
                    @else 
                        <span>{{ $lot['amount_string'] }}</span>
                    @endif
                </div>
                <div>
                    <span class="px-1 bg-white text-black rounded-sm shadow">{{ $lot['available_amount_string'] }}</span>
                    <span>{{ __('inventory.available') }}</span>
                </div>
            </div>
        @empty
            <div class="p-2 h-full w-full bg-red-900 hover:bg-red-700 font-bold rounded duration-200 ease-in-out">
                <i class="triangle exclamation icon"></i>
                {{ __('inventory.out_of_stock') }}
            </div>
        @endforelse
    </div>

    <div class=" p-4 bg-gray-700 text-white rounded-b flex justify-between font-bold shadow-md">
        <div>
            {{ __('common.total') }}
            @if ($product->totalStock['reserved_amount'])
                {{ number_format($product->totalStock['amount'], 6) }} 
                <x-span tooltip="{{ __('inventory.reserved') }}" class="text-xs text-ease-red">
                    - {{ $product->totalStock['reserved_amount_string'] }}
                </x-span>
            @else
                {{ $product->totalStock['amount_string'] }}
            @endif
        </div>
        <div>
            <span>{{ $product->totalStock['available_amount_string'] }} </span>
            <span class="text-xs">{{ __('inventory.available') }}</span>
        </div>
    </div>

</div>