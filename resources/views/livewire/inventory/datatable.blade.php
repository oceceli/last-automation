<div>
    
    <x-table-toolbar :perPage="$perPage" /> 

    <div x-data="{lotModal: @entangle('lotModal')}">
        
        <x-table class="celled ui celled sortable table tablet stackable very compact selectable">
            <x-thead>
                <tr>
                    <x-thead-item sortBy="code" class="">{{ __('products.code')}} </x-thead-item>
                    <x-thead-item sortBy="name">{{ __('products.name')}} </x-thead-item>
                    <x-thead-item>{{ __('inventory.available_quantity') }}</x-thead-item>
                    <x-thead-item class="text-sm collapsing">{{ __('stockmoves.last_move') }}</x-thead-item>
                    <x-thead-item></x-thead-item>
                </tr>
            </x-thead>
            <x-tbody>
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
                    <td class=" collapsing center aligned">
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
            </x-tbody>
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



