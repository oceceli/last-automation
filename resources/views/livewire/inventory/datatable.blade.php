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
                            {{ $product->code }}
                            <span class="text-xs text-ease">{{ $product->name }}</span>
                        </x-tbody-item>
                        <x-tbody-item class="font-semibold">
                            @if ($product->totalStock['reserved_amount'])
                                {{ $product->totalStock['amount'] }} 
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
            <x-custom-modal active="lotModal" header="{{ $selectedProduct->name }}">

                <div class="p-2 bg-smoke-lightest">
                    {{-- <div class="bg-white rounded-t p-2 shadow-md relative">
                        <x-table class="center aligned">
                            <thead>
                                <x-table-row>
                                    <x-thead-item>{{ __('stockmoves.lot_number') }}</x-thead-item>
                                    <x-thead-item>{{ __('inventory.total') }}</x-thead-item>
                                    <x-thead-item>{{ __('inventory.available') }}</x-thead-item>
                                </x-table-row>
                            </thead>
                            <tbody>
                                @forelse ($selectedProduct->lots as $lot)
                                <x-table-row wire:key="lots_rows_{{ $loop->index }}">
                                    <x-tbody-item class="text-ease">{{ $lot['lot_number'] }}</x-tbody-item>
                                    <x-tbody-item class="font-semibold">
                                        @if ($lot['reserved_amount'])
                                            {{ $lot['amount'] }} 
                                            <x-span tooltip="{{ __('inventory.reserved') }}" class="text-xs text-ease-red">
                                                - {{ $lot['reserved_amount_string'] }}
                                            </x-span>
                                        @else
                                            {{ $lot['amount_string'] }}
                                        @endif
                                    </x-tbody-item>
                                    <x-tbody-item class="font-bold">
                                        {{ $lot['available_amount_string'] }}
                                    </x-tbody-item>
                                    
                                </x-table-row>
                                @empty
                                <x-table-row class="p-2 bg-red-50 text-center text ease text-red-600">
                                    <x-tbody-item colspan="10">{{ __('common.empty') }}</x-tbody-item>
                                </x-table-row>
                                @endforelse
                            </tbody>
                        </x-table>
                            
                    </div> --}}
                    <x-product-lots :product="$selectedProduct" />

                    <div class="p-4 bg-gray-700 text-white rounded-b flex justify-between font-bold shadow-md">
                        <div>
                            {{ __('common.total') }}
                            @if ($selectedProduct->totalStock['reserved_amount'])
                                {{ $selectedProduct->totalStock['amount'] }} 
                                <x-span tooltip="{{ __('inventory.reserved') }}" class="text-xs text-ease-red">
                                    - {{ $selectedProduct->totalStock['reserved_amount_string'] }}
                                </x-span>
                            @else
                                {{ $selectedProduct->totalStock['amount_string'] }}
                            @endif
                        </div>
                        <div>
                            <span>{{ $selectedProduct->totalStock['available_amount_string'] }} </span>
                            <span class="text-xs">{{ __('inventory.available') }}</span>
                        </div>
                    </div>
                </div>

            </x-custom-modal>      
        </div> 
        @endif
        {{-- Product lots MODAL --------------------------------------------------}}
        
</div>



