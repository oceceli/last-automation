<x-table-row>
    <x-tbody-item class="center aligned">
            <x-span tooltip="{{ __('common.suspended') }}" position="top left">
                <i class="large grey ban icon"></i>
            </x-span>
    </x-tbody-item>
    
    @include('web.sections.dispatchorders.daily.table-rows.do-row-common')

    <x-tbody-item class="right aligned">
        <a href="{{ route('dispatchorders.prepare', ['dispatchOrder' => $dispatchOrder]) }}" class="ui red label button">
            {{ __('dispatchorders.get_ready') }}
            <i class="right arrow icon"></i>
        </a>
    </x-tbody-item>
    
</x-table-row>