
<div>
    <x-table-toolbar :perPage="$perPage" /> 

    <div>

        <table class="ui celled sortable table tablet stackable very compact">
            <thead>
                <tr>
                    <th>Sıra</th>
                    <th>{{ __('sections/products.code') }}</th>
                    <th>{{ __('stockmoves.type') }}</th>
                    <th class="center aligned">{{ __('stockmoves.direction') }}</th>
                    <th>{{ __('stockmoves.amount') }}</th>
                    <th>{{ __('common.datetime') }}</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @foreach ($data as $key => $stockMove)
                    <tr class="@if($stockMove->direction) positive @else negative @endif">
                        <td class="collapsing center aligned">{{ $key+1 }}</td>
                        <td>
                            <span>{{ $stockMove->product->code }}</span>
                            <span class="text-sm text-gray-400 font-semibold">{{ $stockMove->product->name }}</span>
                        </td>
                        <td>
                            {{ __("stockmoves.$stockMove->type") }}
                        </td>
                        <td class="center aligned">
                            @if ($stockMove->direction) 
                                <span data-tooltip="{{ __('stockmoves.stock_enterance') }}" data-variation="mini"><i class="green plus icon"></i></span>
                            @else 
                                <span data-tooltip="{{ __('stockmoves.stock_decrease') }}" data-variation="mini"><i class="red minus icon"></i></span>
                            @endif
                        </td>
                        <td>{{ round($stockMove->amount, 2) }}</td>
                        <td>{{ $stockMove->datetime }}</td>

                        <td class="collapsing">
                            <x-crud-actions modelName="stock-move" :modelId="$stockMove->id" />
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
