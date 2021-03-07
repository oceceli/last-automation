<div {{ $attributes }}>
    <x-table class="">
        @if (!$noHead)
        <x-thead>
            <x-table-row>
                @if (!$noProduct)
                    <x-thead-item>{{ __('products.code') }}</x-thead-item>
                @endif
                <x-thead-item>{{ __('dispatchorders.lot_number') }}</x-thead-item>
                <x-thead-item class="right aligned">{{ __('common.amount') }}</x-thead-item>
            </x-table-row>
        </x-thead>
        @endif
        <x-tbody>
            @forelse($reservations as $reservation)
                <x-table-row class="text-ease hover:bg-cool-gray-100">
                    @if (!$noProduct)
                        <x-tbody-item>
                            {{ $reservation->product->prd_code }}
                            <span class="text-sm">({{ $reservation->product->prd_name }})</span>
                        </x-tbody-item>
                    @endif
                    <x-tbody-item>
                        Lot:
                        <span class="text-blue-700 font-bold">
                            {{ $reservation->reserved_lot }}
                        </span>
                    </x-tbody-item>
                    {{-- <x-tbody-item class="font-bold right aligned">{{ number_format($reservation->reserved_amount, 3, ',', '') }} {{ $reservation->product->baseUnit->name }}</x-tbody-item> --}}
                    <x-tbody-item class="font-bold right aligned text-blue-700">{{ number_format($reservation->reserved_amount, 2, ',', '.') }} {{ $reservation->product->baseUnit->name }}</x-tbody-item>
                </x-table-row>
            @empty
                <tr class="p-5 bg-red-900 shadow-inner text-white">
                    <x-tbody-item>
                        {{ __($emptyMessage) }}...
                    </x-tbody-item>   
                </tr>                
            @endforelse
        </x-tbody>
    </x-table>
</div>