{{-- <div>
    <x-table class="single line selectable red ">
        @include('web.sections.dispatchorders.daily.prepare.table-by-states.prepare-common')
        <x-tbody>
            @foreach($dispatchOrder->dispatchProducts as $key => $dp)
                <x-tbody-item class="collapsing center aligned">
                    icon
                </x-tbody-item>
                <x-tbody-item class="collapsing">
                    <span class="font-bold">{{ $dp->product->prd_code }}</span>
                    <span class="text-xs text-ease">{{ $dp->product->prd_name }}</span>
                </x-tbody-item>
                <x-tbody-item class="">
                    <span class="font-bold">{{ (float)$dp->dp_amount }} </span>
                    <span class="text-sm">{{ $dp->product->baseUnit->name }}</span>
                </x-tbody-item>
                <x-tbody-item class="right aligned">
                    buton
                </x-tbody-item>
            @endforeach
        </x-tbody>
    </x-table>
</div> --}}