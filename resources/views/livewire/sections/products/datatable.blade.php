
<div>

    <x-table-toolbar :perPage="$perPage" /> 

    <div>

        <table class="ui celled sortable table tablet stackable very compact">
            <thead>
                <tr>
                    <x-thead-item sortBy="code">{{ __('sections/products.code') }}</x-thead-item>
                    <th wire:click="sortBy('name')">
                        {{ __('sections/products.name') }}
                        <i class="{{ $this->getDirectionClass('name') }} icon"></i>
                    </th>
                    <x-thead-item>{{ __('modelnames.category') }}</x-thead-item>
                    <x-thead-item sortBy="barcode">{{ __('sections/products.barcode') }}</x-thead-item>
                    <x-thead-item sortBy="shelf_life">{{ __('sections/products.shelf_life') }}</x-thead-item>
                    {{-- <th>{{ __('sections/products.min_threshold') }}</th> --}}
                    <x-thead-item>{{ __('inventory.in_stock') }}</x-thead-item>
                    <x-thead-item sortBy="note">{{ __('sections/products.note') }}</x-thead-item>
                    <x-thead-item></x-thead-item>
                </tr>
            </thead>
            <tbody>
                @forelse ($data as $key => $product)
                    <tr wire:key="{{ $key }}">
                        <td class="collapsing">{{ $product->code }}</td>
                        <td>{{ $product->name }}</td>
                        <td>{{ $product->category->name }}</td>
                        <td>{{ $product->barcode }}</td>
                        <td>{{ $product->shelf_life }}</td>
                        {{-- <td>{{ $product->min_threshold }}</td> --}}
                        {{-- <td>{{ $product->min_threshold }}</td> --}}
                        <td>
                            @if ($product->isInStock)
                            <span class="text-ease-green text-sm">
                                {{ $product->totalStock['amount'] }} {{ $product->totalStock['unit']->abbreviation }}
                            </span>
                            @else <span class="text-sm text-ease-red">{{ __('common.NA') }}</span>
                            @endif
                        </td>
                        
                        <td class="">  {{-- truncate w-2/12 max-w-0 --}}
                            @if ($product->note) {{ $product->note }}
                            @else <span class="text-sm text-ease-red">{{ __('common.NA') }}</span>
                            @endif
                        </td>

                        <td class="collapsing">
                            <x-crud-actions edit show delete modelName="product" :modelId="$product->id" />
                        </td>

                    </tr>
                @empty
                    <tr>
                        <td colspan="10">
                            <x-placeholder icon="inbox">{{ __('datatable.no_results') }}</x-placeholder>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
        
        <div class="w-full">
            {{ $data->links('components.tailwind-pagination') }}
        </div>
        
    </div>
</div>

