<div>
    <x-content>
        <x-slot name="header">
            <x-page-header icon="blue open box" header="products.details.header" subheader="{{ __('products.details.subheader', ['product' => $product->name]) }}" >
                <x-slot name="buttons">
                    <div class="ui mini icon buttons">
                        <a href="{{ route('products.edit', ['product' => $product]) }}" class="ui teal button" data-variation="mini" data-tooltip="{{ __('common.edit') }}">
                            <i class="pen alternate icon"></i>
                        </a>
                        <button wire:click.prevent="delete" class="ui mini gray basic button" data-variation="mini" data-tooltip="{{ __('common.delete') }}">
                            <i class="red trash icon"></i>
                        </button>
                    </div>
                </x-slot>
            </x-page-header>
        </x-slot>

        <div class="bg-white p-4 rounded-lg shadow">
            <div class="border border-green-200 rounded-md">
    
                <div class="flex shadow">
                    <div class="w-0 hidden md:w-28 md:flex shadow-md items-center justify-center">
                        <i class="big box icon"></i>
                    </div>
                    <div class="p-4 flex flex-1 justify-between">
    
                        <div class="flex flex-col justify-between">
                            <div>
                                <div class="text-xl font-bold text-green-700">{{ $product->name }}</div>
                                <div class="font-semibold text-gray-700">{{ $product->code }}</div>
                            </div>
                            <div class="pt-3 font-semibold text-sm text-gray-500">
                                <i class="barcode icon"></i>
                                <span>{{ $product->barcode ?? __('products.no_barcode_defined') }}</span>
                            </div>
                        </div>
    
                        <div class="flex flex-col justify-between text-right">
                            
                            <div>
                                <span class="text-sm font-sans text-gray-500" data-tooltip="{{ __('modelnames.category') }}" data-variation="mini">{{ $product->category->ctg_name }}</span>
                                <i class="layer group  small icon grey"></i>
                            </div>
    
                            
    
                            @if ($product->producible)
                                @if ($recipe)
                                <div data-tooltip="{{ __('recipes.see_recipe') }}" data-variation="mini">
                                    <a href="{{ route('recipes.show', ['recipe' => $recipe->id]) }}" class="pt-2 font-semibold text-sm text-green-600" >{{ $recipe->code }}</a>
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
                    <div class="py-14 flex justify-between items-center gap-8">
                        {{-- Raf ömrü, Min stok vs. orta alan  --}}
                        <div class="flex gap-8">
                            <div>
                                <label class="text-gray-600 font-bold">{{ __('products.shelf_life') }}</label>
                                <div class="flex gap-1 items-center">
                                    <i class="calendar alternate teal icon"></i>
                                    <p>{{ __('products.count_years', ['count' => $product->shelf_life ]) }}</p>
                                </div>
                                
                            </div>
                            <div>
                                <label class="text-gray-600 font-bold">{{ __('products.min_threshold') }}</label>
                                <div class="flex gap-1 items-center">
                                    <i class="calculator teal icon"></i>
                                    <p>{{ $product->min_threshold }} @if($baseUnit) {{ $baseUnit->name }} @else <strong class="text-red-600">Birim tanımlanmamış</strong> @endif </p>
                                </div>
                            </div>
                        </div>
    
                        <div class="flex gap-8">
                            <div class="flex flex-col items-center">
                                <label class="text-gray-600 font-bold">{{ __('products.is_active') }}</label>
                                @if ($product->is_active)
                                    <i class="green checkmark icon"></i>
                                @else
                                    <i class="red times icon"></i>
                                @endif
                            </div>
                            <div class="flex flex-col items-center">
                                <label class="text-gray-600 font-bold">{{ __('products.producible') }}</label>
                                @if ($product->producible)
                                    <i class="green checkmark icon"></i>
                                @else
                                    <i class="red times icon"></i>
                                @endif
                            </div>
                        </div>
                    </div>
    
                    <hr>
    
                    {{-- Ölçü birimleri alanı --}}
                    <div class="py-8">
                        <label class="text-gray-600 font-bold">{{ __('products.measure_units_that_belongs_to_product') }}</label>
                        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-6 gap-2 pt-4">
                            @foreach ($product->units as $unit)
                                <div class="text-sm p-2">
                                    <span class="font-semibold bg-cool-gray-200 p-2 shadow-md rounded-md">
                                        <i class="weight grey icon"></i>
                                        {{ $unit->name }}
                                        @if ($unit->id == $baseUnit->id)
                                            <span class="text-xs text-gray-600">({{ __('common.base') }})</span>
                                        @endif
                                    </span>
                                </div>
                            @endforeach
                        </div>
                    </div>
    
                </div>
    
            </div>
        </div>
    </x-content>
</div>
