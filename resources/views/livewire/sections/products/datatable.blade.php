
<div>

    <x-table-toolbar :perPage="$perPage" /> 

    <div>

        <table class="ui celled sortable table tablet stackable very compact disabled">
            <thead>
                <tr>
                    <th>{{ __('sections/products.code') }}</th>
                    <th>{{ __('sections/products.name') }}</th>
                    <th>{{ __('modelnames.category') }}</th>
                    <th>{{ __('sections/products.code') }}</th>
                    <th>{{ __('sections/products.barcode') }}</th>
                    <th>{{ __('sections/products.shelf_life') }}</th>
                    {{-- <th>{{ __('sections/products.min_threshold') }}</th> --}}
                    <th>{{ __('inventory.in_stock') }}</th>
                    <th>{{ __('sections/products.note') }}</th>
                    {{-- <th>{{ __('sections/products.producible') }}</th> --}}
                    {{-- <th>{{ __('sections/products.is_active') }}</th> --}}
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @forelse ($data as $key => $product)
                    <tr wire:key="{{ $key }}">
                        <td class="collapsing">{{ $product->code }}</td>
                        <td>{{ $product->name }}</td>
                        <td>{{ $product->category->name }}</td>
                        <td>{{ $product->code }}</td>
                        <td>{{ $product->barcode }}</td>
                        <td>{{ $product->shelf_life }}</td>
                        {{-- <td>{{ $product->min_threshold }}</td> --}}
                        {{-- <td>{{ $product->min_threshold }}</td> --}}
                        <td>
                            @if ($product->inStock)
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

