{{-- @if ($spModal) --}}
    {{-- <div x-data="{spModal: @entangle('spModal')}"> --}}
        {{-- <x-custom-modal active="spModal"> --}}
            
                
                <div class="flex flex-col gap-5 border-dashed border border-blue-300 p-3 rounded hover:border-blue-500 ease-in-out duration-200">
                    @foreach ($cards as $key => $card)
                        <div wire:key="card_{{ $key }}" class="">
                            <x-card  atClose="removeCard({{ $key }})">
                                <x-slot name="square">
                                    {{-- <span class="font-bold text-xl">{{ $key }}</span> --}}
                                    <i class="blue large shipping fast icon"></i>
                                </x-slot>
                                <div class="px-4 flex-1 ui form mini">
                                    <div class="pt-2 equal width fields">
                                        <x-dropdown model="cards.{{ $key }}.product_id" :collection="$this->products" value="id" text="prd_code,prd_name" sClass="search" noErrors
                                            placeholder="{{ __('products.product') }}" sId="dp_product_{{$key}}" />
                                               
                                        {{-- <x-input defer model="cards.{{ $key }}.reserved_amount" placeholder="{{ __('common.amount') }}" /> --}}
                
                                        {{-- @if ($editMode)
                                            <x-input model="cards.{{ $key }}.dp_amount" placeholder="{{ __('units.unit') }}">
                                                <x-slot name="innerLabel">
                                                    {{ App\Models\Unit::find($card['unit_id'])->name }}
                                                </x-slot>
                                            </x-input>
                                        @else --}}
                                            <x-dropdown iType="number" iModel="cards.{{ $key }}.dp_amount" iPlaceholder="{{ __('common.amount') }}" placeholder="{{ __('units.unit') }}" sClass="basic" noErrors
                                                model="cards.{{ $key }}.unit_id" triggerOnEvent="sp_product_selected{{ $key }}" dataSource="cards.{{ $key }}.units" value="id" text="name" 
                                                sId="sp_unit_id_{{$key}}" />
                                        {{-- @endif --}}


                                        {{-- {{ $cards[$key]['unit_id'] }}

                                        <x-inputdrop iModel="cards.{{ $key }}.dp_amount" iPlaceholder="{{ __('common.amount') }}" model="cards.{{ $key }}.unit_id">
                                            @foreach($this->units as $unit)
                                                <div class="item" data-value="{{ $unit['id'] }}">{{ $unit['name'] }}</div>
                                            @endforeach                        
                                        </x-inputdrop> --}}

                                    </div>
                                </div>
                            </x-card>
                        </div>
                    @endforeach
                    <div class="flex justify-between items-center">
                        @if ($this->getCountFilledCards())
                            <span class="text-sm text-ease">
                                <i class="edit icon"></i>
                                {{ __('dispatchorders.count_dispatch_product_selected', ['count' => $this->getCountFilledCards()]) }}
                            </span>
                        @else
                            <span class="text-sm text-ease-red font-bold">
                                {{ __('dispatchorders.please_select_products_to_be_dispatched') }}...
                            </span> 
                        @endif 
                        <button wire:click.prevent="addCard()" class="ui blue mini icon button">
                            <i class="large shipping fast icon"></i>
                            <i class="plus icon"></i>
                        </button>
                    </div>
                </div>
            
        {{-- </x-custom-modal> --}}
    {{-- </div> --}}
{{-- @endif --}}




{{-- @foreach ($cards as $key => $card)
    <div wire:key="card_{{ $key }}" class="border-dashed border p-3 rounded hover:border-orange-500 ease-in-out duration-200">
        <x-card  atClose="removeCard({{ $key }})">
            <x-slot name="square">
                <span class="font-bold text-xl">{{ $key }}</span>
            </x-slot>
            <div class="px-4 flex-1 ui form mini">
                <div class="pt-2 equal width fields">
                    <x-dropdown model="cards.{{ $key }}.product_id" :collection="$this->products" value="id" text="prd_code,prd_name" sClass="search" noErrors
                        placeholder="{{ __('products.product') }}" sId="dp_product_{{$key}}" /> --}}
                            
                    {{-- <x-input defer model="cards.{{ $key }}.reserved_amount" placeholder="{{ __('common.amount') }}" /> --}}

                    {{-- <x-dropdown iType="number" iModel="cards.{{ $key }}.dp_amount" iPlaceholder="{{ __('common.amount') }}" placeholder="{{ __('units.unit') }}" sClass="basic" noErrors
                        model="cards.{{ $key }}.unit_id" initnone triggerOnEvent="sp_product_selected{{ $key }}" dataSourceFunction="getUnitsProperty" value="id" text="name" 
                        sId="sp_unit_id_{{$key}}" />
                </div>
            </div>
        </x-card>
    </div>
@endforeach --}}