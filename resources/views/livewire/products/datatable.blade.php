
<div>

    <x-table-toolbar :perPage="$perPage" /> 

    <div>

        <x-table class="sortable">
            <thead>
                <x-table-row>
                    <x-thead-item sortBy="prd_code" class="center aligned">{{ __('validation.attributes.prd_code') }}</x-thead-item>
                    <x-thead-item wire:click="sortBy('name')">
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
                        <x-tbody-item class="center aligned font-bold selectable">{{ $product->prd_code }}</x-tbody-item>
                        <x-tbody-item>{{ $product->prd_name }}</x-tbody-item>
                        <x-tbody-item>{{ optional($product->category)->ctg_name }}</x-tbody-item>
                        <x-tbody-item>{{ $product->prd_barcode }}</x-tbody-item>
                        <x-tbody-item class="center aligned">{{ $product->prd_shelf_life }}</x-tbody-item>
                        <x-tbody-item class="center aligned">{{ $product->prd_cost }}</x-tbody-item>
                        <x-tbody-item class="center aligned">
                            @if ($product->isInStock)
                            <span class="text-ease-green text-sm">
                                {{ $product->totalStock['amount'] }} {{ $product->totalStock['unit']->abbreviation }}
                            </span>
                            @else <span class="text-sm text-ease-red">{{ __('common.NA') }}</span>
                            @endif
                        </x-tbody-item>
                        

                        <x-tbody-item class="collapsing">
                            @can(['create edit products', 'delete products'])
                                <x-crud-actions edit show delete modelName="product" :modelId="$product->id" />
                            @endcan
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

</div>

