
<div>
    <x-table-toolbar :perPage="$perPage" /> 

    <div>

        <table class="ui celled sortable table tablet stackable very compact">
            <thead>
                <tr>
                    <x-thead-item>Sıra</x-thead-item>
                    <x-thead-item sortBy="type" class="center aligned">{{ __('stockmoves.type') }}</x-thead-item>
                    <x-thead-item>{{ __('products.code') }}</x-thead-item>
                    <x-thead-item>{{ __('stockmoves.amount') }}</x-thead-item>
                    <x-thead-item sortBy="lot_number">{{ __('stockmoves.lot_number') }}</x-thead-item>
                    <x-thead-item sortBy="datetime">{{ __('common.datetime') }}</x-thead-item>
                    <x-thead-item></x-thead-item>
                </tr>
            </thead>
            <tbody>
                @forelse ($data as $key => $stockMove)
                    <tr class="@if($stockMove->direction) positive @else negative @endif">
                        <td class="collapsing center aligned">{{ $key+1 }}</td>
                        <td class="one wide center aligned">
                            {{ $stockMove->type }}
                            {{-- @if ($stockMove->isProduction())
                                <a href="{{ route('work-orders.show', ['work_order' => $stockMove->stockable->id] )}}" style="color: inherit;">
                                    <div class="p-1 bg-white rounded-md shadow hover:shadow-md font-bold leading-5 transition ease-in-out duration-200 hover:bg-gray-50">
                                        {{ __('stockmoves.production') }}
                                    </div>
                                </a>
                            @else
                                <span>{{ __("stockmoves.manual") }}</span>
                            @endif --}}
                        </td>
                        <td class="font-bold">
                            <span>{{ $stockMove->product->prd_code }}</span>
                            <span class="text-sm text-ease">{{ $stockMove->product->prd_name }}</span>
                        </td>
                        <td class="cursor-default">
                            @if ($stockMove->direction) 
                                <span data-tooltip="{{ __('stockmoves.stock_entry') }}" data-variation="mini"><i class="green plus icon"></i></span>
                            @else 
                                <span data-tooltip="{{ __('stockmoves.stock_decrease') }}" data-variation="mini"><i class="red minus icon"></i></span>
                            @endif
                            <span class="font-bold">{{ $stockMove->base_amount }}</span>
                            <span class="text-sm">{{ $stockMove->unitName }}</span>
                            {{-- @if ( ! $stockMove->unitIsAlreadyBase())
                                <span class="text-xs text-ease">({{ $stockMove->convertToBase()['amount'] }} {{ $stockMove->convertToBase()['unit']->name }})</span>
                            @endif --}}
                        </td>
                        <td>{{ $stockMove->lot_number }}</td>
                        <td class="text-sm">{{ $stockMove->datetime }}</td>

                        <td class="collapsing">
                            <x-span tooltip="{{ __('common.see_details') }}" position="left center">
                                @if ($stockMove->isProduction())
                                    <a href="{{ route('work-orders.show', ['work_order' => $stockMove->stockable]) }}">
                                        <i class="purple project diagram link icon"></i>
                                    </a>
                                @elseif($stockMove->isDispatch())
                                    <a href="{{ route('dispatchorders.prepare', ['dispatchOrder' => $stockMove->stockable]) }}">
                                        <i class="teal truck link icon"></i>
                                    </a>
                                @elseif($stockMove->isTypeManual())
                                    <i class="eye link icon"></i>
                                @endif
                            </x-span>
                        </td>

                    </tr>
                @empty
                    <tr>
                        <td colspan="10">
                            <x-placeholder icon="truck packing">
                                {{ __('common.no_results') }}
                            </x-placeholder>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
        
    </div>

    {{ $data->links('components.tailwind-pagination') }}
    
</div>

