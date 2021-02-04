@if ($spModal)
    <div x-data="{spModal: @entangle('spModal')}">
        <x-custom-modal active="spModal">
            
            <div class="p-4 flex flex-col gap-5 shadow-md bg-gray-100"> 
                @foreach ($cards as $key => $card)
                    <div wire:key="card_{{ $key }}" class="border-dashed border p-3 rounded hover:border-orange-500 ease-in-out duration-200">
                        <x-card  atClose="removeCard({{ $key }})">
                            <x-slot name="square">
                                <span class="font-bold text-xl">{{ $key }}</span>
                            </x-slot>
                            <div class="px-4 flex-1 ui form mini">
                                <div class="pt-2 equal width fields">
                                    <x-dropdown model="cards.{{ $key }}.product_id" :collection="$this->products" value="id" text="code,name" sClass="search" noErrors
                                        placeholder="{{ __('products.product') }}" sId="dp_product_{{$key}}" />
                                           
                                    {{-- <x-input defer model="cards.{{ $key }}.reserved_amount" placeholder="{{ __('common.amount') }}" /> --}}
            
                                    <x-dropdown iType="number" iModel="cards.{{ $key }}.dp_amount" iPlaceholder="{{ __('common.amount') }}" placeholder="{{ __('units.unit') }}" sClass="basic" noErrors
                                        model="cards.{{ $key }}.unit_id" initnone triggerOnEvent="sp_product_selected{{ $key }}" dataSourceFunction="getUnitsProperty" value="id" text="name" 
                                        sId="sp_unit_id_{{$key}}" />
                                </div>
                            </div>
                        </x-card>
                    </div>
                @endforeach
            </div>
            <div class="flex p-3">
                <button @click="spModal = false" class="ui mini orange w-full button">
                    {{ __('common.ok') }}
                </button>
                <button wire:click="addCard()" class="ui green mini icon button">
                    <i class="plus icon"></i>
                </button>
            </div>
        </x-custom-modal>
    </div>
@endif