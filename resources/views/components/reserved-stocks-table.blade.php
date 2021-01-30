<div {{ $attributes->merge(['class' => 'shadow'])}}>
    <x-table class="small">
        <x-thead>
            <x-table-row>
                <x-thead-item>{{ __('sections/products.code') }}</x-thead-item>
                <x-thead-item>{{ __('dispatchorders.lot_number') }}</x-thead-item>
                <x-thead-item class="right aligned">{{ __('common.amount') }}</x-thead-item>
            </x-table-row>
        </x-thead>
        <x-tbody>
            @forelse($model->reservedStocks as $reservation)
                <x-table-row class="text-ease hover:bg-cool-gray-100">
                    <x-tbody-item>
                        {{ $reservation->product->code }}
                        <span class="text-xs">({{ $reservation->product->name }})</span>
                    </x-tbody-item>
                    <x-tbody-item>{{ $reservation->reserved_lot }}</x-tbody-item>
                    {{-- <x-tbody-item class="font-bold right aligned">{{ number_format($reservation->reserved_amount, 3, ',', '') }} {{ $reservation->product->baseUnit->name }}</x-tbody-item> --}}
                    <x-tbody-item class="font-bold right aligned">{{ (float)$reservation->reserved_amount }} {{ $reservation->product->baseUnit->name }}</x-tbody-item>
                </x-table-row>
            @empty
                <x-table-row class="p-5">
                    <x-tbody-item>
                        {{ __('common.empty') }} 
                    </x-tbody-item>   
                </x-table-row>                
            @endforelse
        </x-tbody>
    </x-table>
</div>