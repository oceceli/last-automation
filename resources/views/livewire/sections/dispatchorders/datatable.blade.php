<div>
    <x-container>
        <x-table-toolbar :perPage="$perPage" /> 
        <div>
            
            <x-table class="ui celled sortable table tablet stackable very compact">
                <x-thead>
                    <x-table-row>
                        <x-thead-item sortBy="do_number" class="center aligned">{{ __('validation.attributes.do_number') }}</x-thead-item>
                        <x-thead-item>{{ __('validation.attributes.company_id') }}</x-thead-item>
                        <x-thead-item>{{ __('dispatchorders.dispatch_address') }}</x-thead-item>
                        <x-thead-item sortBy="do_datetime">{{ __('validation.attributes.do_datetime') }}</x-thead-item>
            
                        <x-thead-item></x-thead-item>
                    </x-table-row>
                </x-thead>
                <x-tbody>
                    @forelse ($data as $dispatchOrder)
                        <x-table-row wire:key="{{ $loop->index }}">
                            <x-tbody-item class="collapsing center aligned font-bold">{{ $dispatchOrder->do_number }}</x-tbody-item>

                            <x-tbody-item>
                                {{ $dispatchOrder->company->cmp_commercial_title }}
                                <span class="text-xs text-ease">
                                    ({{ __('validation.attributes.cmp_current_code')}}: {{ $dispatchOrder->company->cmp_current_code }})
                                </span>
                            </x-tbody-item>

                            <x-tbody-item>
                                {{ $dispatchOrder->address->adr_name }}
                                <span class="text-xs text-ease">
                                    ({{ __('common.phone') }}: {{ $dispatchOrder->address->adr_phone }})
                                </span>
                            </x-body-item>
                            <x-tbody-item class="collapsing text-xs">{{ $dispatchOrder->do_datetime }}</x-tbody-item>
                            <x-tbody-item class="collapsing">
                                <div>
                                    <x-crud-actions delete edit modelName="dispatchorder" :modelId="$dispatchOrder->id">
                                        <div wire:click="openShowModal({{ $dispatchOrder->id }})" data-tooltip="{{ __('common.detail') }}" data-variation="mini">
                                            <i class="link eye icon"></i>
                                        </div>
                                    </x-crud-actions>
                                </div>
                            </x-tbody-item>
                        </x-table-row>
                    @empty
                    <tr>
                        <td colspan="10">
                            <x-placeholder icon="truck">
                                {{ __('common.no_results') }}
                            </x-placeholder>
                        </td>
                    </tr>
                    @endforelse
                </x-tbody>
            </x-table>
            {{ $data->links('components.tailwind-pagination') }}
        </div>

    </x-container>

</div>