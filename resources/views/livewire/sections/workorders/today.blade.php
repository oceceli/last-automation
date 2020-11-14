<div>
    <x-page-header icon="settings" header="sections/workorders.daily_work_orders" />
    <x-content theme="green">
        <div class="p-4">
            <div class="flex">
                <div>
                    {{-- <label class="font-bold">{{ __('common.date') }}:</label> --}}
                    <span class="font-bold text-gray-500">{{ $todayDate }}</span>
                </div>
            </div>
            <table class="ui celled sortable very compact unstackable table">
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
                    @foreach ($workOrders as $key => $workOrder)
                        @if ($workOrder->isCompleted())
                            <tr class="left green marked text-green-400">
                                <td class="center aligned collapsing" data-tooltip="{{ __('sections/workorders.production_is_completed') }}" data-variation="mini">
                                    <i class="large green checkmark icon"></i>
                                </td>
                                <td>{{ $workOrder->product->name }}</td>
                                <td>{{ $workOrder->amount }} {{ $workOrder->unit->name }}</td>
                                <td class="">{{ $workOrder->lot_no }}</td>
                                <td class="center aligned collapsing font-bold">{{ $workOrder->queue }}</td>
                                <td class="center aligned collapsing">{{ $workOrder->code }}</td>
                                <td class="collapsing selectable">
                                    <span class="text-green-800">{sayı} {baseUnit}</span>
                                    <span data-tooltip="{{ __('common.see_details') }}" data-variation="mini">
                                        <i class="link teal eye icon"></i>
                                    </span>
                                </td>
                            </tr>
                        @else
                            <tr class="@if(!$workOrder->inProgress()) left olive marked @elseif($workOrder->is_active) left primary marked @else left grey marked text-gray-400 @endif">
                                <td class="center aligned collapsing">
                                    @if(!$workOrder->inProgress())
                                        <span data-tooltip="{{ __('sections/workorders.production_continues') }}" data-variation="mini">
                                            <i class="large loading olive cog icon"></i>
                                        </span>
                                    @elseif($workOrder->is_active)
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
                                    <span class="text-sm text-gray-500">({{ $workOrder->convertedAmount() }} {{ $workOrder->convertedUnit()->name }})</span>
                                </td>
                                <td class="">{{ $workOrder->lot_no }}</td>
                                <td class="center aligned collapsing">{{ $workOrder->queue }}</td>
                                <td class="center aligned collapsing">{{ $workOrder->code }}</td>
                                <td class="collapsing">
                                    @if(!$workOrder->inProgress())
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
                                                <div class="ui mini form">
                                                    <x-dropdown label="Toplam" iModel="totalProduced" iPlaceholder="{{ __('stockmoves.total_produced_amount') }}" :key="$key" sClass="black"
                                                        model="unit_id" value="id" text="name" :collection="$workOrder->product->units" placeholder="{{__('modelnames.unit')}}"
                                                    />
                                                    <x-input label="{{ __('stockmoves.waste') }}" model="waste" placeholder="{{ __('stockmoves.waste_amount')}}">
                                                        <x-slot name="innerLabel">
                                                            @if(!empty($selectedUnit)) {{ $selectedUnit->abbreviation }} @else ... @endif
                                                        </x-slot>
                                                    </x-input>
                                                    <x-form-buttons submit="submitProductionCompleted({{ $workOrder->id }})"  />
                                                </div>
                                            </x-custom-modal>
                                        </div>
                                    @elseif($workOrder->is_active)
                                        <x-crud-actions modelName="work-order" :modelId="$workOrder->id" />
                                    @else
                                        <x-crud-actions modelName="work-order" gray :modelId="$workOrder->id" />
                                    @endif
                                </td>
                            </tr>
                        @endif
                    @endforeach
                </tbody>
            </table>
        </div>
    </x-content>
</div>
