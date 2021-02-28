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
                        <option value="" selected>{{ __('common.all') }}</option>
                        @foreach ($this->addresses as $address)
                            <option value="{{ $address->id }}">
                                {{ $address->adr_name }}
                            </option>
                        @endforeach
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
        
        <x-table class="ui celled sortable table tablet stackable very compact">
            <x-thead>
                <x-table-row>
                    <x-thead-item sortBy="do_number" class="center aligned">{{ __('validation.attributes.do_number') }}</x-thead-item>
                    <x-thead-item>{{ __('validation.attributes.company_id') }}</x-thead-item>
                    <x-thead-item>{{ __('dispatchorders.dispatch_address') }}</x-thead-item>
                    <x-thead-item>{{ __('validation.attributes.sales_type_id') }}</x-thead-item>
                    <x-thead-item sortBy="do_planned_datetime">{{ __('validation.attributes.do_planned_datetime') }}</x-thead-item>
                    <x-thead-item sortBy="do_actual_datetime">{{ __('validation.attributes.do_actual_datetime') }}</x-thead-item>
                    <x-thead-item>{{ __('validation.attributes.do_status') }}</x-thead-item>
        
                    <x-thead-item></x-thead-item>
                </x-table-row>
            </x-thead>
            <x-tbody>
                @forelse ($data as $dispatchOrder)
                    <x-table-row wire:key="{{ $loop->index }}" class="{{ $this->tableClass($dispatchOrder)['tableRow'] }} font-semibold">
                        <x-tbody-item class=" center aligned font-bold">{{ $dispatchOrder->do_number }}</x-tbody-item>

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
                        <x-tbody-item class="center aligned">
                            <x-span tooltip="{{ $dispatchOrder->salesType->st_name }}">
                                {{ $dispatchOrder->salesType->st_abbr }}
                            </x-span>
                        </x-tbody-item>
                        <x-tbody-item class="text-xs">{{ $dispatchOrder->do_planned_datetime }}</x-tbody-item>
                        <x-tbody-item class="text-xs">{{ $dispatchOrder->do_actual_datetime }}</x-tbody-item>
                        <x-tbody-item class="text-sm center aligned">
                            <span data-tooltip="{{ __("dispatchorders.{$dispatchOrder->do_status}") }}" data-variation="mini">
                                <i class="{{ $this->tableClass($dispatchOrder)['icon']}}"></i>
                            </span>
                        </x-tbody-item>
                        <x-tbody-item class="">
                            @if ($dispatchOrder->isEditable())
                                <x-crud-actions edit delete modelName="dispatchorder" :modelId="$dispatchOrder->id">
                                    <x-slot name="left">
                                        <span wire:click="openDetailsModal({{ $dispatchOrder->id }})" data-tooltip="{{ __('common.detail') }}" data-variation="mini">
                                            <i class="link eye icon"></i>
                                        </span>
                                    </x-slot>
                                </x-crud-actions>
                            @else
                                <x-crud-actions modelName="dispatchorder" :modelId="$dispatchOrder->id">
                                    <x-slot name="left">
                                        <div wire:click="openDetailsModal({{ $dispatchOrder->id }})" data-tooltip="{{ __('common.detail') }}" data-variation="mini">
                                            <i class="link eye icon"></i>
                                        </div>
                                    </x-slot>
                                    @if ($dispatchOrder->isCompleted() || $dispatchOrder->isInProgress())
                                        <a href="{{ route('dispatchorders.daily') }}" data-tooltip="{{ __('common.examine') }}" data-variation="mini">
                                            <i class="right arrow link icon"></i>
                                        </a>
                                    @endif
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
    </div>
    {{ $data->links('components.tailwind-pagination') }}







    @if ($detailsModal && $selectedDo)
        <div x-data="{detailsModal: @entangle('detailsModal')}">
            <x-custom-modal active="detailsModal" header="{{ __('dispatchorders.do_number_numbered_dispatchorder', ['do_number' => $selectedDo->do_number]) }}">

                <x-form-divider noButtons bottomClass="{{ $this->tableClass($selectedDo)['bottomClass'] }}">
                    <x-slot name="left">
                        
                        <div class="p-4 shadow-lg border rounded {{ $this->tableClass($selectedDo)['borderColor'] }}">
                            <x-list-item>
                                <span>{{ __('validation.attributes.do_number') }}</span>
                                <span>{{ $selectedDo->do_number }}</span>
                            </x-list-item>
                            <x-list-item>
                                <span>{{ __('common.customer') }}</span>
                                <span>{{ $selectedDo->company->cmp_commercial_title }}</span>
                            </x-list-item>
                            <x-list-item>
                                <span>{{ __('validation.attributes.sales_type_id') }}</span>
                                <span>{{ ucfirst($selectedDo->salesType->st_name) }}</span>
                            </x-list-item>
                            <x-list-item>
                                <span>{{ __('validation.attributes.do_planned_datetime') }}</span>
                                <span>{{ $selectedDo->do_planned_datetime }}</span>
                            </x-list-item>
                            @if ($selectedDo->dispatchExtra)
                                <x-list-item>
                                    <span>{{ __('validation.attributes.de_license_plate') }}</span>
                                    <span>{{ $selectedDo->dispatchExtra->de_license_plate }}</span>
                                </x-list-item>
                                <x-list-item>
                                    <span>{{ __('validation.attributes.de_driver_name') }}</span>
                                    <span>{{ $selectedDo->dispatchExtra->de_driver_name }}</span>
                                </x-list-item>
                                <x-list-item>
                                    <span>{{ __('validation.attributes.de_driver_phone') }}</span>
                                    <span>{{ $selectedDo->dispatchExtra->de_driver_phone }}</span>
                                </x-list-item>
                                <x-list-item>
                                    <span>{{ __('validation.attributes.de_dispatch_expense') }}</span>
                                    <span>{{ $selectedDo->dispatchExtra->de_dispatch_expense }}₺</span>
                                </x-list-item>
                                <x-list-item>
                                    <span>{{ __('validation.attributes.de_handling_expense') }}</span>
                                    <span>{{ $selectedDo->dispatchExtra->de_handling_expense }}₺</span>
                                </x-list-item>
                            @endif
                            @if ($selectedDo->isApproved())
                            <x-list-item>
                                <span>
                                    {{-- <i class="double check icon green" ></i> --}}
                                    {{ __('validation.attributes.do_actual_datetime') }}
                                </span>
                                <span>{{ $selectedDo->do_actual_datetime }}</span>
                            </x-list-item>
                            @endif
                        </div>
                        <div class="pt-5 {{ $this->tableClass($selectedDo)['statusColor'] }}">
                            <i class="{{ $this->tableClass($selectedDo)['icon'] }}"></i>
                            <span class="font-bold">
                                {{ __("dispatchorders.{$selectedDo->do_status}") }}
                            </span>
                        </div>
                    </x-slot>

                    <x-slot name="right">
                        <div class="flex flex-col gap-3">
                            @foreach ($selectedDo->dispatchProducts as $dp)
                                <div x-data="{reservedLots: false}"  class="border p-4 {{ $this->tableClass($selectedDo)['borderColor'] }} rounded hover:bg-cool-gray-50 border-dashed">
                                    <div class="flex justify-between text-ease cursor-pointer" @click="reservedLots = ! reservedLots" >
                                        <span class="font-bold">{{ $dp->product->prd_name }}</span>
                                        <div>
                                            <span>{{ $dp->dp_amount }} {{ $dp->unit->name }}</span>
                                            <span x-show="!reservedLots" class="pl-6"><i class="caret right icon"></i></span>
                                            <span x-show="reservedLots" class="pl-6"><i class="caret down icon"></i></span>
                                        </div>
                                    </div>
                                    <div x-show="reservedLots" class="pt-2">
                                        <x-reserved-stocks-table :reservations="$dp->reservedStocks" noHead noProduct emptyMessage="dispatchorders.not_ready_yet" />
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </x-slot>

                    <x-slot name="bottom">
                        <div class="text-white">
                            <div class="flex justify-between">
                                <div>
                                    {{ __('dispatchorders.dispatch_address') }}
                                    <div class="flex flex-col py-2 gap-2">
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
                                    <i class="">“{{ $selectedDo->do_note }}”</i>
                                </div>
                            @endif
                        </div>
                    </x-slot>

                </x-form-divider>

            </x-custom-modal>
        </div>
    @endif

    @include('web.helpers.deletable')

</div>

