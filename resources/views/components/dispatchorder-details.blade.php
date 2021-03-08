<x-form-divider noButtons bottomClass="{{ $tableClass['bottomClass'] }}">
    <x-slot name="left">
        
        <div class="p-4 shadow-lg border rounded {{ $tableClass['borderColor'] }}">
            <x-list-item>
                <span>{{ __('validation.attributes.do_number') }}</span>
                <span>{{ $dispatchOrder->do_number }}</span>
            </x-list-item>
            <x-list-item>
                <span>{{ __('common.customer') }}</span>
                <span>{{ $dispatchOrder->company->cmp_commercial_title }}</span>
            </x-list-item>
            <x-list-item>
                <span>{{ __('validation.attributes.sales_type_id') }}</span>
                <span>{{ ucfirst($dispatchOrder->salesType->st_name) }}</span>
            </x-list-item>
            <x-list-item>
                <span>{{ __('validation.attributes.do_planned_datetime') }}</span>
                <span>{{ $dispatchOrder->do_planned_datetime }}</span>
            </x-list-item>
            @if ($dispatchOrder->dispatchExtra)
                <x-list-item>
                    <span>{{ __('validation.attributes.de_license_plate') }}</span>
                    <span>{{ $dispatchOrder->dispatchExtra->de_license_plate ?? __('common.not_defined') }}</span>
                </x-list-item>
                <x-list-item>
                    <span>{{ __('validation.attributes.de_driver_name') }}</span>
                    <span>{{ $dispatchOrder->dispatchExtra->de_driver_name ?? __('common.not_defined') }}</span>
                </x-list-item>
                <x-list-item>
                    <span>{{ __('validation.attributes.de_driver_phone') }}</span>
                    <span>{{ $dispatchOrder->dispatchExtra->de_driver_phone ?? __('common.not_defined') }}</span>
                </x-list-item>
                <x-list-item>
                    <span>{{ __('validation.attributes.de_dispatch_expense') }}</span>
                    <span>{{ $dispatchOrder->dispatchExtra->de_dispatch_expense ?? __('common.not_defined') }}₺</span>
                </x-list-item>
                <x-list-item>
                    <span>{{ __('validation.attributes.de_handling_expense') }}</span>
                    <span>{{ $dispatchOrder->dispatchExtra->de_handling_expense ?? __('common.not_defined') }}₺</span>
                </x-list-item>
            @endif
            @if ($dispatchOrder->isApproved())
            <x-list-item>
                <span>
                    {{-- <i class="double check icon green" ></i> --}}
                    {{ __('validation.attributes.do_actual_datetime') }}
                </span>
                <span>{{ $dispatchOrder->do_actual_datetime }}</span>
            </x-list-item>
            @endif
        </div>
        <div class="flex justify-between items-center">
            <div class="pt-5 {{ $tableClass['statusColor'] }}">
                <i class="{{ $tableClass['icon'] }}"></i>
                <span class="font-bold">
                    {{ __("dispatchorders.{$dispatchOrder->do_status}") }}
                </span>
            </div>
            <div>
                <x-span tooltip="Excel olarak indir">
                    <i wire:click="exportDispatchOrderDetailed" class="large excel file icon text-ease-green cursor-pointer"></i>
                </x-span>
            </div>
        </div>
    </x-slot>

    <x-slot name="right">
        <div class="flex flex-col gap-3">
            @foreach ($dispatchOrder->dispatchProducts as $dp)
                <div x-data="{reservedLots: false}"  class="border p-4 {{ $tableClass['borderColor'] }} rounded hover:bg-cool-gray-50 border-dashed cursor-pointer" @click="reservedLots = ! reservedLots">
                    <div class="flex justify-between text-ease"  >
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
                        <span id="copy-area">{{ $dispatchOrder->fullAddress() }}</span>
                        <div>{{ __('validation.attributes.adr_phone') }}: {{ $dispatchOrder->address->adr_phone }}</div>
                    </div>
                </div>
                <div>
                    <button onclick="copy('copy-area', '{{ __('addresses.address_copied') }}')" class="focus:outline-none hover:text-red-800" data-tooltip="{{ __('common.copy') }}" data-position="left center" data-variation="mini">
                        <i class="copy outline icon"></i>
                    </button>
                </div>
            </div>
            @if ($dispatchOrder->do_note)
                <div class="mt-4 p-2 border rounded shadow">
                    <i class="comment alternate outline flipped icon"></i>
                    <i class="">“{{ $dispatchOrder->do_note }}”</i>
                </div>
            @endif
        </div>
    </x-slot>

</x-form-divider>