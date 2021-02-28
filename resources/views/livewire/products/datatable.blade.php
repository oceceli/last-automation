
<div>

    <x-table-toolbar :perPage="$perPage">
        <x-slot name="filters">
            <div class="responsive-grid-3-4">

                {{-- <div>
                    <label for="wofilterselect-wo-code">{{ __('validation.attributes.wo_code') }}: </label>
                    <select wire:model="filterWoCode" id="wofilterselect-wo-code" class="basic-select text-xs">
                        <option value="" selected>{{ __('common.all') }}</option>
                        @foreach ($this->woCodes as $wo_code)
                            <option value="{{ $wo_code }}">
                                {{ $wo_code }}
                            </option>
                        @endforeach
                    </select>
                </div> --}}

            </div>
        </x-slot>    
    </x-table-toolbar> 

    <div>

        <x-table class="sortable">
            <thead>
                <x-table-row>
                    <x-thead-item class="collapsing">{{ __('common.status') }}</x-thead-item>
                    <x-thead-item sortBy="prd_code" class="center aligned">{{ __('validation.attributes.prd_code') }}</x-thead-item>
                    <x-thead-item wire:click="sortBy('prd_name')">
                        {{ __('validation.attributes.prd_name') }}
                        <i class="{{ $this->getDirectionClass('name') }} icon"></i>
                    </x-thead-item>
                    <x-thead-item>{{ __('modelnames.category') }}</x-thead-item>
                    <x-thead-item sortBy="prd_barcode">{{ __('validation.attributes.prd_barcode') }}</x-thead-item>
                    <x-thead-item sortBy="prd_shelf_life" class="collapsing">{{ __('validation.attributes.prd_shelf_life') }}</x-thead-item>
                    <x-thead-item class="center aligned">{{ __('validation.attributes.prd_cost') }}</x-thead-item>
                    <x-thead-item class="center aligned">{{ __('inventory.in_stock') }}</x-thead-item>
                    <x-thead-item></x-thead-item>
                </x-table-row>
            </thead>
            <tbody>
                @forelse ($data as $key => $product)
                    <x-table-row wire:key="{{ $key }}">
                        <x-tbody-item class="center aligned collapsing">
                            <x-span tooltip="{{ $this->statusIcon($product)['explanation'] }}">
                                <i class="{{ $this->statusIcon($product)['class'] }}"></i>
                            </x-span>
                        </x-tbody-item>
                        <x-tbody-item class="center aligned font-bold collapsing">{{ $product->prd_code }}</x-tbody-item>
                        <x-tbody-item>{{ $product->prd_name }}</x-tbody-item>
                        <x-tbody-item class="collapsing">{{ optional($product->category)->ctg_name }}</x-tbody-item>
                        <x-tbody-item>{{ $product->prd_barcode }}</x-tbody-item>
                        <x-tbody-item class="center aligned">{{ $product->prd_shelf_life }}</x-tbody-item>
                        <x-tbody-item class="center aligned">{{ $product->prd_cost }}</x-tbody-item>
                        <x-tbody-item class="center aligned collapsing">
                            @if ($product->isInStock)
                            <span class="text-ease-green text-sm">
                                {{ $product->totalStock['amount'] }} {{ $product->totalStock['unit']->abbreviation }}
                            </span>
                            @else <span class="text-sm text-ease-red">{{ __('common.NA') }}</span>
                            @endif
                        </x-tbody-item>
                        

                        <x-tbody-item class="collapsing">

                            <div class="crud-buttons">
                                @can('view products')
                                    <x-show-button wire:key="showbutton_{{$loop->index}}" action="openDetailsModal({{ $product->id }})" />
                                @endcan
                                @can('create update products')
                                    <x-edit-button wire:key="editbutton_{{$loop->index}}" route="{{ route('products.edit', ['product' => $product]) }}" />
                                @endcan
                                @can('delete products')
                                    <x-delete-button wire:key="deletebutton_{{$loop->index}}" action="delete({{ $product->id }})"  />
                                @endcan
                            </div>


                        </x-tbody-item>

                    </x-table-row>
                @empty
                    <tr>
                        <x-tbody-item colspan="10">
                            <x-placeholder icon="brown open box">{{ __('common.no_results') }}</x-placeholder>
                        </x-tbody-item>
                    </tr>
                @endforelse
            </tbody>
        </x-table>
    
    </div>
    
    {{ $data->links('components.tailwind-pagination') }}


    @if ($detailsModal)
        <div wire:key="detailsModal" x-data="{detailsModal: @entangle('detailsModal')}">
            <x-custom-modal active="detailsModal" header="{{ __('products.details.header') }}">
                <livewire:products.details-component wire:key="productDetailsComponent" :product="$selectedProduct" />
            </x-custom-modal>
        </div>
    @endif


    @include('web.helpers.deletable')

</div>

