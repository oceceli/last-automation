<div>
    
    <x-table-toolbar :perPage="$perPage" /> 

        
        <div>
            <x-table class="selectable">
                <x-thead>
                    <x-table-row>
                        <x-thead-item class="collapsing">{{ __('common.status') }}</x-thead-item>
                        <x-thead-item sortBy="code" class="cursor-pointer">{{ __('products.code')}} </x-thead-item>
                        <x-thead-item>{{ __('inventory.total') }}</x-thead-item>
                        <x-thead-item>{{ __('inventory.available') }}</x-thead-item>
                        <x-thead-item class="text-sm collapsing">{{ __('stockmoves.last_move') }}</x-thead-item>
                        <x-thead-item></x-thead-item>
                    </x-table-row>
                </x-thead>
                <x-tbody>
                    @forelse ($data as $product)
                    <x-table-row wire:key="inventory_row_{{ $loop->index }}" wire:click="showLots({{ $product->id }})" class="{{ $product->stockStatus['tr'] }}" >
                        <x-tbody-item class="center aligned collapsing">
                            <span data-tooltip="{{ $product->stockStatus['explanation'] }}" data-variation="mini" data-position="top left">
                                <i class="{{ $product->stockStatus['icon'] }}"></i>
                            </span>
                        </x-tbody-item>
                        <x-tbody-item class="font-bold">
                            {{ $product->prd_code }}
                            <span class="text-xs text-ease">{{ $product->prd_name }}</span>
                        </x-tbody-item>
                        <x-tbody-item class="font-semibold">
                            @if ($product->totalStock['reserved_amount'])
                                {{ $product->totalStock['amount_string'] }} 
                                <x-span tooltip="{{ __('inventory.reserved') }}" class="text-xs text-ease-red">
                                    - {{ $product->totalStock['reserved_amount_string'] }}
                                </x-span>
                            @else
                                {{ $product->totalStock['amount_string'] }}
                            @endif
                        </x-tbody-item>
                        <x-tbody-item class="font-bold">
                            {{ $product->totalStock['available_amount_string'] }}
                        </x-tbody-item>
                        <x-tbody-item class=" text-sm collapsing">
                            <i class="{{ $product->lastMove['direction'] }}"></i>
                            {{ $product->lastMove['date'] }} 
                        </x-tbody-item>
                        <x-tbody-item class=" collapsing center aligned">
                            <div wire:click="showLots({{ $product->id }})"
                                class="border bg-white shadow text-blue-400 hover:text-blue-700 ease-in-out duration-200 cursor-pointer">
                                <span class="p-1">LOT</span>
                                <i class="search alternate icon"></i>
                            </div>
                        </x-tbody-item>
                    </x-table-row>
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
    
        </div>
        {{ $data->links('components.tailwind-pagination') }}
        




        {{-- Product lots MODAL --------------------------------------------------}}
        @if ($selectedProduct)
        <div x-data="{lotModal: @entangle('lotModal')}">
            <x-custom-modal active="lotModal" header="{{ $selectedProduct->prd_name }}">

               
                    <x-product-lots :product="$selectedProduct" />


            </x-custom-modal>      
        </div> 
        @endif
        {{-- Product lots MODAL --------------------------------------------------}}
        
</div>



