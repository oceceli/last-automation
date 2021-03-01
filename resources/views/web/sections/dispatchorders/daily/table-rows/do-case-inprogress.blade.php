<x-table-row >
    <x-tbody-item class="center aligned">
        <x-span tooltip="{{ __('dispatchorders.products_loading_into_the_vehicle') }}" position="top left">
            <i class="large yellow loading cog icon"></i>
        </x-span>
    </x-tbody-item>

    @include('web.sections.dispatchorders.daily.table-rows.do-row-common')

    <x-tbody-item class="right aligned" x-data="{preparedCurrent: false}">
        <x-menu-dropdown main="{{ __('common.prepare_or_review') }} U" action="redirectPrepare({{ $dispatchOrder->id }})" color="blue" icon="open box icon">
            <div wire:key="do_menu{{ $dispatchOrder->id }}" @click="preparedCurrent = true" class="item text-red-600"> 
                <i class="link box icon"></i>
                {{ __('dispatchorders.prepared_products') }} S
            </div>
        </x-menu-dropdown>

        <x-custom-modal wire:key="do_modal{{ $dispatchOrder->id }}" active="preparedCurrent" header="{{ __('validation.attributes.do_number') }}: {{ $dispatchOrder->do_number}} - {{ $dispatchOrder->address->adr_name }}">
            <x-reserved-stocks-table :reservations="$dispatchOrder->reservedStocks" class="p-3" />
            <div class="p-3 text-left text-orange-600">
                <i class="small info icon"></i>
                <span class="font-bold text-sm">{{ __('dispatchorders.preparing_or_loading_on_vehicle_in_progress') }}</span>
            </div>
        </x-custom-modal>

    </x-tbody-item>

    
</x-table-row>