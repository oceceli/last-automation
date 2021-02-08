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
                        <x-thead-item sortBy="do_planned_datetime">{{ __('validation.attributes.do_planned_datetime') }}</x-thead-item>
                        <x-thead-item>{{ __('validation.attributes.do_status') }}</x-thead-item>
            
                        <x-thead-item></x-thead-item>
                    </x-table-row>
                </x-thead>
                <x-tbody>
                    @forelse ($data as $dispatchOrder)
                        <x-table-row wire:key="{{ $loop->index }}" class="{{ $this->tableClass($dispatchOrder)['row'] }} font-semibold">
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
                            </x-body-item>
                            <x-tbody-item class="collapsing text-xs">{{ $dispatchOrder->do_planned_datetime }}</x-tbody-item>
                            <x-tbody-item class="collapsing text-xs">
                                <i class="{{ $this->tableClass($dispatchOrder)['status']}}"></i>
                                {{ __("dispatchorders.{$dispatchOrder->do_status}") }}
                            </x-tbody-item>
                            <x-tbody-item class="collapsing">
                                @if ($dispatchOrder->isDeletable())
                                    <x-crud-actions delete edit modelName="dispatchorder" :modelId="$dispatchOrder->id">
                                        <x-slot name="left">
                                            <div wire:click="openDetailsModal({{ $dispatchOrder->id }})" data-tooltip="{{ __('common.detail') }}" data-variation="mini">
                                                <i class="link eye icon"></i>
                                            </div>
                                        </x-slot>
                                    </x-crud-actions>
                                @else
                                    <x-crud-actions modelName="dispatchorder" :modelId="$dispatchOrder->id">
                                    <div class="text-center">
                                        <span wire:click="openDetailsModal({{ $dispatchOrder->id }})" data-tooltip="{{ __('common.detail') }}" data-variation="mini">
                                            <i class="link eye icon"></i>
                                        </span>
                                    </div>
                                    </x-crud-actions>
                                @endif
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






    @if ($detailsModal && $selectedDo)
        <div x-data="{detailsModal: @entangle('detailsModal')}">
            <x-custom-modal active="detailsModal" header="{{ __('dispatchorders.do_number_numbered_dispatchorder', ['do_number' => $selectedDo->do_number]) }}">

                <x-form-divider noButtons bottomClass="{{ $this->statusClass()['bottomClass'] }}" lClass="{{ $this->statusClass()['lClass'] }}" rClass="{{ $this->statusClass()['rClass'] }}">
                    <x-slot name="left">
                        <div class="p-4 shadow-md border rounded">
                            <x-list-item>
                                <span>{{ __('validation.attributes.do_number') }}</span>
                                <span>{{ $selectedDo->do_number }}</span>
                            </x-list-item>
                            <x-list-item>
                                <span>{{ __('common.customer') }}</span>
                                <span>{{ $selectedDo->company->cmp_commercial_title }}</span>
                            </x-list-item>
                            <x-list-item>
                                <span>{{ __('validation.attributes.do_planned_datetime') }}</span>
                                <span>{{ $selectedDo->do_planned_datetime }}</span>
                            </x-list-item>
                            @if ($selectedDo->isApproved())
                            <x-list-item>
                                <span>
                                    <i class="double check icon green" ></i>
                                    {{ __('validation.attributes.do_actual_datetime') }}
                                </span>
                                <span>{{ $selectedDo->do_actual_datetime }}</span>
                            </x-list-item>
                            @endif
                        </div>
                    </x-slot>

                    <x-slot name="right">
                        @foreach ($selectedDo->dispatchProducts as $dp)
                            <x-list-item>
                                <span>{{ $dp->product->name }}</span>
                                <span>{{ $dp->dp_amount }} {{ $dp->unit->name }}</span>
                            </x-list-item>
                        @endforeach
                    </x-slot>

                    <x-slot name="bottom">
                        <div class="flex justify-between">
                            <div>
                                {{ __('dispatchorders.dispatch_address') }}
                                <div class="flex flex-col py-2 gap-2 text-ease">
                                    <span id="copy-area">{{ $selectedDo->fullAddress() }}</span>
                                    <div>{{ __('validation.attributes.adr_phone') }}: {{ $selectedDo->address->adr_phone }}</div>
                                </div>
                            </div>
                            <div>
                                <button onclick="copy('copy-area', '{{ __('addresses.address_copied') }}')" class="focus:outline-none hover:text-red-800" data-tooltip="{{ __('common.copy') }}" data-position="left center" data-variation="mini">
                                    <i class="copy outline icon"></i>
                                </button>
                            </div>
                        </div>
                        @if ($selectedDo->do_note)
                            <div class="mt-4 p-2 border rounded shadow">
                                <i class="comment alternate outline flipped icon"></i>
                                <i class="text-green-700">“{{ $selectedDo->do_note }}”</i>
                            </div>
                        @endif
                    </x-slot>

                </x-form-divider>

            </x-custom-modal>
        </div>
    @endif

</div>

