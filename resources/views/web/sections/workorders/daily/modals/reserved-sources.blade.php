@if ($reservedSourcesModal)
    <div x-data="{reservedSourcesModal: @entangle('reservedSourcesModal')}">
        <x-custom-modal active="reservedSourcesModal" header="{{ __('workorders.reserved_resources_for_manufacturing_product', ['product' => $reservedSourcesData->product->prd_name]) }}">
                <div class="p-4">
                    <x-table>
                        <x-thead>
                            <x-table-row>
                                <x-thead-item>{{ __('products.prd_name') }}</x-thead-item>
                                <x-thead-item>{{ __('workorders.reserve_lot') }}</x-thead-item>
                                <x-thead-item class="right aligned">{{ __('workorders.reserved_amount') }}<span class="text-red-800">*</span></x-thead-item>
                            </x-table-row>
                        </x-thead>
                        <x-tbody>
                            @foreach ($reservedSourcesData->reservedStocks as $reserved)
                                <x-table-row class="text-ease hover:bg-cool-gray-100">
                                    <x-tbody-item>
                                        {{ $reserved->product->prd_name }} 
                                        <span class="text-xs">({{ $reserved->product->prd_code }})</span>
                                    </x-tbody-item>
                                    <x-tbody-item>{{ $reserved->reserved_lot }}</x-tbody-item>
                                    <x-tbody-item class="font-bold right aligned">{{ number_format($reserved->reserved_amount, 3, ',', '') }} {{ $reserved->product->baseUnit->name }}</x-tbody-item>
                                </x-table-row>
                            @endforeach
                        </x-tbody>
                    </x-table>
                    <div class="text-xs text-red-800 border-t pt-4">
                        *{{ __('workorders.reserved_sources_will_be_used_as_needed_when_production_is_finalized') }}
                    </div>
                </div>
        </x-custom-modal>
    </div>
@endif