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
                <div class="w-full h-40 md:h-64 bg-red-300 p-2">
                    <div class="">
                        asdfds
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