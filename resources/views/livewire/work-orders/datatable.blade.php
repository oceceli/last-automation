<div>

    <x-table-toolbar :perPage="$perPage" /> 

    <div>
        <table class="ui celled sortable very compact unstackable table">
            <thead>
                <tr>
                    <x-thead-item sortBy="wo_queue">{{ __('validation.attributes.wo_queue') }}</x-thead-item>
                    <x-thead-item sortBy="wo_code">{{ __('validation.attributes.wo_code') }}</x-thead-item>
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
                        <x-tbody-item class="center aligned collapsing font-bold">{{ $workOrder->wo_queue }}</x-tbody-item>
                        <x-tbody-item class="center aligned collapsing">{{ $workOrder->wo_code }}</x-tbody-item>
                        <x-tbody-item>{{ $workOrder->product->prd_name }}</x-tbody-item>
                        <x-tbody-item>{{ $workOrder->wo_amount }} {{ $workOrder->unit->name }}</x-tbody-item>
                        <x-tbody-item class="">{{ $workOrder->wo_lot_no }}</x-tbody-item>
                        <x-tbody-item>
                            <span>{{ $workOrder->wo_datetime }}</span>
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
                                    @if ($workOrder->isSuspended() || $workOrder->isActive())
                                        <x-edit-button wire:key="editbutton_{{$loop->index}}" route="{{ route('work-orders.edit', ['work_order' => $workOrder]) }}" />
                                    @endif
                                @endcan
                                @can('delete workorders')
                                    @if ($workOrder->isSuspended() || $workOrder->isActive())
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
                <x-workorder-details :workOrder="$modalSelectedWorkOrder" />
            </x-custom-modal>
        </div>
    @endif

    @include('web.helpers.deletable')

</div>