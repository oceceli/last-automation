<div class="p-6 bg-white bg-opacity-25 shadow rounded-lg ">

    <h3 class="ui horizontal left aligned divider header">
        <i class="mortar pestle icon"></i>
        <div class="content">
          {{ __('sections/recipes.header') }}
          <div class="sub header">{{ __('sections/recipes.subheader') }}</div>
        </div>
    </h3>
    <div class="relative w-6/12">
        <div class="p-4 bg-white rounded-md shadow flex justify-between">
            <div><strong>asdf {code}</strong></div>
            <div class="flex gap-3">
                <div>
                    <input type="number" class="border-b focus:outline-none w-20" placeholder="miktar">
                </div>
                <div class="">
                    <select class="focus:outline-none">
                        <option selected>Birim</option>
                        <option value="kg">kg</option>
                        <option value="g">g</option>
                    </select>
                </div>
            </div>
        </div>
        <button class="absolute bottom-11 right-0 -mr-3 focus:outline-none hover:opacity-100 opacity-50">
            <i class="red shadow rounded-full cancel icon"></i>
        </button>
    </div>
    <form class="ui form" wire:submit.prevent="submit" wire:loading.class="loading">
        <div class="ui raised teal padded segment">
            <div class="equal width fields pb-4">
                <div class="required field">
                    <label>{{ __('sections/recipes.recipe_product') }}</label>
                    <select wire:model.lazy="product_id" id="product_id_select" class="ui dropdown icon">
                        <option selected>Ürün seçiniz...</option>
                        @foreach ($this->products as $product)
                            <option value="{{ $product->id }}">{{ $product->name }}</option>
                        @endforeach
                    </select>
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
            
                <div class="shadow-inner rounded-lg p-3">
                    <div class="ui segment">
                    @if ($currentProduct)

                        <div class="ui internally celled grid border rounded-lg">

                            <div class="five wide column bg-orange-50 rounded-l-lg text-center">
                                <h5 class="ui horizontal header">
                                    <i class="vial icon"></i>
                                    Malzemeler
                                </h5>
                                
                                <div class="overflow-x-hidden h-40 xl:h-96 border-t border-b p-2">
                                    <div class="ui animated selection list">
                                        @foreach ($this->products as $product)
                                            <li class="item" wire:click.prevent="addIngredient({{ $product }})">
                                                {{ $product->name }} - {{ $product->code }}
                                            </li>
                                        @endforeach
                                    </div>
                                </div>
                            </div>

                            <div class="eleven wide column bg-green-50 text-center rounded-r-lg">
                                @if ($ingredients)

                                    <h6 class="ui horizontal divider header">
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
                                                    <div class="p-4 bg-white rounded-md shadow flex justify-between">
                                                        <div><strong>{{ $ingredient['name'] }}</strong></div>
                                                        <div class="flex gap-3">
                                                            {{-- <div> --}}
                                                                <input type="number" class="border-b focus:outline-none w-20" placeholder="miktar">
                                                            {{-- </div> --}}
                                                            {{-- <div class="">
                                                                <select class="focus:outline-none ">
                                                                    <option selected>Birim</option>
                                                                    <option value="kg">kg</option>
                                                                    <option value="g">g</option>
                                                                </select>
                                                            </div> --}}
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
                                            Yan taraftan reçete içeriği oluşturun
                                        </div>
                                        <div class="text-sm">{{ ucfirst($currentProduct->name) }} içeriği burada görüntülenecek</div>
                                    </div>
                                @endif
                            </div>

                        </div>
                        {{-- <div class="ui vertical full divider"></div> --}}
                    @else
                        <div class="ui placeholder segment"></div>
                    @endif
                    </div>
                </div>

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
    $(document).ready(function () {
        let select = $('.ui .dropdown');
        select.dropdown();
        $('body').on('mousemove', function() {
                select.dropdown();
            });
    });
</script>



{{-- <div class="shadow-inner border-r border-l rounded-lg p-5 ">
            
    <h3 class="ui dividing header">
        <i class="write small icon"></i>
        <div class="content">
            İçerik
            <div class="sub header">Manage your preferences</div>
        </div>
    </h3>
    
    <div class="equal width fields py-4">
        <div class="field">
            <label>{{ __('sections/recipes.product') }}</label>
            <select wire:model.lazy="product_id"  class="">
                <option selected>Ürün seçiniz...</option>
                @foreach ($this->products as $product)
                    <option value="{{ $product->id }}">{{ $product->name }}</option>
                @endforeach
            </select>
        </div>
    </div>
    
    <div class="flex justify-end">
        <button class="ui icon teal button" wire:click.prevent>
            <i class="icon plus"></i>
        </button>
    </div>
</div> --}}