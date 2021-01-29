<x-table-row>
    <x-tbody-item class="center aligned">
        <x-span tooltip="{{ __('dispatchorders.waiting_for_dispatch') }}" position="top left">
            <i class="large primary clock outline icon"></i>
        </x-span>
    </x-tbody-item>

    @include('web.sections.dispatchorders.todaytablerows.row-common')

    <x-tbody-item class="right aligned">
        <a href="{{ route('dispatchorders.process', ['dispatchOrder' => $dispatchOrder]) }}" class="ui red label button">
            <i class="open box icon"></i>
            {{ __('common.prepare') }}
        </a>
    </x-tbody-item>
    
</x-table-row>