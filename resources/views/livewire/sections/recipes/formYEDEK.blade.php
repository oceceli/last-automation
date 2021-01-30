<div>
    @if (isset($recipe))
        @if ($locked)
            <x-page-header icon="mortar pestle" header="common.detail" subheader="{{ $recipe->product->name }} ürününe ait reçete" />
        @else
            <x-page-header icon="mortar pestle" header="common.edit" subheader="{{ __('recipes.edit_recipe_of', ['product' => $recipe->product->name]) }}" />
        @endif
    @else
        <x-page-header icon="mortar pestle" header="recipes.header" subheader="recipes.subheader" />
    @endif
    {{-- <div class="p-6 bg-white bg-opacity-25 shadow rounded-lg "> --}}

        {{-- Locked butons --}}
        @if ($locked)
            <div class="relative">
                <div class="absolute right-0 top-0 -mt-7 -mr-1 z-10">
                    <div wire:click="unlock" data-tooltip="{{ __('common.edit') }}">
                        <i class="large unlock alternate circular icon link animate-pulse text-red-400 hover:text-green-400"></i>
                    </div>
                </div>
            </div>
        @endif
        <form class="ui form" wire:submit.prevent="submit">
            <div class="ui raised teal padded segment">
                
                {{-- Üst form alanı --}}
                @if ( ! isset($recipe))
                    <div class="equal width fields pb-4">
                        <div wire:ignore class="required field">
                            <label>{{ __('recipes.recipe_product') }}</label>
                            <x-dropdown.search model="product_id" :collection="$this->producibleProducts" value="id" text="name,code" id="selectProduct" class="ui search selection dropdown" />
                            @error('product_id')
                                <p class="text-red-500 py-2">{{ucfirst($message)}}</p>
                            @enderror
                            @if ($this->producibleProducts->count() <= 0)
                                <div class="pt-2 font-semibold text-sm">Listede hiç ürün yok, öncelikle <a class="text-red-600" href="{{ route('products.create') }}">buradan</a> oluşturun...</div>
                            @endif
                        </div>
                        <div class="required field">
                            <label>{{ __('recipes.code') }}</label>
                            <div class="ui action input">
                                <input wire:model.lazy="code" type="text" placeholder="{{ __('recipes.code') }}">
                                <button wire:click.prevent="random" class="ui teal bordered right labeled icon button" >
                                    <i class="icon random"></i>
                                    {{ __('recipes.random_code') }}
                                </button>
                            </div>
                            
                            @error('code')
                                <p class="text-red-500 py-2">{{ucfirst($message)}}</p>
                            @enderror
                        </div>
                    </div>
                @else
                    @if ( ! $locked)
                        <div class="field pb-4">
                            <label>{{ __('recipes.code') }}</label>
                            <div class="ui action input">
                                <input wire:model.lazy="code" type="text" placeholder="{{ __('recipes.code') }}">
                                <button wire:click.prevent="random" class="ui teal bordered right labeled icon button" >
                                    <i class="icon random"></i>
                                    {{ __('recipes.random_code') }}
                                </button>
                            </div>
                            
                            @error('code')
                                <p class="text-red-500 py-2">{{ucfirst($message)}}</p>
                            @enderror
                        </div>
                    @endif
                @endif
                {{-- Üst form alanı --}}

                

                @if ($selectedProduct)
                    @if ( ! $baseUnit)
                        Bu ürüne birim tanımlanmamış...
                    @else
                        {{-- <div class="relative border rounded-t bg-gray-50 shadow-inner" style="min-height: 60%" x-data="{'materials' : false}"> --}}
                        <div class="relative border rounded-t bg-gray-50 shadow-inner" style="min-height: 60%" x-data="{materials : false}">
                            
                            {{-- <div class="h-3"></div> --}}
                            {{-- BAŞLIK VE BUTONLAR --}}
                            <x-page-header header="1 '{{ $baseUnit->name }}' {{ $selectedProduct->name }} {{ __('recipes.includes') }}" icon="flask" class="pt-4 px-4 bg-cool-gray-50" >
                                @if ( ! $locked)
                                    <x-slot name="buttons">
                                        <div class="ui small icon buttons">
                                            <button wire:click.prevent @click="materials = true" class="ui teal button" id="button1" :class="{'disabled': $wire.locked}" data-tooltip="{{ __('recipes.add_ingredients') }}">
                                                <i class="plus icon"></i>
                                            </button>
                                            <button wire:click.prevent="clearIngredients" class="ui gray basic button" :class="{'disabled': $wire.locked}" data-tooltip="{{ __('recipes.remove_ingredients') }}">
                                                <i class="red trash icon"></i>
                                            </button>
                                        </div>
                                    </x-slot>
                                @endif
                            </x-page-header>

                            <div class="shadow-inner relative">
                                {{-- İÇERİK - CARD KISMI   md:h-96 overflow-x-hidden  --}}
                                <div class="p-5 py-7">
                                    <div class="flex flex-col gap-3" id="ingredientArea">
                                        @if (! $ingredients)
                                        <div class="ui placeholder segment h-full">
                                            <div class="ui icon header">
                                                <i class="blue atom left bottom corner icon"></i>
                                                <i class="flask icon"></i>
                                                <button @click="materials = true" wire:click.prevent class="text-blue-600 font-bold focus:outline-none">Buradan</button> reçete içeriği oluşturun
                                            </div>
                                            <div class="text-sm text-center"><span class="font-bold">{{ $selectedProduct->name }}</span> içeriği burada görüntülenecek</div>
                                        </div>
                                        @else
                                            @foreach ($ingredients as $key => $ingredient)
                                                <div class="bg-white shadow rounded-lg flex border border-red-100 relative hover:border-red-300">

                                                    <div class="w-16 flex pl-2 rounded-l-lg justify-center items-center shadow-md">
                                                        {{-- image field --}}
                                                        <i class="large red box icon"></i>
                                                    </div>

                                                    <div class="flex flex-1 justify-between items-center p-3">
                                                        <div>
                                                            <div class="font-bold">{{ $ingredient['name'] }}</div>
                                                            <div class="text-sm text-gray-500">{{ $ingredient['code'] }}</div>
                                                        </div>
                                                        {{-- inputs --}}
                                                        @if ( ! $locked)
                                                        {{ print_r($units) }}
                                                            <div class="field flex items-center">
                                                                {{-- {{ $amounts[$key] }} --}}
                                                                <x-input-drop iModel="amounts.{{ $key }}" iPlaceholder="recipes.amount" iType="number" class="ui small input"
                                                                    sModel="units.{{ $key }}" sData="getUnitsOfIngredient" :key="$key" :sId="'selectId'.$key" 
                                                                    sValue="id" sText="name" sPlaceholder="{{ __('units.unit') }}" />

                                                                    {{-- :sData="$ingredients[$key]['units']" --}}
                                                                

                                                            </div>
                                                        @else
                                                            <div class="flex gap-2 p-2 px-5 justify-between bg-indigo-100 shadow-lg  rounded">
                                                                <div class="font-bold text-red-600">{{ $amounts[$key] }}</div>
                                                                <div class="font-bold">{{ $ingredient['units']->find($units[$key])->name }}</div>
                                                                <div><i class="green vial icon"></i></div>
                                                            </div>
                                                        @endif
                                                    </div>
                                                    
                                                    <button wire:click.prevent="removeIngredient({{ $key }})" :class="{'hidden': $wire.locked}"
                                                            class="absolute top-0 right-0 -mt-2 -mr-3 focus:outline-none hover:opacity-100 opacity-50">
                                                        <i class="red shadow rounded-full cancel icon"></i>
                                                    </button>
                                                    
                                                </div>
                                            @endforeach
                                        @endif
                                    </div>

                                    {{-- MALZEMELER BÖLÜMÜ - MODAL --}}
                                    @include('web.sections.recipes.create.materials');

                                </div>
                            </div>                
                        </div>
                    @endif
                    
                @endif
                
                @if (!$locked)
                <hr>
                    <x-form-buttons />
                @endif
            </div> {{-- segment ending --}}
            

            
        </form>
        
    {{-- </div> --}}
