<div class="p-6 bg-white bg-opacity-25 shadow rounded-lg">

    <h3 class="ui horizontal left aligned divider header">
        <i class="mortar pestle icon"></i>
        <div class="content">
          {{ __('sections/recipes.header') }}
          <div class="sub header">{{ __('sections/recipes.subheader') }}</div>
        </div>
    </h3>

    <form class="ui form" wire:submit.prevent="submit" wire:loading.class="loading">
        <div class="ui raised teal padded segment">
            <div class="equal width fields pb-2">
                <div class="required field">
                    <label>{{ __('sections/recipes.recipe_product') }}</label>
                    <select wire:model.lazy="recipe_id" id="product_id_select" class="ui dropdown icon">
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
            <h4 class="ui horizontal divider header">
                <i class="flask!! exchange  icon"></i>
                İçerik ekle
            </h4>
            @if ($currentProduct)
                <div class="shadow-inner rounded-lg p-3">
                    <div class="ui segment">
                        <div class="ui two column grid">

                        <div class="column">
                            <h5 class="ui horizontal divider header">
                                <i class="layer group  icon"></i>
                                Ham ürünler
                            </h5>
                            
                            <div class="ui animated selection list overflow-x-hidden h-40">
                                @foreach ($this->products as $product)
                                    <li class="item">
                                        {{ $product->name }}
                                    </li>
                                @endforeach
                            </div>
                        </div>

                        <div class="column">
                            <h5 class="ui horizontal divider header">
                                <i class="barcode icon"></i>
                            
                            </h5>
                        </div>

                        </div>
                        <div class="ui vertical full divider">
                            
                        </div>
                    </div>
                </div>
            @else
                <div class="ui placeholder segment"></div>
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