<div>
    <x-content theme="green">
        <x-slot name="header">
            @include('web.sections.workorders.daily.header')
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

                            @if ($workOrder->isFinalized())
                                <tr class="left green marked text-green-600 bg-teal-50 ">
                                    <td class="center aligned collapsing" data-tooltip="{{ __('workorders.production_is_completed') }} - {{ $workOrder->finalizedAt() }}" 
                                            data-variation="mini" data-position="top left">
                                        <i class="large green checkmark icon"></i>
                                    </td>
                                    <td>{{ $workOrder->product->prd_name }}</td>
                                    <td>
                                        <span>{{ $workOrder->wo_amount }} {{ $workOrder->unit->name }}</span>
                                        @if ( ! $workOrder->unitIsAlreadyBase())
                                            <span class="text-xs text-ease">({{ round($workOrder->convertedBaseAmount(),3) }} {{ $workOrder->convertedBaseUnit()->name }})</span>
                                        @endif
                                    </td>
                                    <td class="">{{ $workOrder->wo_lot_no }}</td>
                                    <td class="center aligned collapsing">{{ $workOrder->wo_queue }}</td>
                                    <td class="center aligned collapsing">{{ $workOrder->wo_code }}</td>
                                    <td class="collapsing selectable">
                                        <span class="px-2 shadow rounded bg-white" data-tooltip="{{ __('common.see_details') }}" data-variation="mini" data-position="top right">
                                            <a class="text-teal-600 text-lg" href="{{ route('work-orders.show', ['work_order' => $workOrder]) }}">
                                                {{ round($workOrder->getProductionResults()['net'],2) }} {{ $workOrder->product->baseUnit->name }}
                                            </a>
                                        </span>
                                    </td>
                                </tr>

                            @elseif($workOrder->isInProgress())
                                <tr class="{{ $workOrder->statusColor }} font-bold cursor-default">
                                    <td class="center aligned collapsing">
                                        @if ( ! $workOrder->isToday())
                                            <span data-tooltip="{{ __('workorders.this_work_order_is_not_finished_in_time_should_end_now')}}" data-variation="mini" data-position="top left">
                                                <i class="large red attention icon"></i>
                                            </span>
                                        @else
                                            <span data-tooltip="{{ __('workorders.production_continues') }}" data-variation="mini">
                                                <i class="large {{ __('workorders.wo_in_progress_icon')}} icon"></i>
                                            </span>
                                        @endif
                                    </td>
                                    <td>{{ $workOrder->product->prd_name }}</td>
                                    <td>
                                        <span>{{ $workOrder->wo_amount }} {{ $workOrder->unit->name }}</span>
                                        @if ( ! $workOrder->unitIsAlreadyBase())
                                            <span class="text-xs text-ease">({{ round($workOrder->convertedBaseAmount(),3) }} {{ $workOrder->convertedBaseUnit()->name }})</span>
                                        @endif
                                    </td>
                                    <td class="">{{ $workOrder->wo_lot_no }}</td>
                                    <td class="center aligned collapsing">{{ $workOrder->wo_queue }}</td>
                                    <td class="center aligned collapsing">{{ $workOrder->wo_code }}</td>
                                    <td class="collapsing">
                                        <x-crud-actions show edit gray modelName="work-order" :modelId="$workOrder->id">
                                            <div wire:key="showReserved{{ $workOrder->id }}" wire:click.prevent="showReservedSources({{ $workOrder->id }})" data-tooltip="{{ __('workorders.reserved_sources') }}" data-variation="mini" data-position="top right">
                                                <i class="search link icon"></i>
                                            </div>
                                            <div wire:key="complete{{ $workOrder->id }}" wire:click.prevent="FinalizeProcess({{ $workOrder->id }})" data-tooltip="{{ __('workorders.wo_complete') }}" data-variation="mini">
                                                <i class="{{ __('workorders.wo_complete_icon') }} red link icon"></i>
                                            </div>
                                        </x-crud-actions>
                                    </td>
                                </tr>

                            @elseif($workOrder->isActive())
                                <tr class="font-semibold cursor-default hover:bg-cool-gray-50 ease-in duration-200">
                                    <td class="center aligned collapsing">
                                        <span data-tooltip="{{ __('workorders.waiting_for_production') }}" data-variation="mini">
                                            <i class="large primary clock outline icon"></i>
                                        </span>
                                    </td>
                                    <td>{{ $workOrder->product->prd_name }}</td>
                                    <td>
                                        <span>{{ $workOrder->wo_amount }} {{ $workOrder->unit->name }}</span>
                                        @if ( ! $workOrder->unitIsAlreadyBase())
                                            <span class="text-xs text-ease">({{ round($workOrder->convertedBaseAmount(),3) }} {{ $workOrder->convertedBaseUnit()->name }})</span>
                                        @endif
                                    </td>
                                    <td class="">{{ $workOrder->wo_lot_no }}</td>
                                    <td class="center aligned collapsing">{{ $workOrder->wo_queue }}</td>
                                    <td class="center aligned collapsing">{{ $workOrder->wo_code }}</td>
                                    <td class="collapsing">
                                        <x-crud-actions show edit delete modelName="work-order" :modelId="$workOrder->id" addClass="py-1">
                                            <div data-tooltip="{{ __('workorders.wo_start') }}" data-variation="mini">
                                                <i wire:click.prevent="startProcess({{ $workOrder->id }})" class="red play link icon"></i>
                                            </div>
                                        </x-crud-actions>
                                    </td>
                                </tr>
                            
                            @else
                                <tr class="text-gray-400">
                                    <td class="center aligned collapsing">
                                        <span data-tooltip="{{ __('common.suspended') }}" data-variation="mini">
                                            <i class="large grey ban icon"></i>
                                        </span>
                                    </td>
                                    <td>{{ $workOrder->product->prd_name }}</td>
                                    <td>
                                        <span>{{ $workOrder->wo_amount }} {{ $workOrder->unit->name }}</span>
                                        @if ( ! $workOrder->unitIsAlreadyBase())
                                            <span class="text-xs text-ease">({{ round($workOrder->convertedBaseAmount(),3) }} {{ $workOrder->convertedBaseUnit()->name }})</span>
                                        @endif
                                    </td>
                                    <td class="">{{ $workOrder->wo_lot_no }}</td>
                                    <td class="center aligned collapsing">{{ $workOrder->wo_queue }}</td>
                                    <td class="center aligned collapsing">{{ $workOrder->wo_code }}</td>
                                    <td class="collapsing">
                                        <x-crud-actions show edit delete modelName="work-order" gray :modelId="$workOrder->id" />
                                    </td>
                                </tr>
                            @endif

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

    


    @include('web.sections.workorders.daily.modals.reserve-sources')
    @include('web.sections.workorders.daily.modals.reserved-sources')
    @include('web.sections.workorders.daily.modals.finalize')




    


</div>