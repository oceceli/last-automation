<div class="p-4 bg-white shadow rounded-lg">
    <form class="ui form p-3" wire:submit.prevent="submit" wire:loading.class="loading">
        <div class="equal width fields">
            <div class="required field">
                <label>{{ __('sections/recipes.product') }}</label>
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
        <hr>
        
        <div class="equal width fields py-4">
            <div class="required field">
                <label>{{ __('sections/recipes.product') }}</label>
                <select wire:model.lazy="product_id"  class="">
                    <option selected>Ürün seçiniz...</option>
                    @foreach ($this->products as $product)
                        <option value="{{ $product->id }}">{{ $product->name }}</option>
                    @endforeach
                </select>
            </div>
        </div>



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
            <hr>
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