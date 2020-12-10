<div>

    @if ($data->count() > 0)
    <x-table-toolbar :perPage="$perPage" /> 

    <div>
        <table class="ui celled sortable selectableeeeeeeeeeeeeeeeeeeee very compact unstackable table">
            <thead>
                <tr>
                    <th>{{ __('sections/workorders.wo_status') }}</th>
                    <th>{{ __('sections/workorders.queue') }}</th>
                    <th>{{ __('sections/workorders.code') }}</th>
                    <th>{{ __('sections/products.name') }}</th>
                    <th>{{ __('sections/workorders.amount') }}</th>
                    <th>{{ __('sections/workorders.lot_no') }}</th>
                    <th>{{ __('sections/workorders.datetime') }}</th>
                    {{-- <th>{{ __('sections/workorders.in_progress') }}</th>     --}}
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @foreach ($data as $key => $workOrder)
                    @if ($workOrder->isCompleted())
                        <tr class="positive">
                            <td class="center aligned collapsing" data-tooltip="{{ __('sections/workorders.production_is_completed') }}" data-variation="mini">
                                <i class="large green checkmark icon"></i>
                            </td>
                            <td class="left marked green center aligned collapsing font-bold">{{ $workOrder->queue }}</td>
                            <td class="center aligned collapsing">{{ $workOrder->code }}</td>
                            <td>{{ $workOrder->product->name }}</td>
                            <td>{{ $workOrder->amount }} {{ $workOrder->unit->name }}</td>
                            <td class="">{{ $workOrder->lot_no }}</td>
                            <td>
                                <span>{{ $workOrder->datetime }}</span>
                                <span class="font-bold">(bugün)</span>
                            </td>
                            {{-- <td>{{ $workOrder->in_progress }}</td> --}}
                            {{-- <td>{{ $workOrder->isActive() }}</td> --}}
                            <td class="collapsing selectable">
                                <span class="text-green-800">{sayı} {baseUnit}</span>
                                <span data-tooltip="{{ __('common.see_details') }}" data-variation="mini">
                                    <i class="link teal eye icon"></i>
                                </span>
                                <x-crud-actions show edit delete modelName="work-order" :modelId="$workOrder->id" />
                            </td>

                            
                        </tr>
                    @else
                        <tr class="@if($workOrder->isInProgress()) left teal marked @elseif($workOrder->isActive()) left primary marked @else left grey marked text-gray-400 @endif">
                            <td class="center aligned collapsing">
                                @if($workOrder->isInProgress())
                                    <span data-tooltip="{{ __('sections/workorders.production_continues') }}" data-variation="mini">
                                        <i class="large loading cog icon"></i>
                                    </span>
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
                            <td class="center aligned collapsing font-bold">{{ $workOrder->queue }}</td>
                            <td class="center aligned collapsing">{{ $workOrder->code }}</td>
                            <td>{{ $workOrder->product->name }}</td>
                            <td>{{ $workOrder->amount }} {{ $workOrder->unit->name }}</td>
                            <td class="">{{ $workOrder->lot_no }}</td>
                            <td>
                                <span>{{ $workOrder->datetime }}</span>
                                <span class="font-bold">(bugün)</span>
                            </td>
                            {{-- <td>{{ $workOrder->in_progress }}</td> --}}
                            
                            {{-- <td class="">Onay<i class="green checkmark icon"></i></td> --}}
                            <td class="collapsing">
                                @if($workOrder->isInProgress())
                                    <x-crud-actions edit show delete modelName="work-order" :modelId="$workOrder->id" />
                                @elseif($workOrder->isActive())
                                    <x-crud-actions show edit delete modelName="work-order" :modelId="$workOrder->id" />
                                @else
                                    <x-crud-actions show edit delete modelName="work-order" gray :modelId="$workOrder->id" />
                                @endif
                            </td>
                        </tr>
                    @endif
                @endforeach
            </tbody>
        </table>
        
        <div class="w-full">
            {{ $data->links('components.tailwind-pagination') }}
        </div>

        {{-- <div class="ui toggle checkbox">
            <input wire:model.lazy="isActive()" type="checkbox">
            <label>Aktif</label>
        </div> --}}
        
        
    </div>
    @else
    <div class="ui placeholder segment h-full">
        <div class="ui icon header">
            <i class="project diagram icon"></i>
            <a href="{{ route('work-orders.create') }}" class="text-blue-600 font-bold focus:outline-none">{{ __('common.click_here_link') }}</a> {{ __('sections/workorders.create_workorder') }}
        </div>
        <div class="text-sm font-semibold text-gray-500 text-center">{{ __('sections/workorders.no_workorder_found') }}</div>
    </div>
    @endif
</div>