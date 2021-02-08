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
                        {{-- <x-thead-item class="collapsing">{{ __('validation.attributes.do_planned_datetime') }}</x-thead-item> --}}
                        <x-thead-item></x-thead-item>
                    </tr>
                </thead>

                <x-tbody>
                    @forelse($dispatchOrders as $dispatchOrder) 
                        @switch($dispatchOrder)
                            @case($dispatchOrder->isApproved())
                                @include('web.sections.dispatchorders.daily.table-rows.case-approved')
                                @break
                            @case($dispatchOrder->isCompleted())
                                @include('web.sections.dispatchorders.daily.table-rows.case-completed')
                                @break
                            @case($dispatchOrder->isInProgress())
                                @include('web.sections.dispatchorders.daily.table-rows.case-inprogress')
                                @break
                            @case($dispatchOrder->isActive())
                                @include('web.sections.dispatchorders.daily.table-rows.case-active')
                                @break
                            @case($dispatchOrder->isSuspended())
                                @include('web.sections.dispatchorders.daily.table-rows.case-suspended')
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
            <x-custom-modal active="approveModal" class="p-2 bg-gray-200">

                <div class="shadow-md bg-white rounded relative">

                    <div class="p-4 flex flex-col gap-5 shadow-md">
                        @foreach ($tobeApprovedDispatchOrder->dispatchProducts as $dp)
                            <div x-data="{reservedLots: false}" class="border p-4 border-red-400 rounded cursor-pointer hover:bg-cool-gray-50 border-dashed" @click="reservedLots = ! reservedLots">
                                <div class="flex justify-between text-ease cursor-pointer"  >
                                    <span>{{ $dp->product->name }}</span>
                                    <div>
                                        <span>{{ $dp->dp_amount }} {{ $dp->unit->name }}</span>
                                        <span x-show="!reservedLots" class="pl-6"><i class="caret right icon"></i></span>
                                        <span x-show="reservedLots" class="pl-6"><i class="caret down icon"></i></span>
                                    </div>
                                </div>
                                <div x-show="reservedLots" class="pt-2">
                                    <x-reserved-stocks-table :model="$dp" noHead noProduct />
                                </div>
                            </div>
                        @endforeach
                    </div>
                    {{-- <x-reserved-stocks-table :model="$tobeApprovedDispatchOrder" class="p-2" /> --}}
                        
                    <div class="p-3">
                        <div class="ui mini buttons w-full">
                            <button wire:click.prevent @click="approveModal = false" class="ui mini button">
                                {{ __('common.cancel') }}
                            </button>
                            <button wire:click.prevent="approve()" class="ui orange mini button">
                                {{ __('common.confirm') }}
                            </button>
                        </div>
        
                    </div>

                </div>
                
                <div class="p-2 mt-2 text-xs text-ease shadow rounded bg-white border" x-data="{denyingExplanation: false}">
                    <span x-show="!denyingExplanation">
                        <span @click="denyingExplanation = true" class="text-red-600 text-sm font-bold cursor-pointer">
                            {{ __('common.deny') }}
                        </span> -
                        <span class="text-xs text-ease">
                            {{ __('dispatchorders.make_a_review_request') }}
                        </span>
                    </span>
                    <span x-show="denyingExplanation">
                        <span wire:click="deny()" class="text-red-600 text-sm font-bold cursor-pointer">{{ __('common.are_you_sure') }}</span> - 
                        <span class="text-xs text-ease">
                            {{ __('dispatchorders.relevant_units_will_be_informed') }}
                        </span>
                    </span>
                </div>
                
            </x-custom-modal>
        </div>
    @endif

</div>