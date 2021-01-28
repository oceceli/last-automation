<div>
    <x-content theme="green">
        <x-slot name="header">
            <x-page-header icon="shipping fast" header="{{ __('dispatchorders.do_daily') }}"></x-page-header>
        </x-slot>
        <div class="p-4">
            
            
            {{-- StatusBar -----------------------------------------------------------}}
                <div class="flex justify-between">
                    <div class="font-bold text-sm">
                        status
                        {{-- @if ($this->inProgress)
                            <span data-tooltip="{{ __('sections/workorders.production_continues') }}" data-variation="mini">
                                <i class="{{ $this->inProgress->statusColor }} link circle icon animate-pulse"></i>
                            </span>
                            <span>{{ $this->inProgress->product->name }} - </span>
                            <span class="text-ease">{{ __('sections/workorders.started_at_time', ['time' => $this->inProgress->startedAt()->diffForHumans()]) }}</span>
                        @else
                            <i class="red  circle icon"></i>
                            <span class="text-gray-400 cursor-default">{{ __('sections/workorders.on_hold') }}</span>
                        @endif --}}
                    </div>
                    <div>
                        <span class="text-xs text-ease">{{ date('d.m.Y') }}</span>
                    </div>
                </div>
            {{-- StatusBar -----------------------------------------------------------}}

            

            <table class="ui unstackable table basic">

                <thead>
                    <tr>
                        <x-thead-item class="collapsing center aligned">{{ __('validation.attributes.do_status') }}</x-thead-item>
                        <x-thead-item>{{ __('dispatchorders.dispatch_address') }}</x-thead-item>
                        <x-thead-item class="collapsing">{{ __('validation.attributes.company_id') }}</x-thead-item>
                        <x-thead-item class="center aligned">{{ __('validation.attributes.do_number') }}</x-thead-item>
                        {{-- <x-thead-item class="collapsing">{{ __('validation.attributes.do_datetime') }}</x-thead-item> --}}
                        <x-thead-item></x-thead-item>
                    </tr>
                </thead>

                <x-tbody>
                    @forelse($dispatchOrders as $dispatchOrder) 
                        <x-table-row>
                            <x-tbody-item class="center aligned">
                                @if ($dispatchOrder->isApproved())
                                    <x-span tooltip="{{ __('common.approved') }}" position="top left">
                                        <i class="large green check double icon"></i>
                                    </x-span>
                                @elseif ($dispatchOrder->isCompleted())
                                    <x-span tooltip="{{ __('dispatchorders.all_products_loaded_into_vehicle_waiting_for_approval') }}" position="top left">
                                        <i class=" green checkmark icon"></i>
                                    </x-span>
                                @elseif ($dispatchOrder->isInProgress())
                                    <x-span tooltip="{{ __('dispatchorders.products_loading_into_the_vehicle') }}" position="top left">
                                        <i class="large yellow loading cog icon"></i>
                                    </x-span>
                                @elseif ($dispatchOrder->isActive())
                                    <x-span tooltip="{{ __('dispatchorders.waiting_for_dispatch') }}" position="top left">
                                        <i class="large primary clock outline icon"></i>
                                    </x-span>
                                @else ($dispatchOrder->isSuspended())
                                    <x-span tooltip="{{ __('common.suspended') }}" position="top left">
                                        <i class="large grey ban icon"></i>
                                    </x-span>
                                @endif
                            </x-tbody-item>
                            <x-tbody-item>
                                {{ $dispatchOrder->address->adr_name }}
                                <span class="text-xs text-ease">
                                    ({{ __('common.phone') }}: {{ $dispatchOrder->address->adr_phone }})
                                </span>
                            </x-body-item>
                            <x-tbody-item class="collapsing">
                                {{ $dispatchOrder->company->cmp_commercial_title }}
                                <span class="text-xs text-ease">
                                    ({{ __('validation.attributes.cmp_current_code')}}: {{ $dispatchOrder->company->cmp_current_code }})
                                </span>
                            </x-tbody-item>
                            <x-tbody-item class="font-bold center aligned">{{ $dispatchOrder->do_number }}</x-tbody-item>
                            
                            <x-tbody-item class="right aligned">
                                <a href="{{ route('dispatchorders.process', ['dispatchOrder' => $dispatchOrder]) }}" class="ui red label button">
                                    {{ __('dispatchorders.get_ready') }}
                                    <i class="right arrow icon"></i>
                                </a>
                            </x-tbody-item>
                            
                        </x-table-row>
                    @empty
                    <tr>
                        <td colspan="10">
                            <x-placeholder icon="shipping fast">
                                {{ __('dispatchorders.there_are_no_dispatchorders_today') }}
                            </x-placeholder>
                        </td>
                    </tr>
                    @endforelse
                </x-tbody>
                
               

            </table>
        </div>
    </x-content>

    


    


</div>