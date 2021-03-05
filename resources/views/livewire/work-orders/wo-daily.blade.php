<div>
    <x-content theme="green">
        <x-slot name="header">
            <x-page-header icon="settings" header="workorders.daily_work_orders">
                <x-slot name="buttons">
                    <button wire:click="openWoFormModal" class="ui icon mini teal button"
                        data-tooltip="{{ __('common.add_new') }}" data-variation="mini">
                        <i class="white plus icon"></i>
                    </button>
                </x-slot>
            </x-page-header>
        </x-slot>
        <div class="p-4">
            
            
            {{-- StatusBar -----------------------------------------------------------}}
                <div class="flex justify-between">
                    <div class="font-bold text-sm">
                        @if ($this->inProgress)
                            <span data-tooltip="{{ __('workorders.production_continues') }}" data-variation="mini">
                                <i class="{{ $this->inProgress->statusColor }} link circle icon animate-pulse"></i>
                            </span>
                            <span>{{ $this->inProgress->product->prd_name }} - </span>
                            <span class="text-ease">{{ __('workorders.started_at_time', ['time' => $this->inProgress->startedAt()->diffForHumans()]) }}</span>
                        @else
                            <i class="red  circle icon"></i>
                            <span class="text-gray-400 cursor-default">{{ __('workorders.on_hold') }}</span>
                        @endif
                    </div>
                    <div>
                        {{-- <label class="font-bold">{{ __('common.date') }}:</label> --}}
                        <span class="font-bold text-gray-500">{{ $todayDate }}</span>
                    </div>
                </div>
            {{-- StatusBar -----------------------------------------------------------}}

            

            <table class="ui sortable compact unstackable table basic">

                <thead>
                    <tr>
                        <th>{{ __('validation.attributes.wo_status') }}</th>
                        <th>{{ __('validation.attributes.prd_name') }}</th>
                        <th>{{ __('validation.attributes.wo_amount') }}</th>
                        <th>{{ __('validation.attributes.wo_lot_no') }}</th>
                        <th>{{ __('validation.attributes.wo_queue') }}</th>
                        <th>{{ __('validation.attributes.wo_code') }}</th>
                        <th></th>
                    </tr>
                </thead>
                
                <tbody>
                    @forelse ($workOrders as $key => $workOrder)
                        @switch($workOrder)
                            @case($workOrder->isApproved())
                                @include('web.sections.workorders.daily.table-rows.wo-case-approved')
                                @break
                            @case($workOrder->isCompleted())
                                @include('web.sections.workorders.daily.table-rows.wo-case-completed')
                                @break
                            @case($workOrder->isInProgress())
                                @include('web.sections.workorders.daily.table-rows.wo-case-inprogress')
                                @break
                            @case($workOrder->isPrepared())
                                @include('web.sections.workorders.daily.table-rows.wo-case-prepared')
                                @break
                            @case($workOrder->isPreparing())
                                @include('web.sections.workorders.daily.table-rows.wo-case-preparing')
                                @break
                            @case($workOrder->isActive())
                                @include('web.sections.workorders.daily.table-rows.wo-case-active')
                                @break
                            @case($workOrder->isSuspended())
                                @include('web.sections.workorders.daily.table-rows.wo-case-suspended')
                                @break
                        @endswitch
                    @empty
                        <tr>
                            <td colspan="10">
                                <x-placeholder icon="blue settings" header="{{ __('workorders.daily_production') }}">
                                    {{ __('workorders.there_is_no_any_schuled_work_today') }}
                                </x-placeholder>
                            </td>
                        </tr>
                    @endforelse
                </tbody>

            </table>
        </div>
    </x-content>

    


    {{-- @include('web.sections.workorders.daily.modals.reserve-sources') --}}
    @include('web.sections.workorders.daily.modals.reserved-sources')
    @include('web.sections.workorders.daily.modals.finalize')


    @if ($detailsModal)
        <div wire:key="detailsModal" x-data="{detailsModal: @entangle('detailsModal')}">
            <x-custom-modal active="detailsModal" header="{{ __('workorders.details.header') }}">
                <x-workorder-details wire:key="workorderdetailsmodal" :workOrder="$modalSelectedWorkOrder" />
            </x-custom-modal>
        </div>
    @endif

    @if ($approvalModal)
        <div wire:key="approvalModal" x-data="{approvalModal: @entangle('approvalModal')}">
            <x-custom-modal active="approvalModal" header="{{ __('workorders.details.header') }}">
                <x-workorder-details wire:key="workorderapprovalmodal" :workOrder="$approvalWorkOrder" />
            </x-custom-modal>
        </div>
    @endif

    @include('web.helpers.deletable')

    @include('web.sections.workorders.daily.form-modal')

    


</div>