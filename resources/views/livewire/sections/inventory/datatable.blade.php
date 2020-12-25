<div>
    
    <x-table-toolbar :perPage="$perPage" /> 

    <div x-data="{lotModal: @entangle('lotModal')}">
        

        <x-table class="celled ui celled sortable table tablet stackable very compact">
            <thead>
                <tr>
                    <x-thead-item sortBy="code" class="">{{ __('sections/products.code')}} </x-thead-item>
                    <x-thead-item sortBy="name">{{ __('sections/products.name')}} </x-thead-item>
                    <x-thead-item>{{ __('inventory.available_quantity') }}</x-thead-item>
                    <x-thead-item class="text-sm collapsing">{{ __('stockmoves.last_move') }}</x-thead-item>
                    <x-thead-item></x-thead-item>
                </tr>
            </thead>
            <tbody>
                @forelse ($data as $product)
                <tr class="{{ $product->stockStatus['tr'] }} font-semibold ease-in-out duration-150 cursor-default" wire:key="{{ $loop->index }}">
                    <td class="collapsing font-bold ">
                        <span data-tooltip="{{ $product->stockStatus['explanation'] }}" data-variation="mini" data-position="top left">
                            <i class="{{ $product->stockStatus['icon'] }}"></i>
                        </span>
                        {{ $product->code }}
                    </td>
                    <td class="">{{ $product->name }}</td>
                    <td class="font-bold">{{ $product->totalStock['amount'] }} {{ $product->totalStock['unit']->name}}</td>
                    <td class=" text-sm collapsing">
                        <i class="{{ $product->lastMove['direction'] }}"></i>
                        {{ $product->lastMove['date'] }} 
                    </td>
                    <td class="one wide center aligned">
                        <div wire:click="lots({{ $product->id }})"
                            class="border bg-white shadow text-blue-400 hover:text-blue-700 ease-in-out duration-200 cursor-pointer">
                            <span class="p-1">LOT</span>
                            <i class="search alternate icon"></i>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="10">
                        <x-placeholder icon="warehouse">
                            {{ __('common.no_results') }}
                        </x-placeholder>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </x-table>

        <div class="w-full">
            {{ $data->links('components.tailwind-pagination') }}
        </div>
        
        {{-- Product lots MODAL --------------------------------------------------}}
        <x-custom-modal active="lotModal">
            <div class="py-2 px-6">
                @if ($selectedProduct)
                    <h4 class="font-bold px-2 pt-2 text-ease">{{ $selectedProduct->name }}</h4>
                    <table class="ui center aligned table unstackable very compact">
                        <thead>
                            <tr>
                                <x-thead-item>{{ __('stockmoves.lot_number') }}</x-thead-item>
                                <x-thead-item>{{ __('inventory.available_quantity') }}</x-thead-item>
                                <x-thead-item class="text-sm collapsing">{{ __('stockmoves.last_move') }}</x-thead-item>
                                <x-thead-item></x-thead-item>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($selectedProduct->lots as $lot)
                            <tr wire:key="{{ $loop->index }}">
                                <td class="text-ease">{{ $lot['lot_number'] }}</td>
                                <td class="text-ease">{{ $lot['amount']}} {{ $lot['unit']->abbreviation }} </td>
                                <td class="collapsing"></td>
                                <td class="collapsing center aligned">
                                    <i class="truck icon"></i>
                                </td>
                            </tr>
                            @empty
                            <tr class="p-2 bg-red-50 text-center text ease text-red-600">
                                <td colspan="10">{{ __('common.empty') }}</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                    <div class="text-ease font-bold text-right p-4">
                        <span>Toplam</span>
                        <u>{{ $selectedProduct->totalStock['amount'] }} {{ $selectedProduct->totalStock['unit']->name }}</u>
                    </div>
                @endif
            </div>
        </x-custom-modal>   
        {{-- Product lots MODAL --------------------------------------------------}}

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



