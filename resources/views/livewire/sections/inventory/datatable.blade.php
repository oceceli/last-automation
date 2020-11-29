<div>
    
    <x-table-toolbar :perPage="$perPage" /> 

    <div>

        <x-table class="celled">
            <thead>
                <tr>
                    <th class="">kod</th>
                    <th>ürün</th>
                    <th>mevcut stok</th>
                    <th class="text-sm collapsing">son hareket</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @foreach ($products as $product)
                <tr class="{{ $product->stockStatus['tr'] }} font-semibold ease-in-out duration-150 cursor-default">
                    <td class="collapsing font-bold ">
                        <span data-tooltip="{{ $product->stockStatus['explanation'] }}" data-variation="mini" data-position="top left">
                            <i class="{{ $product->stockStatus['icon'] }}"></i>
                        </span>
                        {{ $product->code }}
                    </td>
                    <td class="">{{ $product->name }}</td>
                    <td class="font-bold">{{ $product->totalStock['amount'] }} {{ $product->totalStock['unit']->name}}</td>
                    <td class=" text-sm collapsing">{{ $product['last_move'] }}</td>
                    <td class="one wide center aligned">
                        <div class="border bg-white shadow text-blue-400 hover:text-blue-700 ease-in-out duration-200 cursor-pointer">
                            <span class="p-1">LOT</span>
                            <i class="search alternate icon"></i>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </x-table>

        <div class="w-full">
            {{ $data->links('components.tailwind-pagination') }}
        </div>
        
        
    </div>
</div>


    {{-- <div class="flex flex-col gap-4">
        @foreach ($products as $product)
            <div>
                <div wire:key="{{ $loop->index }}" class="p-3 {{ $product->stockStatusColors['header'] }} rounded shadow-md grid grid-cols-2 md:grid-cols-3 gap-3 hover:shadow-outline-blue ease-in-out duration-150">
                    <div class="text-ease">
                        {{ $product->name }}
                        <span class="text-xs">({{ $product->code }})</span>
                    </div>
                    <div class="font-bold {{ $product->stockStatusColors['text'] }} text-ease text-right md:text-center">
                        {{ $product->totalStock }}
                        {{ $product->baseUnit->name }}
                    </div>
                    <div class="md:text-right">
                        <span class="border rounded-sm p-1 text-blue-400 text-sm hover:text-blue-700 ease-in-out duration-200 cursor-pointer">
                            <span class="p-1">LOT</span>
                            <i class="caret right icon"></i>
                        </span>
                    </div>
                </div>
                <div class="mx-3 rounded-b bg-white border shadow">
                    <div>

                        @if ($product->lots)
                            <table class="ui center aligned table very compact">
                                <thead>
                                    <tr>
                                        <th>Lot no</th>
                                        <th>mevcut stok</th>
                                        <th class="text-sm collapsing">son hareket</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($product->lots as $lot)
                                    <tr>
                                        <td class="text-ease">{{ $lot['lot_number'] }}</td>
                                        <td class="text-ease">{{ $lot['amount']}} {{ $lot['unit']->abbreviation }} </td>
                                        <td class="collapsing"></td>
                                        <td class="collapsing center aligned">
                                            <i class="truck icon"></i>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        @else
                            <div class="p-2 bg-red-50 text-center text ease text-red-600">
                                {{ __('common.empty') }}
                            </div>
                        @endif


                    </div>
                </div>
            </div>
        @endforeach
    </div> --}}



