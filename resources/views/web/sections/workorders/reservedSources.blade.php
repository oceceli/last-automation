@if ($reservedSourcesModal)
    <div x-data="{reservedSourcesModal: @entangle('reservedSourcesModal')}">
        <x-custom-modal active="reservedSourcesModal" header="{{ __('sections/workorders.reserved_resources_for_manufacturing_product', ['product' => $reservedSourcesData->product->name]) }}">
                <div class="p-4">
                    <x-table>
                        <x-thead>
                            <tr>
                                <x-thead-item>{{ __('sections/products.name') }}</x-thead-item>
                                <x-thead-item>{{ __('sections/workorders.reserve_lot') }}</x-thead-item>
                                <x-thead-item class="right aligned">{{ __('sections/workorders.reserved_amount') }}<span class="text-red-800">*</span></x-thead-item>
                            </tr>
                        </x-thead>
                        <x-tbody>
                            @foreach ($reservedSourcesData->reservedStocks as $reserved)
                                <tr class="text-ease hover:bg-cool-gray-100">
                                    <x-tbody-item>
                                        {{ $reserved->product->name }} 
                                        <span class="text-xs">({{ $reserved->product->code }})</span>
                                    </x-tbody-item>
                                    <x-tbody-item>{{ $reserved->reserved_lot }}</x-tbody-item>
                                    <x-tbody-item class="font-bold right aligned">{{ number_format($reserved->reserved_amount, 3, ',', '') }} {{ $reserved->product->baseUnit->name }}</x-tbody-item>
                                </tr>
                            @endforeach
                        </x-tbody>
                    </x-table>
                    <div class="text-xs text-red-800 border-t pt-4">
                        *{{ __('sections/workorders.reserved_sources_will_be_used_as_needed_when_production_is_finalized') }}
                    </div>
                </div>
        </x-custom-modal>
    </div>
@endif