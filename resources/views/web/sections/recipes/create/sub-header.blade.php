<x-page-header>
    <x-slot name="customHeader">
        <div class="flex gap-2 text-xs md:text-base">
            <span class="font-bold">1</span>
            <span class="border-b-2 border-black pb-1" data-tooltip="{{ __('products.defined_base_unit_for_the_product', ['product' => $selectedProduct->prd_name]) }}" 
                data-variation="mini" data-position="top left">
                {{ $selectedProduct->baseUnit->name }}
            </span>
            <span class="font-bold text-red-700">{{ $selectedProduct->prd_name }}</span>
            <span class="text-gray-600">{{ __('recipes.includes') }}</span>
        </div>
    </x-slot>
    <x-slot name="buttons">
        @if ( ! $this->isLocked())
        <div class="ui mini icon buttons">
            <button wire:click.prevent @click="materials = true" class="ui mini teal button" data-tooltip="{{ __('recipes.add_ingredients') }}" data-variation="mini">
                <i class="plus icon"></i>
            </button>
            {{-- <button wire:click.prevent="removeAllCards" class="ui mini gray basic button" data-tooltip="{{ __('recipes.remove_ingredients') }}" data-variation="mini">
                <i class="red trash icon"></i>
            </button> --}}
            {{-- @if ($this->isLocked())
                <button class="ui mini gray basic button" data-tooltip="{{ __('common.unlock') }}" data-variation="mini">
                    <i class="orange lock icon"></i>
                </button>
            @endif --}}
        </div>
        @endif
    </x-slot>
</x-page-header>