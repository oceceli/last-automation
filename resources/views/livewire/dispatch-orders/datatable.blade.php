<div>
    <x-table-toolbar :perPage="$perPage">
        <x-slot name="filters">
            
            <div class="responsive-grid-3-4">
                <div>
                    <label for="wofilterselect-do_number">{{ __('validation.attributes.do_number') }}: </label>
                    <input wire:model="filterDoNumber" placeholder="{{ __('validation.attributes.do_number') }}" id="wofilterselect-do_number" class="basic-select text-sm" />
                </div>
                <div>
                    <label for="wofilterselect-company">{{ __('common.customer') }}: </label>
                    <select wire:model="filterCompany" id="wofilterselect-company" class="basic-select text-xs">
                        <option value="" selected>{{ __('common.all') }}</option>
                        @foreach ($this->companies as $company)
                            <option value="{{ $company->id }}">
                                {{ $company->cmp_commercial_title }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label for="wofilterselect-address">{{ __('validation.attributes.address_id') }}: </label>
                    <select wire:model="filterAddress" id="wofilterselect-address" class="basic-select text-xs">
                        <option wire:key="default" value="" selected>{{ __('common.all') }}</option>
                        @if ($selectedCompany)
                            @foreach ($selectedCompany->addresses as $address)
                                <option value="{{ $address->id }}">
                                    {{ $address->adr_name }}
                                </option>
                            @endforeach
                        @endif
                    </select>
                </div>
                <div>
                    <label for="wofilterselect-salestype">{{ __('validation.attributes.sales_type_id') }}: </label>
                    <select wire:model="filterSalesType" id="wofilterselect-salestype" class="basic-select text-xs">
                        <option value="" selected>{{ __('common.all') }}</option>
                        @foreach ($this->salesTypes as $salesType)
                            <option value="{{ $salesType->id }}">
                                {{ $salesType->st_name }} - {{ $salesType->st_abbr }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label for="wofilterselect-states">{{ __('validation.attributes.do_status') }}: </label>
                    <select wire:model="filterDoStatus" id="wofilterselect-states" class="basic-select text-xs">
                        <option value="" selected>{{ __('common.all') }}</option>
                        @foreach ($this->doStates as $status)
                            <option value="{{ $status }}">
                                {{ __('dispatchorders.' . $status) }}
                            </option>
                        @endforeach
                    </select>
                </div>
                
            </div>

        </x-slot>    
    </x-table-toolbar> 

    <div>
        
        <x-table class="sortable very compact">
            <x-thead>
                <x-table-row>
                    <x-thead-item sortBy="do_number" class="center aligned collapsing">{{ __('validation.attributes.do_number') }}</x-thead-item>
                    <x-thead-item>{{ __('validation.attributes.company_id') }}</x-thead-item>
                    <x-thead-item>{{ __('dispatchorders.dispatch_address') }}</x-thead-item>
                    <x-thead-item class="collapsing center aligned">{{ __('validation.attributes.sales_type_id') }}</x-thead-item>
                    <x-thead-item sortBy="do_planned_datetime">{{ __('validation.attributes.do_planned_datetime') }}</x-thead-item>
                    <x-thead-item sortBy="do_actual_datetime">{{ __('validation.attributes.do_actual_datetime') }}</x-thead-item>
                    <x-thead-item class="collapsing center aligned">{{ __('validation.attributes.do_status') }}</x-thead-item>
        
                    <x-thead-item></x-thead-item>
                </x-table-row>
            </x-thead>
            <x-tbody>
                @forelse ($data as $dispatchOrder)
                    <x-table-row wire:key="{{ $loop->index }}" class="font-semibold">
                        <x-tbody-item class="collapsing center aligned font-bold">{{ $dispatchOrder->do_number }}</x-tbody-item>

                        <x-tbody-item class="collapsing">
                            {{ $dispatchOrder->company->cmp_commercial_title }}
                            <span class="text-xs text-ease">
                                ({{ __('validation.attributes.cmp_current_code')}}: {{ $dispatchOrder->company->cmp_current_code }})
                            </span>
                        </x-tbody-item>

                        <x-tbody-item class="collapsing">
                            {{ $dispatchOrder->address->adr_name }}
                            <span class="text-xs text-ease">
                                ({{ __('common.phone') }}: {{ $dispatchOrder->address->adr_phone }})
                            </span>
                        </x-tbody-item>
                        <x-tbody-item class="center aligned collapsing">
                            <x-span tooltip="{{ $dispatchOrder->salesType->st_name }}">
                                {{ $dispatchOrder->salesType->st_abbr }}
                            </x-span>
                        </x-tbody-item>
                        <x-tbody-item class="text-xs collapsing">{{ $dispatchOrder->do_planned_datetime }}</x-tbody-item>
                        <x-tbody-item class="text-xs collapsing">{{ $dispatchOrder->do_actual_datetime }}</x-tbody-item>
                        <x-tbody-item class="text-sm center aligned">
                            <span data-tooltip="{{ __("dispatchorders.{$dispatchOrder->do_status}") }}" data-variation="mini" data-position="left center">
                                <i class="{{ $dispatchOrder->statusLookup['icon'] }}"></i>
                            </span>
                        </x-tbody-item>
                        <x-tbody-item class="collapsing">
                            <div class="crud-buttons justify-around">
                                @can('view dispatchorders')
                                    <x-show-button wire:key="do_showbutton_{{$loop->index}}" action="openDetailsModal({{ $dispatchOrder->id }})" />
                                @endcan
                                @can('create update dispatchorders')
                                    @if ($dispatchOrder->isSuspended() || $dispatchOrder->isActive())
                                        <x-edit-button wire:key="do_editbutton_{{$loop->index}}" route="{{ route('dispatchorders.edit', ['dispatchorder' => $dispatchOrder]) }}" />
                                    @endif
                                @endcan
                                @can('delete dispatchorders')
                                    @if ($dispatchOrder->isSuspended() || $dispatchOrder->isActive())
                                        <x-delete-button wire:key="do_deletebutton_{{$loop->index}}" action="delete({{ $dispatchOrder->id }})"  />
                                    @endif
                                @endcan
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
    </div>
    {{ $data->links('components.tailwind-pagination') }}







    @if ($detailsModal && $selectedDo)
        <div x-data="{detailsModal: @entangle('detailsModal')}">
            <x-custom-modal active="detailsModal" header="{{ __('dispatchorders.do_number_numbered_dispatchorder', ['do_number' => $selectedDo->do_number]) }}">
                <x-dispatchorder-details :dispatchOrder="$selectedDo" />
            </x-custom-modal>
        </div>
    @endif

    @include('web.helpers.deletable')

</div>

