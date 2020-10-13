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
                <div class="relative border rounded-t" x-data="{'materials' : false}">
                    
                    <div class="p-4 bg-cool-gray-100 shadow">
                        <h4 class="ui horizontal divider header">
                            <i class="red flask icon"></i>
                            1 {birim} {ürün} şunları içerir
                        </h4>
                    </div>

                    <div class="border-t relative">

                        {{-- İÇERİK - CARD KISMI --}}
                        <div class="md:h-96 overflow-x-hidden">                        
                            <div class="p-5">
                                <div class="ui two doubling horizontal cards">
                                @foreach ($ingredients as $key => $ingredient)
                                    <div class="ui card">
                                        {{-- <div class="image">
                                            <img src="/images/avatar2/large/elyse.png">
                                        </div> --}}
                                        <div class="content">
                                            <div class="header">{{ $ingredient['name'] }}</div>
                                            <div class="meta">
                                                <span class="code">{{ $ingredient['code'] }}</span>
                                            </div>
                                            <div class="description">
                                                <p>test</p>
                                            </div>
                                        </div>
                                        <div class="extra content">
                                            <div class="equal width fields">
                                                <div class="field">
                                                    <label>miktar</label>
                                                    <input wire:model="amount.{{ $key }}" type="text" placeholder="miktar" class="ui input">
                                                </div>
                                                <div class="field" wire:ignore>
                                                    <label>{{ __('sections/units.unit') }}</label>
                                                    <x-dropdown.search model="unit.{{ $key }}" :collection="$this->units" value="id" placeholder="sections/units.unit" text="name" class="ui search selection dropdown" />
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>

                        {{-- MALZEMELER BÖLÜMÜ - SIDEBAR ABSOLUTE--}}
                        <div x-show="materials" @click.away="materials = false"  class="bg-gray-50 w-1/4 h-full absolute top-0 z-10">
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
                                                    @foreach ($category->unproducibleProducts as $product)
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

                    {{-- MALZEMELER BARINI AÇAN BUTON --}}
                    <div class="absolute right-0 bottom-0 mb-2 mr-2" @click="materials = true" x-show="!materials">
                        <button wire:click.prevent class="ui circular icon large positive button" data-tooltip="{{ __('sections/recipes.add_ingredients') }}">
                            <i class="plus icon"></i>
                        </button>
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

        
        <div class="mt-8 flex justify-between items-center">
            <div></div>
            <div class="ui buttons">
                <button class="ui basic button labeled icon" type="reset" wire:click="clearFields">
                    <i class="undo alternate icon"></i>
                    Temizle
                </button>
                <button class="ui right labeled icon positive button" wire:loading.class="disabled loading" wire:target="submit">
                    <i class="angle right icon"></i>
                    Kaydet
                </button>
            </div>
        </div>
    </form>
    
</div>