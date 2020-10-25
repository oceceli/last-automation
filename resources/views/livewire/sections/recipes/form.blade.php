<div>
    <x-page-title icon="mortar pestle" header="sections/recipes.header" subheader="sections/recipes.subheader" />
    {{-- <div class="p-6 bg-white bg-opacity-25 shadow rounded-lg "> --}}

        {{-- Locked butons --}}
        @if ($locked)
            <div class="relative">
                <div class="absolute right-0 top-0 -mt-7 -mr-1 z-10">
                    <div wire:click="unlock" data-tooltip="{{ __('common.edit') }}">
                        <i class="large unlock circular icon link animate-pulse text-red-400 hover:text-green-400"></i>
                    </div>
                </div>
            </div>
        @endif
        <form class="ui form" wire:submit.prevent="submit" >
            <div class="ui raised teal padded segment">
                <div class="equal width fields pb-4">
                    <div wire:ignore class="required field">
                        <label>{{ __('sections/recipes.recipe_product') }}</label>
                        <x-dropdown.search model="product_id" :collection="$this->producibleProducts" value="id" text="name,code" class="ui search selection dropdown" />
                        @error('product_id')
                            <p class="text-red-500 py-2">{{ucfirst($message)}}</p>
                        @enderror
                    </div>
                    @if ($locked)
                        <div class="required field disabled">
                    @else
                        <div class="required field">
                    @endif
                        <label>{{ __('sections/recipes.code') }}</label>
                        <div class="ui action input">
                            <input wire:model.lazy="code" type="text" placeholder="{{ __('sections/recipes.code') }}">
                            <button wire:click.prevent="random" class="ui teal bordered right labeled icon button" >
                                <i class="icon random"></i>
                                {{ __('sections/recipes.random_code') }}
                            </button>
                        </div>
                        
                        @error('code')
                            <p class="text-red-500 py-2">{{ucfirst($message)}}</p>
                        @enderror
                    </div>
                </div>
                

                @if ($selectedProduct)
                    @if ( ! $baseUnit)
                        Bu ürüne birim tanımlanmamış...
                    @else
                        <div class="relative border rounded-t bg-gray-50 shadow-inner" style="min-height: 60%" x-data="{'materials' : false}">
                            
                            {{-- BAŞLIK VE BUTONLAR --}}
                            <x-title-and-buttons title="1 '{{ $baseUnit->name }}' {{ $selectedProduct->name }} {{ __('sections/recipes.includes') }}" icon="flask" class="py-4 px-3 bg-cool-gray-50" >
                                <x-slot name="buttons">
                                    <div class="ui small icon buttons">
                                        <button wire:click.prevent @click="materials = true" class="ui teal button" data-tooltip="{{ __('sections/recipes.add_ingredients') }}">
                                            <i class="plus icon"></i>
                                        </button>
                                        <button wire:click.prevent="clearIngredients" class="ui gray basic button" data-tooltip="{{ __('sections/recipes.remove_ingredients') }}">
                                            <i class="red trash icon"></i>
                                        </button>
                                    </div>
                                </x-slot>
                            </x-title-and-buttons>

                            <div class="shadow-inner relative">
                                {{-- İÇERİK - CARD KISMI   md:h-96 overflow-x-hidden  --}}
                                <div class="p-5 py-7">
                                    <div class="flex flex-col gap-3">
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
                                                            <div class="field flex items-center">
                                                                {{-- {{ $amounts[$key] }} --}}
                                                                <x-input-drop inputModel="amounts.{{ $key }}" placeholder="sections/recipes.amount" inputType="number" class="ui small input"
                                                                    selectModel="unit.{{ $key }}" :selectData="$ingredients[$key]['units']" 
                                                                    selectValue="id" selectText="name" selectPlaceholder="{{ __('sections/units.unit') }}" />
                                                            </div>
                                                        @else
                                                            kapalı
                                                        @endif
                                                    </div>
                                                    
                                                    <button wire:click.prevent="removeIngredient({{ $key }})" class="absolute top-0 right-0 -mt-2 -mr-3 focus:outline-none hover:opacity-100 opacity-50">
                                                        <i class="red shadow rounded-full cancel icon"></i>
                                                    </button>
                                                    
                                                </div>
                                            @endforeach
                                        @endif
                                    </div>
                                    
                                    {{-- MALZEMELER BÖLÜMÜ - MATERIALS FIXED --}}
                                    <div x-show="materials" @click.away="materials = false" class="rounded-lg w-4/12 bg-gray-50 h-96 shadow-lg fixed top-1/4 right-1/4 z-10">
                                        <div class="overflow-x-hidden h-full p-3">
                                            <div class="px-4 py-2 bg-white shadow-lg border rounded-lg">
                                                @foreach ($this->categories as $category)
                                                <div class="relative" x-data="{open: false}">
                                                    <div class="absolute w-full h-9 cursor-pointer text-right" @click="open = !open">
                                                        <i :class="{'caret down text-teal-800 icon': open, 'caret right icon': !open}"></i>
                                                    </div>
                                                    <div class="ui list">
                                                        <div class="item">
                                                            <i class="layer group icon"></i>
                                                            <div class="content">
                                                                <div class="header">{{ $category->name }}</div>
                                                                <div class="description">{{ $category->unproducibleProducts->count() }} {{ ucfirst(__('sections/products.product')) }}</div>
                                                                @foreach ($category->unproducibleProducts as $key => $product)
                                                                    <div class="ui animated list selection" x-show="open" x-transition:enter="transition ease-out duration-500" 
                                                                                                                x-transition:enter-start="opacity-0 transform scale-60" 
                                                                                                                x-transition:enter-end="opacity-100 transform scale-100" 
                                                                                                                x-transition:leave="transition ease-in duration-100" 
                                                                                                                x-transition:leave-start="opacity-100 transform scale-100" 
                                                                                                                x-transition:leave-end="opacity-0 transform scale-60">
                                                                        <div class="item" wire:click.prevent="addIngredient({{ $product }})">
                                                                            <i class="box icon"></i>
                                                                            <div class="content">
                                                                                <div class="header">{{ $product->name }}</div>
                                                                                <div class="description">{{ $product->code }}</div>
                                                                            </div>
                                                                        </div>
                                                                        
                                                                    </div>
                                                                @endforeach
                                                            </div>
                                                        </div>
                                                    </div>  
                                                </div>
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>                
                        </div>
                    @endif
                    
                @endif
                
            </div> {{-- segment ending --}}
            

            <x-form-buttons />
            
        </form>
        
    {{-- </div> --}}
</div>