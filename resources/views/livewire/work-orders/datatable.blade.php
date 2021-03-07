<div>

    <x-table-toolbar :perPage="$perPage">
        <x-slot name="filters">
            
            <div class="responsive-grid-3-4">
                <div>
                    <label for="wofilterselect-wo-code">{{ __('validation.attributes.wo_code') }}: </label>
                    <select wire:model="filterWoCode" id="wofilterselect-wo-code" class="basic-select text-xs">
                        <option value="" selected>{{ __('common.all') }}</option>
                        @foreach ($this->woCodes as $wo_code)
                            <option value="{{ $wo_code }}">
                                {{ $wo_code }}
                            </option>
                        @endforeach
                    </select>
                </div>
                
                <div>
                    <label for="wofilterselect-product">Ürün: </label>
                    <select wire:model="filterProduct" id="wofilterselect-product" class="basic-select text-xs">
                        <option value="" selected>{{ __('common.all') }}</option>
                        @foreach ($this->products as $product)
                            <option value="{{ $product->id }}">
                                {{ $product->prd_code}} - {{ $product->prd_name }} 
                            </option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label for="wofilterselect-status">{{ __('common.status') }}: </label>
                    <select wire:model="filterStatus" id="wofilterselect-status" class="basic-select text-xs">
                        <option value="" selected>{{ __('common.all') }}</option>
                        @foreach ($this->states as $status)
                            <option value="{{ $status }}">
                                {{ __('workorders.' . $status) }}
                            </option>
                        @endforeach
                    </select>
                </div>
                
                <div>
                    <label for="wofilterselect-wo-queue">{{ __('validation.attributes.wo_queue') }}: </label>
                    <input wire:model="filterWoQueue" placeholder="{{ __('validation.attributes.wo_queue') }}" id="wofilterselect-wo-queue" class="basic-select text-sm" />
                </div>
                
                
            </div>

        </x-slot>    
    </x-table-toolbar> 

    <div>
        <table class="ui celled sortable very compact table">
            <thead>
                <tr>
                    <x-thead-item sortBy="wo_code">{{ __('validation.attributes.wo_code') }}</x-thead-item>
                    <x-thead-item sortBy="wo_queue">{{ __('validation.attributes.wo_queue') }}</x-thead-item>
                    <x-thead-item>{{ __('products.name') }}</x-thead-item>
                    <x-thead-item sortBy="wo_amount">{{ __('validation.attributes.wo_amount') }}</x-thead-item>
                    <x-thead-item sortBy="wo_lot_no">{{ __('validation.attributes.wo_lot_no') }}</x-thead-item>
                    <x-thead-item sortBy="wo_datetime">{{ __('validation.attributes.wo_datetime') }}</x-thead-item>
                    <x-thead-item>{{ __('validation.attributes.wo_status') }}</x-thead-item>
                    <x-thead-item></x-thead-item>
                </tr>
            </thead>
            <tbody>
                @forelse ($data as $key => $workOrder)
                    <x-table-row>
                        <x-tbody-item class="center aligned collapsing">{{ $workOrder->wo_code }}</x-tbody-item>
                        <x-tbody-item class="center aligned collapsing font-bold">{{ $workOrder->wo_queue }}</x-tbody-item>
                        <x-tbody-item>
                            <span class="font-semibold">{{ $workOrder->product->prd_name }}</span>
                            <span class="font-bold text-xs text-ease">({{ $workOrder->product->prd_code }})</span>
                        </x-tbody-item>
                        <x-tbody-item class="collapsing">{{ $workOrder->wo_amount }} {{ $workOrder->unit->name }}</x-tbody-item>
                        <x-tbody-item class="">{{ $workOrder->wo_lot_no }}</x-tbody-item>
                        <x-tbody-item>
                            <span @if($workOrder->wo_datetime->format('d.m.Y') == date('d.m.Y')) class="text-red-800 font-bold" @endif>
                                {{ $workOrder->formattedDatetime() }}
                            </span>
                        </x-tbody-item>
                        <x-tbody-item class="center aligned collapsing">
                            <span data-tooltip="{{ $workOrder->statusLookup['explanation'] }}" data-variation="mini" data-position="left center">
                                <i class="{{ $workOrder->statusLookup['icon'] }}"></i>
                            </span>
                        </x-tbody-item>
                        
                        <x-tbody-item class="collapsing">
                            <div class="crud-buttons">
                                @can('view workorders')
                                    <x-show-button wire:key="showbutton_{{$loop->index}}" action="openDetailsModal({{ $workOrder->id }})" />
                                @endcan
                                @can('create update workorders')
                                    @if ($workOrder->canBeUpdated())
                                        <x-edit-button wire:key="editbutton_{{$loop->index}}" route="{{ route('work-orders.edit', ['work_order' => $workOrder]) }}" />
                                    @endif
                                @endcan
                                @can('delete workorders')
                                    @if ($workOrder->canBeDeleted())
                                        <x-delete-button wire:key="deletebutton_{{$loop->index}}" action="delete({{ $workOrder->id }})"  />
                                    @endif
                                @endcan
                            </div>
                        </x-tbody-item>
                    </x-table-row>
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
        
        
    </div>

    {{ $data->links('components.tailwind-pagination') }}
    
    @if ($detailsModal)
        <div wire:key="detailsModal" x-data="{detailsModal: @entangle('detailsModal')}">
            <x-custom-modal active="detailsModal" header="{{ __('workorders.details.header') }}">
                <x-workorder-details viewOnly :workOrder="$modalSelectedWorkOrder" />
            </x-custom-modal>
        </div>
    @endif

    @include('web.helpers.deletable')

</div>