<div class="flex-1 mb-6 p-4 border-dashed rounded-sm border hover:border-teal-500">
    <label class="font-bold">{{ __('products.measure_units_that_belongs_to_product') }}</label>
    <div class="flex flex-col gap-4 pt-4 text-white">
        @foreach ($product->units as $unit)
            <div class="text-sm font-semibold bg-teal-600 hover:bg-teal-500 p-2 shadow-md rounded-md duration-200 ease-in-out">
                <i class="balance scale icon"></i>
                1 {{ $unit->name }} =
                <span class="px-1 bg-white text-black rounded-sm shadow">1 {{ $unit->operator ? '*' : '/' }} {{ (float)$unit->factor }} {{ optional($unit->parent)->name }}</span>
                @if ($unit->id == $product->baseUnit->id)
                    <span class="text-xs"> ({{ __('common.base') }})</span>
                @endif
            </div>
        @endforeach
    </div>
</div>