</div>













<x-custom-modal active="materials">
    <x-slot name="header">
        <x-page-header icon="sitemap" header="recipes.add_ingredients" subheader="recipes.add_recipe_ingredients" />
    </x-slot>
    @foreach ($this->categories as $category)
        <div class="relative" x-data="{caret: false}">
            <div class="absolute w-full h-9 cursor-pointer text-right" @click="caret = !caret">
                <i :class="{'caret down text-teal-800 icon': caret, 'caret right icon': !caret}"></i>
            </div>
            <div class="ui list">
                <div class="item">
                    <i class="layer group icon"></i>
                    <div class="content">
                        <div class="header">{{ $category->name }}</div>
                        <div class="description">{{ $category->unproducibleProducts->count() }} {{ ucfirst(__('products.product')) }}</div>
                        @foreach ($category->unproducibleProducts as $key => $product)
                            <div class="ui animated list selection" x-show="caret" x-transition:enter="transition ease-out duration-500" 
                                                                        x-transition:enter-start="opacity-0 transform scale-60" 
                                                                        x-transition:enter-end="opacity-100 transform scale-100" 
                                                                        x-transition:leave="transition ease-in duration-100" 
                                                                        x-transition:leave-start="opacity-100 transform scale-100" 
                                                                        x-transition:leave-end="opacity-0 transform scale-60">
                                <div class="item" wire:click.prevent="addIngredient({{ $product }})">
                                    <div class="flex gap-2 items-center hover:bg-yellow-100 rounded px-2 py-1">
                                        <div><i class="box icon"></i></div>
                                        <div class="flex flex-1 justify-between items-center">
                                            <div>
                                                <div class="header">{{ $product->name }}</div>
                                                <div class="description">{{ $product->code }}</div>
                                            </div>

                                            @if (in_array($product['id'], array_column($ingredients, 'id')))
                                                <div class="text-green-600 font-bold">
                                                    <span>{{ __('common.added' )}}</span>
                                                    <i class="checkmark icon"></i>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>  
        </div>
    @endforeach
</x-custom-modal>