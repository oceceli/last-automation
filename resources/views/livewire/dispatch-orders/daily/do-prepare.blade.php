<div>
    <x-content>
        {{-- <h5 class="">
            {{ __('dispatchorders.dispatch_address') }}
        </h5> --}}
        <div>
            <div class="m-4 p-5 border rounded-sm shadow-lg relative bg-teal-1000">
                <div class="flex justify-between border-b border-white text-ease pb-2">
                    <div>
                        <h5 class="">
                            {{ $dispatchOrder->company->cmp_commercial_title }}
                        </h5>
                    </div>
                    <div>
                        <span class="text-xs">{{ __('dispatchorders.dispatch') }}</span>:
                        <span class="">
                            {{ $dispatchOrder->do_number }}
                        </span>
                    </div>
                </div>

                <div>
                    <div class="flex flex-col py-2 gap-2 text-ease">
                        <span>{{ $dispatchAddress }}</span>
                        <div>{{ __('validation.attributes.adr_phone') }}: {{ $dispatchOrder->address->adr_phone }}</div>
                    </div>
                    @if ($dispatchOrder->do_note)
                        <div class="mt-4 p-2 border rounded shadow">
                            <i class="comment alternate outline flipped icon"></i>
                            <i class="text-green-700">“{{ $dispatchOrder->do_note }}”</i>
                        </div>
                    @endif
                </div>
            </div>
            

            <div class="p-5">
                @switch($dispatchOrder)
                    @case($dispatchOrder->isApproved())
                        @include('web.sections.dispatchorders.daily.prepare.table-by-states.prepare-approved')
                        @break
                    @case($dispatchOrder->isCompleted())
                        @include('web.sections.dispatchorders.daily.prepare.table-by-states.prepare-completed')
                        @break
                    @case($dispatchOrder->isInProgress())
                        @include('web.sections.dispatchorders.daily.prepare.table-by-states.prepare-inprogress')
                        @break
                    @case($dispatchOrder->isActive())
                        @include('web.sections.dispatchorders.daily.prepare.table-by-states.prepare-active')
                        @break
                    @case($dispatchOrder->isSuspended())
                        @include('web.sections.dispatchorders.daily.prepare.table-by-states.prepare-suspended')
                        @break
                    @default
                @endswitch
            </div>
        </div>


    </x-content>


    @if ($reservationViewModal)
        <div x-data="{reservationViewModal: @entangle('reservationViewModal')}">
            <x-custom-modal active="reservationViewModal" header="test">
                <x-reserved-stocks-table :reservations="$selectedDispatchProduct->reservedStocks" class="p-2" />
            </x-custom-modal>
        </div>
    @endif

    
    @include('web.sections.dispatchorders.daily.prepare.dispatch-lot-picker')


</div>