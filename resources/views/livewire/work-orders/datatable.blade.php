<div>

    <x-table-toolbar :perPage="$perPage" /> 

    <div>
        <table class="ui celled sortable very compact unstackable table">
            <thead>
                <tr>
                    <x-thead-item sortBy="queue">{{ __('validation.attributes.wo_queue') }}</x-thead-item>
                    <x-thead-item sortBy="code">{{ __('validation.attributes.wo_code') }}</x-thead-item>
                    <x-thead-item>{{ __('products.name') }}</x-thead-item>
                    <x-thead-item sortBy="amount">{{ __('validation.attributes.wo_amount') }}</x-thead-item>
                    <x-thead-item sortBy="lot_no">{{ __('validation.attributes.wo_lot_no') }}</x-thead-item>
                    <x-thead-item sortBy="datetime">{{ __('validation.attributes.wo_datetime') }}</x-thead-item>
                    <x-thead-item sortBy="status">{{ __('validation.attributes.wo_status') }}</x-thead-item>
                    <x-thead-item></x-thead-item>
                </tr>
            </thead>
            <tbody>
                @forelse ($data as $key => $workOrder)
                    @if (!$workOrder->isFinalized())
                        <tr class="positive">
                            <td class="center aligned collapsing font-bold">{{ $workOrder->wo_queue }}</td>
                            <td class="center aligned collapsing">{{ $workOrder->wo_code }}</td>
                            <td>{{ $workOrder->product->prd_name }}</td>
                            <td>{{ $workOrder->wo_amount }} {{ $workOrder->unit->name }}</td>
                            <td class="">{{ $workOrder->wo_lot_no }}</td>
                            <td>
                                <span>{{ $workOrder->wo_datetime }}</span>
                                <span class="font-bold">({{ __('common.today') }})</span>
                            </td>
                            <td class="center aligned collapsing" data-tooltip="{{ __('workorders.production_is_completed') }}" data-variation="mini">
                                <i class="large green checkmark icon"></i>
                            </td>
                            <td class="collapsing selectable">
                                {{-- <span class="text-green-800">{sayı} {baseUnit}</span>
                                <span data-tooltip="{{ __('common.see_details') }}" data-variation="mini">
                                    <i class="link teal eye icon"></i>
                                </span> --}}
                                {{-- <x-crud-actions show edit delete modelName="work-order" :modelId="$workOrder->id" /> --}}

                                <div class="crud-buttons">
                                    @can('view workorders')
                                        <x-show-button wire:key="showbutton_{{$loop->index}}" action="openDetailsModal({{ $workOrder->id }})" />
                                    @endcan
                                    @can('create update workorders')
                                        <x-edit-button wire:key="editbutton_{{$loop->index}}" route="{{ route('work-orders.edit', ['work_order' => $workOrder]) }}" />
                                    @endcan
                                    @can('delete workorders')
                                        <x-delete-button wire:key="deletebutton_{{$loop->index}}" action="delete({{ $workOrder->id }})"  />
                                    @endcan
                                </div>
                            </td>

                            
                        </tr>
                    @else
                        {{-- <tr class="@if($workOrder->isInProgress()) left teal marked @elseif($workOrder->isActive()) left primary marked @else left grey marked text-gray-400 @endif"> --}}
                        <tr>
                            <td class="center aligned collapsing font-bold">{{ $workOrder->wo_queue }}</td>
                            <td class="center aligned collapsing">{{ $workOrder->wo_code }}</td>
                            <td>{{ $workOrder->product->prd_name }}</td>
                            <td>{{ $workOrder->wo_amount }} {{ $workOrder->unit->name }}</td>
                            <td class="">{{ $workOrder->wo_lot_no }}</td>
                            <td>
                                <span>{{ $workOrder->wo_datetime }}</span>
                                <span class="font-bold">(bugün)</span>
                            </td>
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
    
    @if ($detailsModal)
        <div wire:key="detailsModal" x-data="{detailsModal: @entangle('detailsModal')}">
            <x-custom-modal active="detailsModal" header="{{ __('workorders.details.header') }}">
                {{-- <x-work-order-details /> --}}
            </x-custom-modal>
        </div>
    @endif

    @include('web.helpers.deletable')

</div>