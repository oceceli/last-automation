<div>
    <x-page-title icon="mortar pestle" header="recipes.header" subheader="recipes.subheader" />
    <div class="p-6 bg-white bg-opacity-25 shadow rounded-lg ">

        <form class="ui form" wire:submit.prevent="submit" wire:loading.class="loading">
            <div class="ui raised teal padded segment">
                <div class="equal width fields pb-4">
                    <div wire:ignore class="required field">
                        <label>{{ __('recipes.recipe_product') }}</label>
                        <x-dropdown.search model="product_id" :collection="$this->producibleProducts" value="id" text="name,code" class="ui search selection dropdown" />
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
                

                


                {{-- @if ($currentProduct) --}}
                    <x-listing :addedMaterial="$ingredients" removeItemFunction="removeIngredient">
                        
                        <x-slot name="title"> title
                            {{-- <div class="py-4 px-3 flex items-center justify-between bg-cool-gray-50">
                                <div class="w-11/12">
                                    <h4 class="ui horizontal left aligned divider header">
                                        <div class="p-3 rounded bg-white shadow border border-teal-100">
                                            <i class="large red flask icon"></i>
                                            1 {birim} {ürün}
                                        </div>
                                    </h4>
                                </div>
                                <div class="pl-4 flex">
                                    <div class="ui buttons">
                                        <button wire:click.prevent @click="materials = true" class="ui icon small teal button" data-tooltip="{{ __('recipes.add_ingredients') }}">
                                            <i class="plus icon"></i>
                                        </button>
                                        <button wire:click.prevent="clearIngredients" class="ui icon small gray basic button" data-tooltip="{{ __('recipes.remove_ingredients') }}">
                                            <i class="red trash icon"></i>
                                        </button>
                                    </div>
                                </div>
                            </div> --}}
                        </x-slot>

                        <x-slot name="ifNoMaterial">test
                            <div class="ui placeholder segment h-full">
                                <div class="ui icon header">
                                    <i class="blue atom left bottom corner icon"></i>
                                    <i class="flask icon"></i>
                                    <button @click="materials = true" wire:click.prevent class="text-blue-600 font-bold focus:outline-none">Buradan</button> reçete içeriği oluşturun
                                </div>
                                <div class="text-sm text-center">{ürün} içeriği burada görüntülenecek</div>
                            </div>
                        </x-slot>

                        <x-slot name="content">
                            @foreach ($addedMaterial as $key => $item)
                                <div class="bg-white shadow rounded-lg flex border border-red-100 relative hover:border-red-300" style="min-height: 50px">

                                    <div class="w-16 flex pl-2 rounded-l-lg justify-center items-center shadow-md">
                                        {{-- image field --}}
                                        <i class="large red box icon"></i>
                                    </div>

                                    {{ $content }}

                                    <button wire:click.prevent="{{ $removeItemFunction }}({{ $key }})" class="absolute top-0 right-0 -mt-2 -mr-3 focus:outline-none hover:opacity-100 opacity-50">
                                        <i class="red shadow rounded-full cancel icon"></i>
                                    </button>
                                    
                                </div>
                            @endforeach
                        </x-slot>
                                
                                
                        <x-slot name="plusButtonAction">test
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
                                                        <div class="description">{{ $category->unproducibleProducts->count() }} {{ ucfirst(__('products.product')) }}</div>
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
                        </x-slot>
                    </x-listing>




                    {{-- <x-listing>
                        
                    </x-listing> --}}




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
</div>