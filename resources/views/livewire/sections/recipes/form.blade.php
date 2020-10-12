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
        
            {{-- <hr> --}}
            @if ($currentProduct)
            
                <div class="shadow-inner rounded-lg p-3">
                    {{-- <div class="ui segment"> --}}

                        <div class="ui internally celled grid border rounded-lg">

                            <div class="five wide column bg-orange-50 rounded-l-lg">
                                <h5 class="ui horizontal header text-center">
                                    <i class="vial icon"></i>
                                    Malzemeler
                                </h5>
                                
                                <div class="overflow-x-hidden h-40 xl:h-96 border-t border-b p-2 pt-4">
                                    {{-- <div class="ui animated selection list">
                                        @foreach ($this->unproducibleProducts as $product)
                                            <li class="item" wire:click.prevent="addIngredient({{ $product }})">
                                                {{ $product->name }} - {{ $product->code }}
                                            </li>
                                        @endforeach
                                    </div> --}}
                                    @foreach ($this->categories as $category)
                                    <div class="relative" x-data="{open: false}">
                                        <div class="absolute w-full h-9 cursor-pointer text-right" @click="open = !open">
                                            <i  :class="{'caret down text-teal-800 icon': open, 'caret right icon': !open}"></i>
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

                            <div class="eleven wide column bg-green-50 text-center rounded-r-lg">
                                @if ($ingredients)

                                    <h6 class="ui horizontal header">
                                        <p>
                                            <i class="flask big icon"></i>
                                            1 {birim} <span class="text-red-500">{{ ucfirst($currentProduct->name) }}({{$currentProduct->code}})</span> </small> şunları içerir
                                        </p>
                                    </h6>
                                
                                    <div class="overflow-x-hidden h-40 xl:h-96 border-t border-b p-2">
                                        {{-- <div class="ui two doubling cards"> --}}
                                        <div class="flex flex-col gap-3">
                                            @foreach ($ingredients as $key => $ingredient)
                                                <div class="relative">
                                                    <div class="p-4 bg-white rounded-md shadow flex justify-between items-center">
                                                        <div class="shadow border p-2 hover:bg-gray-50 rounded">
                                                            <strong>{{ $ingredient['name'] }} - {{ $ingredient['code'] }}</strong>
                                                        </div>
                                                        <div class="field">
                                                            <div class="ui right action left icon small input" wire:ignore>
                                                                <i class="calculator icon"></i> 
                                                                <input wire:model.lazy="amount.{{ $key }}" type="text" placeholder="{{ __('sections/recipes.amount') }}">
                                                                <x-dropdown.search model="unit.{{ $key }}" :collection="$this->units" value="id" placeholder="sections/units.unit" text="name" class="ui search selection dropdown" />
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <button wire:click.prevent="removeIngredient({{ $key }})" class="absolute top-0 right-0 -mt-2 -mr-3 focus:outline-none hover:opacity-100 opacity-50">
                                                        <i class="red shadow rounded-full cancel icon"></i>
                                                    </button>
                                                </div>
                                            @endforeach

                                        </div>
                                        {{-- </div> --}}
                                    </div>
                                @else
                                    <div class="ui placeholder segment h-full">
                                        <div class="ui icon header">
                                            <i class="atom left bottom corner icon"></i>
                                            <i class="flask icon"></i>
                                            Soldan reçete içeriği oluşturun
                                        </div>
                                        <div class="text-sm">{{ ucfirst($currentProduct->name) }} içeriği burada görüntülenecek</div>
                                    </div>
                                @endif
                            </div>

                        </div>
                </div>
            @endif
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


<script>
    // $(document).ready(function () {
        // $('.basic .dropdown').each(function() {
        //     $(this).dropdown();

        // })

    //     document.addEventListener("livewire:load", () => {
	//         Livewire.hook('message.processed', (message, component) => {
	// 	        $('.ui .dropdown').dropdown();
    
	// }); });
    // });
</script>
