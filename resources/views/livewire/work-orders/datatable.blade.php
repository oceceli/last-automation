<div>

    <x-table-toolbar :perPage="$perPage" /> 

    <div>
        <table class="ui celled sortable very compact unstackable table">
            <thead>
                <tr>
                    <x-thead-item sortBy="status">{{ __('workorders.wo_status') }}</x-thead-item>
                    <x-thead-item sortBy="queue">{{ __('workorders.queue') }}</x-thead-item>
                    <x-thead-item sortBy="code">{{ __('workorders.code') }}</x-thead-item>
                    <x-thead-item>{{ __('products.name') }}</x-thead-item>
                    <x-thead-item sortBy="amount">{{ __('workorders.amount') }}</x-thead-item>
                    <x-thead-item sortBy="lot_no">{{ __('workorders.lot_no') }}</x-thead-item>
                    <x-thead-item sortBy="datetime">{{ __('workorders.datetime') }}</x-thead-item>
                    {{-- <x-thead-item sortBy="">{{ __('workorders.in_progress') }}</x-thead-item>     --}}
                    <x-thead-item></x-thead-item>
                </tr>
            </thead>
            <tbody>
                @forelse ($data as $key => $workOrder)
                    @if ($workOrder->isFinalized())
                        <tr class="positive">
                            <td class="center aligned collapsing" data-tooltip="{{ __('workorders.production_is_completed') }}" data-variation="mini">
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
                                    <span data-tooltip="{{ __('workorders.production_continues') }}" data-variation="mini">
                                        <i class="large loading cog icon"></i>
                                    </span>
                                @elseif($workOrder->isActive())
                                    <span data-tooltip="{{ __('workorders.waiting_for_production') }}" data-variation="mini">
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
                @empty
                    <tr>
                        <td colspan="10">
                            <x-placeholder icon="project diagram">
                                {{ __('workorders.no_workorder_found') }}
                            </x-placeholder>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
        
        
        {{-- <div class="ui toggle checkbox">
            <input wire:model.lazy="isActive()" type="checkbox">
            <label>Aktif</label>
        </div> --}}
        
    </div>

    {{ $data->links('components.tailwind-pagination') }}
    
    @include('web.helpers.deletable')

</div>