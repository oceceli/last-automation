<div>
    <div x-data="{wo_modal: false}">
        <x-page-header icon="settings" header="sections/workorders.daily_work_orders">
            <x-slot name="buttons">
                <button @click="wo_modal = true" class="ui icon mini teal button"
                    data-tooltip="{{ __('common.add_new') }}" data-variation="mini">
                    <i class="white plus icon"></i>
                </button>
            </x-slot>
        </x-page-header>
        <x-custom-modal active="wo_modal">
            <livewire:sections.work-orders.form>
        </x-custom-modal>
    </div>
    <x-content theme="green">
        <div class="p-4">
            <div class="flex justify-between">
                <div class="font-bold text-sm">
                    @if ($this->inProduction)
                        <span data-tooltip="{{ __('sections/workorders.production_continues') }}" data-variation="mini">
                            <i class="green link circle icon animate-pulse"></i>
                        </span>
                        <span>{{ $this->inProduction->product->name }} - </span>
                        <span class="text-gray-400">{{ __('sections/workorders.started_at_time', ['time' => $this->inProduction->startedAt()->diffForHumans()]) }}</span>
                    @else
                        <i class="yellow outline circle icon"></i>
                        <span class="text-gray-400 cursor-default">{{ __('sections/workorders.on_hold') }}</span>
                    @endif
                </div>
                <div>
                    {{-- <label class="font-bold">{{ __('common.date') }}:</label> --}}
                    <span class="font-bold text-gray-500">{{ $todayDate }}</span>
                </div>
            </div>
            <table class="ui sortable compact unstackable table basic">
                <thead>
                    <tr>
                        <th>{{ __('sections/workorders.wo_status') }}</th>
                        <th>{{ __('sections/products.name') }}</th>
                        <th>{{ __('sections/workorders.amount') }}</th>
                        <th>{{ __('sections/workorders.lot_no') }}</th>
                        <th>{{ __('sections/workorders.queue') }}</th>
                        <th>{{ __('sections/workorders.code') }}</th>
                        {{-- <th>{{ __('sections/workorders.datetime') }}</th> --}}
                        {{-- <th>{{ __('sections/workorders.in_progress') }}</th>     --}}
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
                                <td>{{ $workOrder->amount }} {{ $workOrder->unit->name }}</td>
                                <td class="">{{ $workOrder->lot_no }}</td>
                                <td class="center aligned collapsing font-bold">{{ $workOrder->queue }}</td>
                                <td class="center aligned collapsing">{{ $workOrder->code }}</td>
                                <td class="collapsing selectable">
                                    <span class="px-2 shadow rounded bg-white" data-tooltip="{{ __('common.see_details') }}" data-variation="mini" data-position="top right">
                                        <a class="text-teal-600 text-lg" href="{{ route('work-orders.show', ['work_order' => $workOrder]) }}">{{ round($workOrder->convertedAmount(),2) }} {{ $workOrder->convertedUnit()->name }}</a>
                                    </span>
                                </td>
                            </tr>
                        @else
                            <tr class="@if($workOrder->isInProgress()) warning font-bold @elseif($workOrder->isActive()) @else  text-gray-400 @endif">
                                <td class="center aligned collapsing">
                                    @if($workOrder->isInProgress())
                                            @if ( ! $workOrder->isToday())
                                                <span data-tooltip="{{ __('sections/workorders.this_work_order_is_not_finished_in_time_should_end_now')}}" data-variation="mini" data-position="top left">
                                                    <i class="large red attention icon"></i>
                                                </span>
                                            @else
                                                <span data-tooltip="{{ __('sections/workorders.production_continues') }}" data-variation="mini">
                                                    <i class="large loading red cog icon"></i>
                                                </span>
                                            @endif
                                    @elseif($workOrder->isActive())
                                        <span data-tooltip="{{ __('sections/workorders.waiting_for_production') }}" data-variation="mini">
                                            <i class="large primary clock outline icon"></i>
                                        </span>
                                    @else
                                        <span data-tooltip="{{ __('common.suspended') }}" data-variation="mini">
                                            <i class="large grey ban icon"></i>
                                        </span>
                                    @endif
                                </td>
                                <td>{{ $workOrder->product->name }}</td>
                                <td>
                                    <span>{{ $workOrder->amount }} {{ $workOrder->unit->name }}</span>
                                    <span class="text-sm text-gray-500">({{ round($workOrder->convertedAmount(),3) }} {{ $workOrder->convertedUnit()->name }})</span>
                                </td>
                                <td class="">{{ $workOrder->lot_no }}</td>
                                <td class="center aligned collapsing">{{ $workOrder->queue }}</td>
                                <td class="center aligned collapsing">{{ $workOrder->code }}</td>
                                <td class="collapsing">
                                    @if($workOrder->isInProgress())
                                        <div x-data="{wo_complete_modal: false}">
                                            <x-crud-actions onlyShow modelName="work-order" :modelId="$workOrder->id">
                                                <div @click="wo_complete_modal = true" data-tooltip="{{ __('sections/workorders.wo_complete') }}" data-variation="mini">
                                                    <i wire:click.prevent="" class="{{ __('sections/workorders.wo_complete_icon') }} link icon"></i>
                                                </div>
                                            </x-crud-actions>
                                            <x-custom-modal active="wo_complete_modal">
                                                <x-slot name="header">
                                                    <x-page-header>
                                                        <x-slot name="customHeader">
                                                            <span class="font-semibold text-teal-800">{{ $workOrder->product->name }}</span>
                                                        </x-slot>
                                                    </x-page-header>
                                                </x-slot>
                                                <form class="ui mini form" wire:submit.prevent="submitProductionCompleted({{ $workOrder->id }})">
                                                    <x-dropdown label="Toplam" iModel="totalProduced" iPlaceholder="{{ __('stockmoves.total_produced_amount') }}" :key="$key" sClass="black"
                                                        model="unit_id" value="id" text="name" :collection="$workOrder->product->units" placeholder="{{__('modelnames.unit')}}"
                                                    />
                                                    <x-input label="{{ __('stockmoves.waste') }}" model="waste" placeholder="{{ __('stockmoves.waste_amount')}}">
                                                        <x-slot name="innerLabel">
                                                            @if(!empty($selectedUnit)) {{ $selectedUnit->abbreviation }} @else ... @endif
                                                        </x-slot>
                                                    </x-input>
                                                    <button class="text-green-500">gönder</button>
                                                    {{-- <x-form-buttons submit="submitProductionCompleted({{ $workOrder->id }})"  /> --}}
                                                </form>
                                            </x-custom-modal>
                                        </div>
                                    @elseif($workOrder->isActive())
                                        <x-crud-actions onlyShow modelName="work-order" :modelId="$workOrder->id" addClass="py-1">
                                            <div data-tooltip="{{ __('sections/workorders.wo_start') }}" data-variation="mini">
                                                <i wire:click.prevent="startJob({{ $workOrder->id }})" class="red play link icon"></i>
                                            </div>
                                        </x-crud-actions>
                                    @else
                                        <x-crud-actions onlyShow modelName="work-order" gray :modelId="$workOrder->id" />
                                    @endif
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
</div>
