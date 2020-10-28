
<div>

    <x-table-toolbar :perPage="$perPage" /> 

    <div>

        <table class="ui celled sortable table tablet stackable very compact">
            <thead>
                <tr>
                    <th>Sıra</th>
                    <th>{{ __('sections/products.name') }}</th>
                    <th>{{ __('sections/categories.category') }}</th>
                    <th>{{ __('sections/products.code') }}</th>
                    <th>{{ __('sections/products.barcode') }}</th>
                    <th>{{ __('sections/products.shelf_life') }}</th>
                    <th>{{ __('sections/products.producible') }}</th>
                    <th>{{ __('sections/products.is_active') }}</th>
                    <th>{{ __('sections/products.min_threshold') }}</th>
                    <th>{{ __('sections/products.note') }}</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @foreach ($data as $key => $context)
                    <tr>
                        <td>{{ $key+1 }}</td>
                        <td>{{ $context->name }}</td>
                        <td>{{ $context->category->name }}</td>
                        <td>{{ $context->code }}</td>
                        <td>{{ $context->barcode }}</td>
                        <td>{{ $context->shelf_life }}</td>
                        <td>{{ $context->producible }}</td>
                        <td>{{ $context->is_active }}</td>
                        <td>{{ $context->min_threshold }}</td>
                        <td>{{ $context->note }}</td>

                        <td class="collapsing">
                            <x-crud-actions modelName="product" :modelId="$context->id" />
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

