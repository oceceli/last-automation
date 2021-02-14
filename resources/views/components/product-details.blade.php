<div class="bg-white p-4 rounded-lg shadow">
    <div class="border border-green-200 rounded-md">

        <div class="flex shadow">
            <div class="w-0 hidden md:w-28 md:flex shadow-md items-center justify-center">
                <i class="big box icon"></i>
            </div>
            <div class="p-4 flex flex-1 justify-between">

                <div class="flex flex-col justify-between">
                    <div>
                        <div class="text-xl font-bold text-green-700">{{ $product->prd_name }}</div>
                        <div class="font-semibold text-gray-700">{{ $product->prd_code }}</div>
                    </div>
                    <div class="pt-3 font-semibold text-sm text-gray-500">
                        <i class="barcode icon"></i>
                        <span>{{ $product->prd_barcode ?? __('products.no_barcode_defined') }}</span>
                    </div>
                </div>

                <div class="flex flex-col justify-between text-right">
                    
                    <div>
                        <span class="text-sm font-sans text-gray-500" data-tooltip="{{ __('modelnames.category') }}" data-variation="mini">{{ $product->category->ctg_name }}</span>
                        <i class="layer group  small icon grey"></i>
                    </div>

                    

                    @if ($product->prd_producible)
                        @if ($product->recipe)
                        <div data-tooltip="{{ __('recipes.see_recipe') }}" data-variation="mini">
                            <a href="{{ route('recipes.show', ['recipe' => $product->recipe->id]) }}" class="pt-2 font-semibold text-sm text-green-600" >{{ $product->recipe->code }}</a>
                            <i class="mortar pestle icon"></i>
                        </div>
                        @else
                        <div data-tooltip="{{ __('products.products_with_no_recipes_cannot_be_manufactured') }}" data-variation="mini" data-position="top right">
                            <span class="font-semibold text-sm text-orange-400">{{ __('recipes.no_recipe_defined_for_this_product') }}</span>
                            <i class="circular tiny question mark icon link"></i>
                        </div>
                        @endif
                    @else
                        <div>
                            <span class="pt-2 font-semibold text-sm text-red-500">{{ __('products.this_product_cannot_be_manufactured') }}</span>
                        </div>
                    @endif

                </div>
            </div>
        </div>

        <div class="px-6">
            <div class="py-14 grid md:grid-cols-2 items-center gap-8">
                {{-- Raf ömrü, Min stok vs. orta alan  --}}
                <div class="flex gap-8">
                    <div>
                        <label class="text-gray-600 font-bold">{{ __('products.shelf_life') }}</label>
                        <div class="flex gap-1 items-center">
                            <i class="calendar alternate teal icon"></i>
                            <p>{{ __('products.count_years', ['count' => $product->prd_shelf_life ]) }}</p>
                        </div>
                        
                    </div>
                    <div>
                        <label class="text-gray-600 font-bold">{{ __('products.min_threshold') }}</label>
                        <div class="flex gap-1 items-center">
                            <i class="calculator teal icon"></i>
                            <p>{{ $product->prd_min_threshold }} @if($product->baseUnit) {{ $product->baseUnit->name }} @else <strong class="text-red-600">Birim tanımlanmamış</strong> @endif </p>
                        </div>
                    </div>
                    <div>
                        <label class="text-gray-600 font-bold">{{ __('inventory.in_stock') }}</label>
                        <div class="flex gap-1 items-center">
                            <i class="red warehouse icon"></i>
                            <p>{{ $product->totalStock['amount_string'] }}</p>
                        </div>
                    </div>
                </div>

                <div class="md:justify-end flex gap-8">
                    <div class="flex flex-col items-center">
                        <label class="text-gray-600 font-bold">{{ __('products.is_active') }}</label>
                        @if ($product->prd_is_active)
                            <i class="green checkmark icon"></i>
                        @else
                            <i class="red times icon"></i>
                        @endif
                    </div>
                    <div class="flex flex-col items-center">
                        <label class="text-gray-600 font-bold">{{ __('products.producible') }}</label>
                        @if ($product->prd_producible)
                            <i class="green checkmark icon"></i>
                        @else
                            <i class="red times icon"></i>
                        @endif
                    </div>
                </div>
            </div>

            {{-- <hr> --}}

            {{-- Ölçü birimleri alanı --}}
            <div class="mb-6 p-4 border-dashed rounded-sm border text-white">
                <label class="font-bold text-gray-700">{{ __('products.measure_units_that_belongs_to_product') }}</label>
                <div class="flex flex-col gap-4 pt-4">
                    @foreach ($product->units as $unit)
                        <div class="text-sm font-semibold bg-teal-600 p-2 shadow-md rounded-md">
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

        </div>

    </div>
</div>