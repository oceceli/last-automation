<x-content>
    <x-slot name="header">
        <x-page-header icon="invoice file" header="{{ __('salestypes.create_salestype') }}"></x-page-header>
    </x-slot>

    <form class="ui mini form">
        <div class="p-6">
            <div class="equal width fields">
                <x-input model="st_name" label="{{ __('validation.attributes.st_name') }}" placeholder="{{ __('validation.attributes.st_name') }}" class="required" />
                <x-input model="st_abbr" label="{{ __('validation.attributes.st_abbr') }}" placeholder="{{ __('validation.attributes.st_abbr') }}" class="required" />
            </div>
            <div class="pt-5">
                <button @click="salesTypeModal = false" class="ui green mini button" wire:click.prevent="submitSalesType">
                    {{ __('common.save') }}
                </button>
            </div>
        </div>
    </form>
</x-content>
