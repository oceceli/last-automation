<x-table-row class="positive">
    <x-tbody-item class="center aligned">
        <x-span tooltip="{{ __('common.approved') }}" position="top left">
            <i class="green check double icon"></i>
        </x-span>
    </x-tbody-item>
    
    @include('web.sections.dispatchorders.daily.table-rows.do-row-common')
    
    <x-tbody-item class="right aligned">
        <a href="{{ route('dispatchorders.prepare', ['dispatchOrder' => $dispatchOrder]) }}" class="ui green label button">
            {{ __('dispatchorders.dispatch_details') }}
            <i class="right arrow icon"></i>
        </a>
    </x-tbody-item>
</x-table-row>