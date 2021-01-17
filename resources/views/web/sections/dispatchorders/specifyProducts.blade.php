<div>
    <x-page-header>
        <x-slot name="customHeader">
            <div class="flex gap-2 text-xs md:text-base">
                <span class="font-bold text-teal-700">{{ __('dispatchorders.products_to_be_dispatched') }}</span>
            </div>
        </x-slot>
        <x-slot name="buttons">
            <div class="ui mini icon buttons">
                <button wire:click.prevent="addCard" class="ui mini teal button" data-tooltip="{{ __('sections/recipes.add_ingredients') }}" data-variation="mini">
                    <i class="plus icon"></i>
                </button>
            </div>
        </x-slot>
    </x-page-header>
    
    {{-- CARD --}}
    <div class="pt-2 flex flex-col gap-5"> 
        @foreach ($cards as $key => $card)
            <div wire:key="card_{{ $key }}">
                <x-card  atClose="removeCard({{ $key }})">
                    <x-slot name="square">
                        <span class="font-bold text-xl">{{ $key }}</span>
                    </x-slot>
                    <div class="flex gap-3 items-center px-4 flex-1">
                        <div class="pt-2 equal width fields w-full">
                            <x-dropdown model="cards.{{ $key }}.product_id" :collection="$this->products" value="id" text="code,name" sClass="search" noErrors
                                placeholder="{{ __('sections/products.product') }}" sId="dp_product_{{$key}}" />
                                
                                                
                            {{-- <x-input defer model="cards.{{ $key }}.reserved_amount" placeholder="{{ __('common.amount') }}" /> --}}
    
                            <x-dropdown iType="number" iModel="cards.{{ $key }}.reserved_amount" iPlaceholder="{{ __('common.amount') }}" placeholder="{{ __('sections/units.unit') }}" sClass="basic" noErrors
                                model="cards.{{ $key }}.unitId" initnone triggerOnEvent="sp_product_selected{{ $key }}" dataSourceFunction="getUnitsProperty" value="id" text="name" 
                                sId="sp_unitId_{{$key}}" />
                            
                        </div>
                        
                    </div>
                </x-card>
            </div>
        @endforeach
    </div>
</div>