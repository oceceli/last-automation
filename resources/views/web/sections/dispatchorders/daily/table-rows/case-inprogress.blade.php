<x-table-row>
    <x-tbody-item class="center aligned">
        <x-span tooltip="{{ __('dispatchorders.products_loading_into_the_vehicle') }}" position="top left">
            <i class="large yellow loading cog icon"></i>
        </x-span>
    </x-tbody-item>

    @include('web.sections.dispatchorders.daily.table-rows.row-common')

    <x-tbody-item class="right aligned">
        <span x-data="{preparedCurrent: false}">
            <button @click="preparedCurrent = true" class="ui orange label button">
                {{ __('dispatchorders.prepared_products') }} S
            </button>
            <x-custom-modal active="preparedCurrent" header="{{ __('validation.attributes.do_number') }}: {{ $dispatchOrder->do_number}} - {{ $dispatchOrder->address->adr_name }}">
                <x-reserved-stocks-table :reservations="$dispatchOrder->reservedStocks" class="p-3" />
                <div class="p-3 text-left text-orange-600">
                    <i class="small info icon"></i>
                    <span class="font-bold text-sm">{{ __('dispatchorders.preparing_or_loading_on_vehicle_in_progress') }}</span>
                </div>
            </x-custom-modal>
        </span>
        <a href="{{ route('dispatchorders.prepare', ['dispatchOrder' => $dispatchOrder]) }}" class="ui orange label button">
            <i class="open box icon"></i>
            {{ __('common.prepare_or_review') }} U
        </a>
    </x-tbody-item>
    
</x-table-row>