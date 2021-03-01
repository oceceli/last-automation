<x-table-row>
    <x-tbody-item class="center aligned">
        <x-span tooltip="{{ __('dispatchorders.waiting_for_dispatch') }}" position="top left">
            <i class="large primary clock outline icon"></i>
        </x-span>
    </x-tbody-item>

    @include('web.sections.dispatchorders.daily.table-rows.do-row-common')

    <x-tbody-item class="right aligned">
        <a href="{{ route('dispatchorders.prepare', ['dispatchOrder' => $dispatchOrder]) }}" class="ui blue label button">
            <i class="box icon"></i>
            {{ __('common.prepare') }}
        </a>
    </x-tbody-item>
    
</x-table-row>