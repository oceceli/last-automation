<div>
    @include('web.sections.workorders.daily.header')
    <x-content theme="green">
        <div class="p-4">
            
            
            {{-- StatusBar -----------------------------------------------------------}}
                <div class="flex justify-between">
                    <div class="font-bold text-sm">
                        @if ($this->inProgress)
                            <span data-tooltip="{{ __('sections/workorders.production_continues') }}" data-variation="mini">
                                <i class="{{ $this->inProgress->statusColor }} link circle icon animate-pulse"></i>
                            </span>
                            <span>{{ $this->inProgress->product->name }} - </span>
                            <span class="text-ease">{{ __('sections/workorders.started_at_time', ['time' => $this->inProgress->startedAt()->diffForHumans()]) }}</span>
                        @else
                            <i class="red  circle icon"></i>
                            <span class="text-gray-400 cursor-default">{{ __('sections/workorders.on_hold') }}</span>
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
                        <th>{{ __('sections/workorders.wo_status') }}</th>
                        <th>{{ __('sections/products.name') }}</th>
                        <th>{{ __('sections/workorders.amount') }}</th>
                        <th>{{ __('sections/workorders.lot_no') }}</th>
                        <th>{{ __('sections/workorders.queue') }}</th>
                        <th>{{ __('sections/workorders.code') }}</th>
                        <th></th>
                    </tr>
                </thead>
                
                <tbody>
                    @forelse ($workOrders as $key => $workOrder)

                            @if ($workOrder->isCompleted())
                                <tr class="left green marked text-green-600 bg-teal-50 ">
                                    <td class="center aligned collapsing" data-tooltip="{{ __('sections/workorders.production_is_completed') }} - {{ $workOrder->completedAt() }}" 
                                            data-variation="mini" data-position="top left">
                                        <i class="large green checkmark icon"></i>
                                    </td>
                                    <td>{{ $workOrder->product->name }}</td>
                                    <td>
                                        <span>{{ $workOrder->amount }} {{ $workOrder->unit->name }}</span>
                                        @if ( ! $workOrder->unitIsAlreadyBase())
                                            <span class="text-xs text-ease">({{ round($workOrder->convertedBaseAmount(),3) }} {{ $workOrder->convertedBaseUnit()->name }})</span>
                                        @endif
                                    </td>
                                    <td class="">{{ $workOrder->lot_no }}</td>
                                    <td class="center aligned collapsing">{{ $workOrder->queue }}</td>
                                    <td class="center aligned collapsing">{{ $workOrder->code }}</td>
                                    <td class="collapsing selectable">
                                        <span class="px-2 shadow rounded bg-white" data-tooltip="{{ __('common.see_details') }}" data-variation="mini" data-position="top right">
                                            <a class="text-teal-600 text-lg" href="{{ route('work-orders.show', ['work_order' => $workOrder]) }}">
                                                {{ round($workOrder->getProductionResults()['net'],2) }} {{ $workOrder->product->baseUnit->name }}
                                            </a>
                                        </span>
                                    </td>
                                </tr>

                            @elseif($workOrder->isInProgress())
                                <tr class="{{ $workOrder->statusColor }} font-bold">
                                    <td class="center aligned collapsing">
                                        @if ( ! $workOrder->isToday())
                                            <span data-tooltip="{{ __('sections/workorders.this_work_order_is_not_finished_in_time_should_end_now')}}" data-variation="mini" data-position="top left">
                                                <i class="large red attention icon"></i>
                                            </span>
                                        @else
                                            <span data-tooltip="{{ __('sections/workorders.production_continues') }}" data-variation="mini">
                                                <i class="large {{ __('sections/workorders.wo_in_progress_icon')}} icon"></i>
                                            </span>
                                        @endif
                                    </td>
                                    <td>{{ $workOrder->product->name }}</td>
                                    <td>
                                        <span>{{ $workOrder->amount }} {{ $workOrder->unit->name }}</span>
                                        @if ( ! $workOrder->unitIsAlreadyBase())
                                            <span class="text-xs text-ease">({{ round($workOrder->convertedBaseAmount(),3) }} {{ $workOrder->convertedBaseUnit()->name }})</span>
                                        @endif
                                    </td>
                                    <td class="">{{ $workOrder->lot_no }}</td>
                                    <td class="center aligned collapsing">{{ $workOrder->queue }}</td>
                                    <td class="center aligned collapsing">{{ $workOrder->code }}</td>
                                    <td class="collapsing">
                                        <x-crud-actions show edit delete modelName="work-order" :modelId="$workOrder->id">
                                            <div wire:key="{{ $workOrder->id }}" wire:click.prevent="woCompleteRequest({{ $workOrder->id }})" data-tooltip="{{ __('sections/workorders.wo_complete') }}" data-variation="mini">
                                                <i class="{{ __('sections/workorders.wo_complete_icon') }} link icon"></i>
                                            </div>
                                        </x-crud-actions>
                                    </td>
                                </tr>

                            @elseif($workOrder->isActive())
                                <tr class="font-semibold">
                                    <td class="center aligned collapsing">
                                        <span data-tooltip="{{ __('sections/workorders.waiting_for_production') }}" data-variation="mini">
                                            <i class="large primary clock outline icon"></i>
                                        </span>
                                    </td>
                                    <td>{{ $workOrder->product->name }}</td>
                                    <td>
                                        <span>{{ $workOrder->amount }} {{ $workOrder->unit->name }}</span>
                                        @if ( ! $workOrder->unitIsAlreadyBase())
                                            <span class="text-xs text-ease">({{ round($workOrder->convertedBaseAmount(),3) }} {{ $workOrder->convertedBaseUnit()->name }})</span>
                                        @endif
                                    </td>
                                    <td class="">{{ $workOrder->lot_no }}</td>
                                    <td class="center aligned collapsing">{{ $workOrder->queue }}</td>
                                    <td class="center aligned collapsing">{{ $workOrder->code }}</td>
                                    <td class="collapsing">
                                        <x-crud-actions show modelName="work-order" :modelId="$workOrder->id" addClass="py-1">
                                            <div data-tooltip="{{ __('sections/workorders.wo_start') }}" data-variation="mini">
                                                <i wire:click.prevent="startJob({{ $workOrder->id }})" class="red play link icon"></i>
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
                                    <td>{{ $workOrder->product->name }}</td>
                                    <td>
                                        <span>{{ $workOrder->amount }} {{ $workOrder->unit->name }}</span>
                                        @if ( ! $workOrder->unitIsAlreadyBase())
                                            <span class="text-xs text-ease">({{ round($workOrder->convertedAmount(),3) }} {{ $workOrder->convertedUnit()->name }})</span>
                                        @endif
                                    </td>
                                    <td class="">{{ $workOrder->lot_no }}</td>
                                    <td class="center aligned collapsing">{{ $workOrder->queue }}</td>
                                    <td class="center aligned collapsing">{{ $workOrder->code }}</td>
                                    <td class="collapsing">
                                        <x-crud-actions show modelName="work-order" gray :modelId="$workOrder->id" />
                                    </td>
                                </tr>
                            @endif

                    @empty
                        <tr>
                            <td colspan="10">
                                <x-placeholder icon="blue settings" header="{{ __('sections/workorders.daily_production') }}">
                                    {{ __('sections/workorders.there_is_no_any_schuled_work_today') }}
                                </x-placeholder>
                            </td>
                        </tr>
                    @endforelse
                </tbody>

            </table>
        </div>
    </x-content>

    @if ($woCompleteModal)
        <div x-data="{woCompleteModal: @entangle('woCompleteModal')}">
            <x-custom-modal active="woCompleteModal">
                <form class="ui mini form p-5" wire:submit.prevent="submitWoCompleted()">
                    <x-dropdown label="Toplam" iModel="production_gross" iPlaceholder="{{ __('stockmoves.total_produced_amount') }}" sClass="black"
                        model="unit_id" value="id" text="name" :collection="$woCompleteData->product->units" placeholder="{{__('modelnames.unit')}}"
                    />
                    <x-input label="{{ __('stockmoves.waste') }}" model="production_waste" placeholder="{{ __('stockmoves.waste_amount')}}">
                        <x-slot name="innerLabel">
                            @if(!empty($selectedUnit)) {{ $selectedUnit->abbreviation }} @else ... @endif
                        </x-slot>
                    </x-input>
                    <button class="text-green-500">gönder</button>
                </form>
            </x-custom-modal>
        </div>
    @endif

</div>


<style>
    [x-cloak] { display: none; }
</style>