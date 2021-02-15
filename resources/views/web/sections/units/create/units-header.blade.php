{{-- BAŞLIK VE BUTONLAR --}}
<div>
    <x-page-header class="pt-5 px-4">
        <x-slot name="customHeader">
            <div class="flex">
                <div>
                    <span class="text-red-600">{{ $selectedProduct->prd_name }}</span>
                    <span class="text-sm">{{ __('units.units') }}</span>
                </div>
                <span></span>
            </div>
        </x-slot>
        <x-slot name="buttons">
            <button wire:click.prevent="addNewCard" class="ui icon mini teal button"
                data-tooltip="{{ __('common.add_new') }}" data-variation="mini">
                <i class="plus icon"></i>
            </button>
            {{-- <button wire:click.prevent="removeAllCards" class="ui icon mini gray basic button"
                data-tooltip="{{ __('common.remove_all') }}" data-variation="mini">
                <i class="red trash icon"></i>
            </button> --}}
        </x-slot>
    </x-page-header>
</div>