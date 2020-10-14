<div class="p-6 bg-white bg-opacity-25 shadow rounded-lg ">

    <h3 class="ui horizontal left aligned divider header">
        <i class="mortar pestle icon"></i>
        <div class="content">
          {{ __('sections/recipes.header') }}
          <div class="sub header">{{ __('sections/recipes.subheader') }}</div>
        </div>
    </h3>
    <form class="ui form" wire:submit.prevent="submit" wire:loading.class="loading">
        <div class="ui raised teal padded segment">
            <div class="equal width fields pb-4">
                <div wire:ignore class="required field">
                    <label>{{ __('sections/recipes.recipe_product') }}</label>
                    <x-dropdown.search model="product_id" :collection="$this->producibleProducts" value="id" text="name,code" class="ui search selection dropdown" />
                </div>
                <div class="required field">
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
            



            {{-- @if ($currentProduct) --}}
                <div class="relative border rounded-t bg-gray-50 shadow-inner" style="min-height: 60%" x-data="{'materials' : false}">
                    
                    {{-- BAŞLIK VE BUTONLAR --}}
                    <div class="py-4 px-3 flex items-center justify-between bg-cool-gray-50">
                        <div class="w-11/12">
                            <h4 class="ui horizontal left aligned divider header">
                                <div class="p-3 rounded bg-white shadow border border-red-100 hover:border-red-200">
                                    <i class="large flask icon"></i>
                                    1 {birim} {ürün}
                                </div>
                            </h4>
                        </div>
                        <div class="pl-4 flex">
                            {{-- MALZEMELER BARINI AÇAN BUTON --}}
                            <div class="ui buttons">
                                <button wire:click.prevent @click="materials = true" class="ui icon small teal button" data-tooltip="{{ __('sections/recipes.add_ingredients') }}">
                                    <i class="plus icon"></i>
                                </button>
                                <button wire:click.prevent="clearIngredients" class="ui icon small gray basic button" data-tooltip="{{ __('sections/recipes.remove_ingredients') }}">
                                    <i class="red trash icon"></i>
                                </button>
                            </div>
                        </div>
                    </div>

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
                                    <div class="text-sm text-center">{ürün} içeriği burada görüntülenecek</div>
                                </div>
                                @else
                                @foreach ($ingredients as $key => $ingredient)
                                    <div class="bg-white shadow rounded-lg flex relative hover:shadow-outline-teal">

                                        <div class="w-16 flex pl-2 rounded-l-lg justify-center items-center shadow-md">
                                            {{-- image field --}}
                                            <i class="large box icon"></i>
                                        </div>

                                        <div class="flex flex-1 justify-between items-center p-3">
                                            <div>
                                                <div class="font-bold">{{ $ingredient['name'] }}</div>
                                                <div class="text-sm text-gray-500">{{ $ingredient['code'] }}</div>
                                            </div>
                                            {{-- inputs --}}
                                            <div class="">
                                                <div class="field flex gap-2">
                                                    <div class="ui icon input small">
                                                        <input wire:model="amount.{{ $key }}" type="text" placeholder="Miktar">
                                                        <i class="calculator icon"></i>
                                                    </div>
                                                    <div wire:ignore>
                                                        <x-dropdown.search model="unit.{{ $key }}" :collection="$this->units" value="id" placeholder="sections/units.unit" text="name" class="ui search selection dropdown" />
                                                    </div>
                                                </div>
                                            </div>

                                        </div>
                                        <button wire:click.prevent="removeIngredient({{ $key }})" class="absolute top-0 right-0 -mt-2 -mr-3 focus:outline-none hover:opacity-100 opacity-50">
                                            <i class="red shadow rounded-full cancel icon"></i>
                                        </button>
                                    </div>
                                @endforeach
                                @endif
                            </div>
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
            {{-- @endif --}}
            
        </div> {{-- segment ending --}}
        
        <div>
            @if ($success)
                <div class="ui positive icon message">
                    <i class="checkmark  icon"></i>
                    <div class="content">
                        <div class="header">
                            <p>{{ __('common.saved_successfully') }}</p>
                        </div>
                        <p>{{ __('common.saved_successfully') }}</p>
                    </div>
                </div>
            @endif
            {{-- <hr> --}}
        </div>

        <x-form-buttons />
        
    </form>
    
</div>