
<div>

    <x-table-toolbar :perPage="$perPage" /> 

    <div>

        <table class="ui celled sortable table tablet stackable very compact">
            <thead>
                <tr>
                    <th>Sıra</th>
                    <th>{{ __('sections/products.name') }}</th>
                    <th>{{ __('modelnames.category') }}</th>
                    <th>{{ __('sections/products.code') }}</th>
                    <th>{{ __('sections/products.barcode') }}</th>
                    <th>{{ __('sections/products.shelf_life') }}</th>
                    <th>{{ __('sections/products.min_threshold') }}</th>
                    <th>{{ __('sections/products.note') }}</th>
                    <th>{{ __('sections/products.producible') }}</th>
                    <th>{{ __('sections/products.is_active') }}</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @foreach ($data as $key => $product)
                    <tr>
                        <td>{{ $key+1 }}</td>
                        <td>{{ $product->name }}</td>
                        <td>{{ $product->category->name }}</td>
                        <td>{{ $product->code }}</td>
                        <td>{{ $product->barcode }}</td>
                        <td>{{ $product->shelf_life }}</td>
                        <td>{{ $product->min_threshold }}</td>
                        <td class="truncate w-2/12 max-w-0">
                            {{ $product->note }}
                        </td>
                        <td>
                            <div class="flex items-center justify-center">
                                <div class="ui slider checkbox">
                                    <input type="checkbox" wire:model.lazy="producible.{{ $key }}">
                                    <label></label>
                                </div>
                            </div>
                        </td>
                        <td>
                            <div class="flex items-center justify-center">
                                <div class="ui checkbox">
                                    <input type="checkbox" wire:model.lazy="is_active.{{ $key }}">
                                    <label></label>
                                </div>
                            </div>
                        </td>

                        <td class="collapsing">
                            <x-crud-actions edit show delete modelName="product" :modelId="$product->id" />
                        </td>

                    </tr>
                @endforeach
            </tbody>
        </table>
        
        <div class="w-full">
            {{ $data->links('components.tailwind-pagination') }}
        </div>
        
    </div>
</div>

