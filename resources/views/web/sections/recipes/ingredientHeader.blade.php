<x-page-header>
    <x-slot name="customHeader">
        <div class="flex gap-2 text-xs md:text-base">
            <span class="font-bold">1</span>
            <span class="border-b-2 border-black pb-1" data-tooltip="{{ __('sections/products.defined_base_unit_for_the_product', ['product' => $selectedProduct->name]) }}" 
                data-variation="mini" data-position="top left">
                {{ $spBaseUnit->name }}
            </span>
            <span class="font-bold text-red-700">{{ $selectedProduct->name }}</span>
            <span class="text-gray-600">{{ __('sections/recipes.includes') }}</span>
        </div>
    </x-slot>
    <x-slot name="buttons">
        <div class="ui mini icon buttons">
            <button wire:click.prevent @click="materials = true" class="ui mini teal button" data-tooltip="{{ __('sections/recipes.add_ingredients') }}" data-variation="mini">
                <i class="plus icon"></i>
            </button>
            <button wire:click.prevent="removeAllCards" class="ui mini gray basic button" data-tooltip="{{ __('sections/recipes.remove_ingredients') }}" data-variation="mini">
                <i class="red trash icon"></i>
            </button>
        </div>
    </x-slot>
</x-page-header>