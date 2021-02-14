<div>
    <x-content>
        <x-slot name="header">
            <x-page-header icon="blue open box" header="products.details.header" subheader="{{ __('products.details.subheader', ['product' => $product->name]) }}" >
                <x-slot name="buttons">
                    <div class="ui mini icon buttons">
                        <a href="{{ route('products.edit', ['product' => $product]) }}" class="ui teal button" data-variation="mini" data-tooltip="{{ __('common.edit') }}" data-position="left center">
                            <i class="pen alternate icon"></i>
                        </a>
                        <button wire:click.prevent="delete" class="ui mini gray basic button" data-variation="mini" data-tooltip="{{ __('common.delete') }}" data-position="left center">
                            <i class="red trash icon"></i>
                        </button>
                    </div>
                </x-slot>
            </x-page-header>
        </x-slot>
            <x-product-details :product="$product" />
    </x-content>
</div>
