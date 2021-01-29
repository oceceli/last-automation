<div>
    <x-content theme="green">
        <x-slot name="header">
            <x-page-header icon="shipping fast" header="{{ __('dispatchorders.do_daily') }}"></x-page-header>
        </x-slot>
        <div class="p-4">
            
            <div class="flex justify-between">
                <div class="font-bold text-sm">
                    status
                </div>
                <div>
                    <span class="text-xs text-ease">{{ date('d.m.Y') }}</span>
                </div>
            </div>

            <table class="ui unstackable table basic">
                <thead>
                    <tr>
                        <x-thead-item class="collapsing center aligned">{{ __('validation.attributes.do_status') }}</x-thead-item>
                        <x-thead-item>{{ __('dispatchorders.dispatch_address') }}</x-thead-item>
                        <x-thead-item class="collapsing">{{ __('validation.attributes.company_id') }}</x-thead-item>
                        <x-thead-item class="right aligned">{{ __('validation.attributes.do_number') }}</x-thead-item>
                        {{-- <x-thead-item class="collapsing">{{ __('validation.attributes.do_datetime') }}</x-thead-item> --}}
                        <x-thead-item></x-thead-item>
                    </tr>
                </thead>

                <x-tbody>
                    @forelse($dispatchOrders as $dispatchOrder) 
                        @switch($dispatchOrder)
                            @case($dispatchOrder->isApproved())
                                @include('web.sections.dispatchorders.todaytablerows.case-approved')
                                @break
                            @case($dispatchOrder->isCompleted())
                                @include('web.sections.dispatchorders.todaytablerows.case-completed')
                                @break
                            @case($dispatchOrder->isInProgress())
                                @include('web.sections.dispatchorders.todaytablerows.case-inprogress')
                                @break
                            @case($dispatchOrder->isActive())
                                @include('web.sections.dispatchorders.todaytablerows.case-active')
                                @break
                            @case($dispatchOrder->isSuspended())
                                @include('web.sections.dispatchorders.todaytablerows.case-suspended')
                                @break
                            @default
                        @endswitch
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

    @if ($approveModal && $tobeApprovedDispatchOrder)
        <div x-data="{approveModal: @entangle('approveModal')}" x-cloak>
            <x-custom-modal active="approveModal" class="p-2 bg-gray-100">


                <div class="shadow-md bg-white rounded relative">
                    <div class="p-2 shadow">
                        <x-table class="small">
                            <x-thead>
                                <x-table-row>
                                    <x-thead-item>{{ __('sections/products.name') }}</x-thead-item>
                                    <x-thead-item>{{ __('dispatchorders.lot_number') }}</x-thead-item>
                                    <x-thead-item class="right aligned">{{ __('dispatchorders.prepared_amount') }}</x-thead-item>
                                </x-table-row>
                            </x-thead>
                            <x-tbody>
                                @foreach($tobeApprovedDispatchOrder->reservedStocks as $reservation)
                                    <x-table-row class="text-ease hover:bg-cool-gray-100">
                                        <x-tbody-item>
                                            {{ $reservation->product->name }} 
                                            <span class="text-xs">({{ $reservation->product->code }})</span>
                                        </x-tbody-item>
                                        <x-tbody-item>{{ $reservation->reserved_lot }}</x-tbody-item>
                                        <x-tbody-item class="font-bold right aligned">{{ number_format($reservation->reserved_amount, 3, ',', '') }} {{ $reservation->product->baseUnit->name }}</x-tbody-item>
                                    </x-table-row>
                                @endforeach
                            </x-tbody>
                        </x-table>
                    </div>
    
                        
                    <div class="p-3">
                        <div class="ui mini buttons w-full">
                            <button wire:click.prevent @click="approveModal = false" class="ui mini button">
                                {{ __('common.cancel') }}
                            </button>
                            <button class="ui orange mini button">
                                {{ __('common.confirm') }}
                            </button>
                        </div>
        
                    </div>

                </div>
                
                <div class="pt-2" x-data="{denyingExplanation: false}">
                    <span x-show="!denyingExplanation">
                        <span @click="denyingExplanation = true" class="text-ease-red text-sm font-bold cursor-pointer">
                            {{ __('common.deny') }}
                        </span> -
                        <span class="text-xs text-ease">
                            {{ __('dispatchorders.make_a_review_request') }}
                        </span>
                    </span>
                    <span x-show="denyingExplanation" wire:click="deny()">
                        <span class="text-ease-red text-sm font-bold cursor-pointer">{{ __('common.are_you_sure') }}</span> - 
                        <span class="text-xs text-ease">
                            İlgili birimler bilgilendirilecek
                        </span>
                    </span>
                </div>
                
            </x-custom-modal>
        </div>
    @endif

</div>