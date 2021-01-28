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
                        <x-thead-item class="collapsing">{{ __('validation.attributes.do_status') }}</x-thead-item>
                        <x-thead-item class="center aligned">{{ __('validation.attributes.do_number') }}</x-thead-item>
                        <x-thead-item>{{ __('validation.attributes.company_id') }}</x-thead-item>
                        <x-thead-item>{{ __('dispatchorders.dispatch_address') }}</x-thead-item>
                        {{-- <x-thead-item class="collapsing">{{ __('validation.attributes.do_datetime') }}</x-thead-item> --}}
                        <x-thead-item></x-thead-item>
                    </tr>
                </thead>

                <x-tbody>
                    @forelse($dispatchOrders as $dispatchOrder) 
                        <x-table-row>
                            <x-tbody-item>
                                
                            </x-tbody-item>
                            <x-tbody-item class="center aligned font-bold">{{ $dispatchOrder->do_number }}</x-tbody-item>
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
                            
                            <x-tbody-item class="right aligned">
                                <a href="{{ route('dispatchorders.process', ['dispatchOrder' => $dispatchOrder]) }}" class="ui red label button">
                                    {{ __('dispatchorders.process_dispatch') }}
                                    <i class="right arrow icon"></i>
                                </a>
                                {{-- <span data-tooltip="{{ __('dispatchorders.process_dispatch') }}" data-variation="mini" data-position="top right" >
                                </span> --}}
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